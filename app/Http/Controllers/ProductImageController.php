<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductImageController extends Controller
{
    public function store(Request $request, $id)
    {
        $user = $request->user();

        $request->validate([
            'image' => 'required|mimes:jpg,png,jpeg|max:2048',
        ]);

        $product = Product::where('id', $id)->first();
        if(!$product || ($product->seller_id != $user->id && !$user->is_admin)) return redirect('dashboard/product');

        $path = Storage::put('public/images', $request->image);

        $product->images()->create([
            'image_url' => url(Storage::url($path)),
        ]);

        return redirect('dashboard/product/' . $product->id . '/edit#product_images')->with(['img_success' => 'Succesfully added image!']);
    }

    public function destroy(Request $request, $id)
    {
        $user = $request->user();

        $image = ProductImage::with(['product'])->where('id', $id)->first();

        if(!$image || ($image->product->seller_id != $user->id && !$user->is_admin)) return redirect('dashboard/product');

        $image->delete();

        return redirect('dashboard/product/' . $image->product->id . '/edit#product_images')->with(['img_success' => 'Succesfully removed image!']);
    }
}
