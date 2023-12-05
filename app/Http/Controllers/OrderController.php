<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderCreateRequest;
use App\Http\Requests\OrderMarkShippingRequest;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Xendit\Configuration;
use Xendit\Invoice\InvoiceApi;
use Illuminate\Support\Str;
use Xendit\Invoice\CreateInvoiceRequest;

class OrderController extends Controller
{
    public function __construct()
    {
        Configuration::setXenditKey(config('xendit.api_key'));
    }

    public function incomingOrders(Request $request)
    {
        $user = $request->user();
        $incoming_orders = $user->incomingOrders()
            ->with(['user'])
            ->withCount(['products'])
            ->latest()
            ->when(request('search'), function($query) {
                $query->where('id', 'like', '%' . request('search') . '%')
                ->orWhereHas('user', function($query) {
                    $query->where('name', 'like', '%' . request('search') . '%');
                });
            })
            ->paginate(20)
            ->withQueryString();
        
        return view('dashboard.orders')->with(['incoming_orders' => $incoming_orders]);
    }

    public function showIncomingOrder(Request $request, $id)
    {
        $user = $request->user();

        $incoming_order = $user->incomingOrders()
            ->with(['user', 'products', 'region'])
            ->where('id', $id)
            ->first();
        
        return view('order.incoming-detail')->with(['incoming_order' => $incoming_order]);
    }

    public function showOrder(Request $request, $id)
    {
        $user = $request->user();

        $order = $user->orders()
            ->with(['seller', 'products', 'products.reviews' => function($query) use($user) {
                $query->where('user_id', $user->id);
            }])
            ->where('id', $id)
            ->first();

        return view('order.detail')->with(['order' => $order]);
    }

    public function adminShowOrder($id)
    {
        $order = Order::with(['user', 'user.region', 'products', 'region'])
            ->where('id', $id)
            ->first();

        return view('order.admin-detail')->with(['order' => $order]);
    }

    public function orders(Request $request)
    {
        $user = $request->user();
        
        $orders = $user->orders()
            ->with(['seller'])
            ->withCount(['products'])
            ->latest()
            ->when(request('search'), function($query) {
                $query->where('id', 'like', '%' . request('search') . '%')
                ->orWhereHas('seller', function($query) {
                    $query->where('name', 'like', '%' . request('search') . '%');
                });
            })
            ->paginate(20)
            ->withQueryString();

        return view('order.index')->with(['orders' => $orders]);
    }

    public function store(OrderCreateRequest $request)
    {
        $user = $request->user();

        $data = $request->validated();

        $order = Order::create([
            'status' => 'Pending',
            'shipment_address' => $data['shipment_address'],
            'region_code' => $data['region_code'],
            'user_id' => $user->id,
            'seller_id' => $user->cart()->first()->seller_id,
        ]);

        $cart_items = $user->cart->toArray();
        $cart_items =  array_map(function($item) {
            return [$item['id'] => ['quantity' => $item['pivot']['quantity']]];
        }, $cart_items);


        foreach ($cart_items as $value)
        {
            $order->products()->attach($value);

            // Decrement stock for each product
            $product_id = array_keys($value)[0];
            $product = Product::where('id', $product_id)->first();
            $product->stock -= $value[$product_id]['quantity'];
            $product->save();
        }

        
        $order->total = $order->products()->sum(DB::raw('price * quantity'));
        $order->save();

        $user->cart()->detach();

        // Xendit
        $apiInstance = new InvoiceApi();
        $create_invoice_request = new CreateInvoiceRequest([
            'external_id' => (string) Str::uuid(),
            'description' => 'Product purchase on E-Commerce App',
            'amount' => $order->total,
            'payer_email' => $user->email,
            'currency' => 'IDR',
            'success_redirect_url' => url('orders/'. $order->id),
            'failure_redirect_url' => url('orders/'. $order->id),
        ]); 

        $result = $apiInstance->createInvoice($create_invoice_request);

        $order->external_id = $create_invoice_request['external_id'];
        $order->payment_url = $result['invoice_url'];
        $order->save();

        return redirect('orders/' . $order->id);
    }

    public function xenditNotification(Request $request)
    {
        $apiInstance = new InvoiceApi();
        $invoice = $apiInstance->getInvoices(null, $request->external_id)[0];
        $order = Order::where('external_id', $request->external_id)->first();

        if($order->status == 'Cancelled')
        {
            return response()->json('Success');
        }

        switch($invoice['status'])
        {
            case 'PENDING':
                $order->status = 'Pending';
                break;
            case 'PAID':
                $order->status = 'Paid';
                break;
            case 'SETTLED':
                $order->status = 'Paid';
                break;
            case 'EXPIRED':
                $order->status = 'Cancelled';
                // Increment product stock
                $order->products()->each(function($product) {
                    $product->stock += $product->pivot->quantity;
                    $product->save();
                });
                break;
        }
        
        $order->save();

        return response()->json('Success');
    }

    public function markShipping(OrderMarkShippingRequest $request, $id)
    {
        $user = $request->user();
        $data = $request->validated();
        $order = Order::where('id', $id)->first();
 
        if(!$order || $order->seller_id != $user->id && !$user->is_admin) return redirect('orders');
        if($order->status != 'Paid' && $order->status != 'Shipping') return redirect('orders');

        $order->tracking_number = $data['tracking_number'];
        $order->status = 'Shipping';
        $order->save();

        return back()->with(['order_success' => 'Order marked as shipping!']);
    }

    public function markComplete(Request $request, $id)
    {
        $user = $request->user();

        $order = Order::where('id', $id)->first();
        if(!$order || $order->seller_id != $user->id && !$user->is_admin) return redirect('orders');
        if($order->status != 'Shipping') return redirect('orders');

        $order->status = 'Complete';
        $order->save();

        return back()->with(['order_success' => 'Order marked as complete!']);
    }

    public function adminMarkShipping(OrderMarkShippingRequest $request, $id)
    {
        $data = $request->validated();
        $order = Order::where('id', $id)->first();
 
        if(!$order) return redirect('orders');

        $order->tracking_number = $data['tracking_number'];
        $order->status = 'Shipping';
        $order->save();

        return back()->with(['order_success' => 'Order marked as shipping!']);
    }

    public function adminMarkPending(Request $request, $id)
    {
        $order = Order::where('id', $id)->first();
        if(!$order) return redirect('orders');

        $order->status = 'Pending';
        $order->save();

        return back()->with(['order_success' => 'Order marked as paid!']);
    }

    public function adminMarkComplete(Request $request, $id)
    {
        $order = Order::where('id', $id)->first();
        if(!$order) return redirect('orders');

        $order->status = 'Complete';
        $order->save();

        return back()->with(['order_success' => 'Order marked as complete!']);
    }

    public function adminMarkPaid(Request $request, $id)
    {
        $order = Order::where('id', $id)->first();
        if(!$order) return redirect('orders');

        $order->status = 'Paid';
        $order->save();

        return back()->with(['order_success' => 'Order marked as paid!']);
    }


    public function adminMarkCancelled(Request $request, $id)
    {
        $order = Order::where('id', $id)->first();
        if(!$order) return redirect('orders');

        // Increment product stock
        $order->products()->each(function($product) {
            $product->stock += $product->pivot->quantity;
            $product->save();
        });

        $order->status = 'Cancelled';
        $order->save();

        return back()->with(['order_success' => 'Order marked as cancelled!']);
    }
}
