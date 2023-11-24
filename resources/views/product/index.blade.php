@extends('app-layout')

@section('main')

<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="flex flex-col p-4 min-h-full bg-green-50">
    <form>
        <div class="flex gap-2">
            <input type="text" class="p-2 border rounded-md w-full" name="q">
            <button type="submit" class="p-2 border rounded-md bg-green-400 text-white w-1/12">Search</button>
        </div>
    </form>
    <section id="users_list" class="flex flex-col">
        <span class="font-extrabold text-xl my-2">Users</span>
        <div class="bg-white shadow-md p-4 rounded-md">
            @if ($users->count() == 0)
            <span>Oops... We didn't find what you are looking for.</span>
            @else
            <div class="grid gap-5 sm:grid-cols-1 md:grid-cols-3 lg:grid-cols-5">
            @foreach ($users as $user)
                <div class="flex border text-center rounded-md shadow-md bg-white p-4">
                    <img src="{{$user->photo_url}}" class="h-20 w-20 self-center rounded-full object-cover">
                    <div class="flex flex-col self-center ml-auto">
                        <span>{{$user->name}}</span>
                        <span class="flex self-center gap-2">
                            <x-heroicon-s-map-pin class="h-5"/> {{ \Illuminate\Support\Str::limit($user->region->name, 50) }}
                        </span>
                    </div>
                </div>
            @endforeach
            </div>
            @endif
        </div>
    </section>
    <section id="products_list" class="flex flex-col">
        <span class="font-extrabold text-xl my-2">Products</span>
        <div class="bg-white shadow-md p-4 rounded-md mb-5">
            @if ($products->count() == 0)
            <span>Oops... We didn't find what you are looking for.</span>
            @else
            <div class="grid gap-5 sm:grid-cols-1 md:grid-cols-3 lg:grid-cols-5">
            @foreach ($products as $product)
                <div class="flex flex-col border text-center rounded-md shadow-md bg-white">
                    <img src="{{ $product->images[0]['image_url'] }}" class="w-full h-32 object-cover rounded-t-md mb-4">
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
            @endif
        </div>
    </section>
    <nav class="mt-auto mb-2">
        {{ $products->links() }}
    </nav>
</div>
@endsection
