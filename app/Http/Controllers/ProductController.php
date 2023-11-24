<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductCreateRequest;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    function index(Request $request)
    {
        $products = Product::with(['images', 'seller.region'])
            ->withAvg('reviews as rating', 'rating')
            ->withCount('reviews')
            ->when(request('q'), function($query) {
                $query->where('name', 'like', '%' . request('q') . '%')
                ->orWhere('description', 'like', '%' . request('q') . '%')
                ->orWhereHas('seller', function($query) {
                    $query->where('name', 'like', '%' . request('q') . '%')
                    ->orWhereHas('region', function($query) {
                        $query->where('name', 'like', '%' . request('q') . '%');
                    });
                });
            })
            ->paginate(request('per_page', 20))->withQueryString();

        $users = User::with(['region'])
            ->when(request('q'), function($query) {
                $query->where('name', 'like', '%' . request('q') . '%')
                ->orWhereHas('region', function($query) {
                    $query->where('name', 'like', '%' . request('q') . '%');
                });
            })
            ->limit(5)->get();

        return view('product.index')->with(['products' => $products, 'users' => $users]);
    }

    function show(Request $request, $id)
    {
        $product = Product::with(['seller', 'images'])->where('id', $id)->first();
        if(!$product) return redirect('products'); 
        return view('product.detail')->with(['product' => $product]);
    }

    function userIndex(Request $request) 
    {
        $user = $request->user();
        $products = Product::where('seller_id', $user->id)->paginate(20)->withQueryString();
        return view('dashboard.products')->with(['products' => $products]);
    }

    function store(ProductCreateRequest $request)
    {
        $data = $request->validated();

        
    }

    function destroy(Request $request, $id)
    {

    }
}
