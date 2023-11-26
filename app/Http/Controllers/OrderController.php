<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderCreateRequest;
use App\Http\Requests\OrderMarkShippingRequest;
use App\Models\Order;
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
        Configuration::setXenditKey(config('XENDIT_SECRET_KEY'));
    }

    public function incomingOrders(Request $request)
    {
        $user = $request->user();
        $incoming_orders = $user->incomingOrders()
            ->with(['user'])
            ->withCount(['products'])
            ->paginate(20)
            ->withQueryString();
        
        return view('order.incoming-index')->with(['incoming_orders' => $incoming_orders]);
    }

    public function showIncomingOrder(Request $request, $id)
    {
        $user = $request->user();

        $incoming_order = $user->incomingOrders()
            ->with(['user', 'products'])
            ->where('id', $id)
            ->first();
        
        return view('order.incoming-detail')->with(['incoming_order' => $incoming_order]);
    }

    public function showOrder(Request $request, $id)
    {
        $user = $request->user();

        $order = $user->orders()
            ->with(['seller', 'products'])
            ->where('id', $id)
            ->first();

        return view('order.detail')->with(['order' => $order]);
    }

    public function orders(Request $request)
    {
        $user = $request->user();
        
        $orders = $user->orders()
            ->with(['seller'])
            ->withCount(['products'])
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
        ]);

        $cart_items = $user->cart->toArray();
        $cart_item_quantities =  array_map(function($item) {
            return ['quantity' => $item['pivot']['quantity']];
        }, $cart_items);

        $order->products()->attach($cart_items['id'], $cart_item_quantities);
        $order->total = $order->products()->sum(DB::raw('price * quantity'));
        $order->save();

        $user->cart()->delete();

        // Xendit
        $apiInstance = new InvoiceApi();
        $create_invoice_request = new CreateInvoiceRequest([
            'external_id' => (string) Str::uuid(),
            'description' => 'Product purchase on E-Commerce App',
            'amount' => $order->total,
            'payer_email' => $user->email,
            'currency' => 'IDR',
        ]); 

        $result = $apiInstance->createInvoice($create_invoice_request);

        $order->external_id = $create_invoice_request['external_id'];
        $order->payment_url = $result['invoice_url'];
        $order->save();

        return response()->json(['payment_url' => $result['invoice_url']]);
    }

    public function xenditNotification(Request $request)
    {
        $apiInstance = new InvoiceApi();
        $invoice = $apiInstance->getInvoices(null, $request->external_id)[0];
        $order = Order::where('external_id', $request->external_id)->first();

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
        if($order->status != 'Paid') return redirect('orders');

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
}
