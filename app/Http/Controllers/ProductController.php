<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    function index(Request $request)
    {
        $products = Product::with(['images'])->withAvg('reviews as rating', 'rating')->paginate(request('per_page', 10));
        return view('product.index')->with(['products' => $products]);
    }
}
