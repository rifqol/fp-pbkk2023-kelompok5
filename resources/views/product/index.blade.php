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
</style>

<div class="product-grid">
    @foreach ($products as $product)
        <div class="flex flex-col border text-center p-2 rounded-md">
            <img src="{{ $product->images[0]['image_url'] }}" class="w-full h-32 object-cover mb-4">
            <a href="{{ url('products/' . $product->id) }}" class="text-lg font-semibold">{{ $product->name }}</a>
            <div class="flex self-center">
                <x-heroicon-s-map-pin class="h-5"/> {{ \Illuminate\Support\Str::limit($product->seller->region->name, 50) }}
            </div>
            <div class="self-center">
                <div class="flex">
                    <p class="mr-2">{{$product->reviews_count}} Reviews</p> <p class="flex text-yellow-400"><x-heroicon-s-star class="h-5"/> {{ round($product->rating, 2) }}</p>
                </div>
            </div>
            <p class="text-green-500">Rp. {{ number_format($product->price, thousands_separator: ".") }}</p>
        </div>
    @endforeach
</div>


@endsection
