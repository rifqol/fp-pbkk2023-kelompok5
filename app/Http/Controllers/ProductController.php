<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductCreateRequest;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    function index(Request $request)
    {
        $products = Product::with(['images'])
            ->withAvg('reviews as rating', 'rating')
            ->withCount('reviews')
            ->paginate(request('per_page', 10));
        return view('product.index')->with(['products' => $products]);
    }

    function show(Request $request, $id)
    {
        $product = Product::with(['seller', 'images'])->where('id', $id)->first();
        if(!$product) return redirect('products'); 
        return view('product.detail')->with(['product' => $product]);
    }

    function store(ProductCreateRequest $request)
    {
        $data = $request->validated();


    }
}
