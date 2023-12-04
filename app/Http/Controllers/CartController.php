<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Region;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $products = $user->cart()->with('seller')->get();
        $total = $user->cart()->sum(DB::raw('price * quantity'));
        $provinces = Region::whereRaw('CHAR_LENGTH(code) = 2')->get();
        
        return view('product.cart')->with(['cart_items' => $products, 'total' => $total, 'provinces' => $provinces]);
    }

    public function addToCart(Request $request, $id)
    {
        $user = $request->user();

        $request->validate([
            'quantity' => 'required|numeric',
        ]);

        $user_cart_items = $user->cart;
        if($user_cart_items->where('id', $id)->count()) return back()->with(['cart_error' => 'Product is already in cart!']);

        $product = Product::where('id', $id)->first(['seller_id']);
        if(!$product) return redirect('products');
        
        if($user_cart_items->count() && $product->seller_id != $user_cart_items->first()->seller_id) 
            return back()->with(['cart_error' => 'Cannot add product from another seller to cart!']);
        
        $user->cart()->attach($id, ['quantity' => $request->quantity]);
        return back()->with(['cart_success' => 'Succesfully added product to cart!']);
    }

    public function editCartItem(Request $request, $id)
    {
        $user = $request->user();

        $request->validate([
            'quantity' => 'required|numeric',
        ]);

        if(!$user->cart()->where('products.id', $id)->count()) return redirect('products');
        $user->cart()->updateExistingPivot($id, [
            'quantity' => $request->quantity,
        ]);
        return back()->with(['cart_success' => 'Succesfully updated cart item!']);
    }

    public function removeFromCart(Request $request, $id)
    {
        $user = $request->user();
        if(!$user->cart()->where('products.id', $id)->count()) return redirect('products');
        $user->cart()->detach($id);
        return back()->with(['cart_success' => 'Succesfully removed product to cart!']);
    }

    public function clearCart(Request $request)
    {
        $user = $request->user();
        $user->cart()->delete();
        return back()->with(['cart_success' => 'Succesfully cleared cart!']);
    }
}
