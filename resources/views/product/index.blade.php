@extends('app-layout')

@section('main')

<meta name="csrf-token" content="{{ csrf_token() }}">

<style>
    /* Tambahkan CSS untuk produk grid 5x5 */
    .product-grid {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        gap: 10px;
        padding: 5px;
    }

    .product-card {
        border: 1px solid #ddd;
        padding: 5px;
        text-align: center;
    }
</style>

<div class="product-grid">
    @foreach ($products as $product)
        <div class="product-card">
            <img src="{{$product->images[0]['image_url']}}" class="w-full h-32 object-cover mb-4">
            <h2 class="text-lg font-semibold">{{ $product->name }}</h2>
            <p class="text-gray-600">{{ \Illuminate\Support\Str::limit($product->description, 50) }}</p>
            <p class="text-green-500">Rp.{{ $product->price }}</p>
        </div>
    @endforeach
</div>


@endsection
