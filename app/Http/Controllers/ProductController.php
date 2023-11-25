<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductCreateRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::with(['images', 'seller.region'])
            ->withAvg('reviews as rating', 'rating')
            ->withCount('reviews')
            ->where('is_deleted', false)
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

    public function show(Request $request, $id)
    {
        $user = $request->user();
        $product = Product::with(['seller', 'images'])->where('id', $id)->first();
        if(!$product || ($product->is_deleted && !$user->is_admin) ) return redirect('products'); 
        return view('product.detail')->with(['product' => $product]);
    }

    public function userIndex(Request $request) 
    {
        $user = $request->user();
        $products = Product::where('is_deleted', 0)->where('seller_id', $user->id)->paginate(20)->withQueryString();
        return view('dashboard.products')->with(['products' => $products]);
    }

    public function create()
    {
        return view('product.create');
    }

    public function edit(Request $request, $id)
    {
        $user = $request->user();
        $product = Product::with(['images'])->where('id', $id)->first();
        if(!$product || ($product->is_deleted == true || $product->seller_id != $user->id) && !$user->is_admin) return redirect('dashboard/product');
        return view('product.edit')->with(['product' => $product]);
    }

    public function update(ProductUpdateRequest $request, $id)
    {
        $user = $request->user();
        $data = $request->validated();
        $product = Product::where('id', $id)->first();
        if(!$product || ($product->is_deleted == true || $product->seller_id != $user->id) && !$user->is_admin) return redirect('dashboard/product');

        $product->update($data);

        return back()->with(['edit_success' => 'Succesfuly updated product!']);
    }

    public function store(ProductCreateRequest $request)
    {
        $user = $request->user();
        $data = $request->validated();

        $product = Product::create([
            'name' => $data['name'],
            'type' => $data['type'],
            'condition' => $data['condition'],
            'description' => $data['description'],
            'price' => $data['price'],
            'stock' => $data['stock'],
            'seller_id' => $user->id,
        ]);

        $path = Storage::put('public/images', $data['image']);

        $product->images()->create([
            'image_url' => url(Storage::url($path)),
        ]);

        return redirect('dashboard/product')->with(['success' => 'Succesfully added product!']);
    }

    public function destroy(Request $request, $id)
    {
        $user = $request->user();
        $product = Product::where('id', $id)->first();
        if(!$product || ($product->is_deleted == true || $product->seller_id != $user->id) && !$user->is_admin) return redirect('dashboard/product');

        $product->is_deleted = true;
        $product->save();

        return redirect('dashboard/product')->with(['success' => 'Succesfully removed product!']);
    }
}
