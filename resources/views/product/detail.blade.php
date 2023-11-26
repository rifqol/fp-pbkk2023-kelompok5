@extends('app-layout')

@section('main')
<style>
    .carousel {
        scroll-snap-type: x mandatory;
    }

    .carousel .item{
        scroll-snap-align: center;
    }
</style>
<div class="flex flex-col gap-3 p-4 min-h-full w-full bg-green-50">
    <section class="flex flex-col gap-2">
        <span class="text-2xl font-extrabold">Product Detail</span>
        <div class="flex bg-white rounded-md p-2 gap-4 shadow-md">
            <ul class="carousel flex bg-green-50 max-w-[25%] h-[20rem] overflow-x-hidden rounded-md p-2 gap-4 shadow-md" id="img-carousel">
                @foreach ($product->images->toArray() as $image)
                <li class="item w-full flex-shrink-0">
                    <img src="{{ $image['image_url'] }}" class="h-full w-auto drop-shadow-lg mx-auto object-contain">
                </li>
                @endforeach
            </ul>
            <div class="flex flex-col w-full">
                <div class="border-b-[1px]">
                    <h1 class="text-2xl">{{ $product->name }}</h1>
                    <h2 class="flex">{{$product->reviews_count}} Reviews <p class="flex text-yellow-400 ml-2"><x-heroicon-s-star class="h-5"/> {{ round($product->rating, 2) }}</p></h2>
                    <h1 class="text-3xl font-extrabold my-2">Rp {{ number_format($product->price, thousands_separator: ".") }}</h1>
                </div>
                <div class="py-2 border-b-[1px]">
                    <h2>Type: {{ $product->type }}</h2>
                    <h2 class="mb-4">Condition: {{ $product->condition }}</h2>
                    <p>{{ $product->description }}</p>
                </div>
                <div class="pt-2">
                    <h1>Seller</h1>
                    <div class="flex gap-2">
                        <img class="rounded-full w-12 h-12 object-cover shadow-md" src="{{$product->seller->photo_url}}" alt="">
                        <a class="self-center text-md">{{$product->seller->name}}</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="flex flex-col gap-2">
        <span class="text-2xl font-extrabold">Product Reviews</span>
        <ul class="flex flex-col bg-white rounded-md p-4 shadow-md max-h-screen overflow-y-auto">
            @foreach ($product->reviews as $review)
            <li class="{{!$loop->last ? 'border-b-[1px]' : ''}} py-2">
                <div class="flex gap-0">
                    @for ($i = 0; $i < $review->rating; $i++)
                    <x-heroicon-s-star class="h-6 text-yellow-400"/>
                    @endfor
                </div>
                <div class="flex gap-2 py-2">
                    <img class="rounded-full w-10 h-10 object-cover shadow-md" src="{{$product->seller->photo_url}}" alt="">
                    <a class="self-center text-md">{{$product->seller->name}}</a>
                </div>
                <p>{{ $review->review }}</p>
            </li>
            @endforeach
        </ul>
    </section>
</div>
<script>
    let imageCarousel = document.getElementById("img-carousel");
    imageCarousel.addEventListener('wheel', function(event) {
        event.preventDefault();
        imageCarousel.style.scrollBehavior = 'smooth';
        imageCarousel.scrollLeft += event.deltaY * 5
    });
</script>
@endsection
