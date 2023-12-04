@extends('app-layout')

@section('main')
<style>
    .carousel {
        scroll-snap-type: x mandatory;
    }

    .carousel .item{
        scroll-behavior: smooth;
        scroll-snap-align: center;
    }

    .next, .prev {
        transition: 0.1s
    }

    /* Chrome, Safari, Edge, Opera */
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
    }

    /* Firefox */
    input[type=number] {
    -moz-appearance: textfield;
    }
</style>
<div class="flex flex-col gap-3 p-4 min-h-full w-full bg-green-50">
    <section class="flex flex-col gap-2">
        <span class="text-2xl font-extrabold">Product Detail</span>
        <div class="flex bg-white rounded-md p-2 gap-4 shadow-md">
            <div class="flex flex-col max-w-[25%]">
                <div class="flex relative">
                    <button class="next absolute top-[45%] right-0 bg-gray-700 bg-opacity-0 hover:bg-opacity-50 rounded-full p-2 z-10">
                        <x-heroicon-o-chevron-right class="h-8 text-gray-300"/>
                    </button>
                    <button class="prev absolute top-[45%] left-0 bg-gray-700 bg-opacity-0 hover:bg-opacity-50 rounded-full p-2 z-10">
                        <x-heroicon-o-chevron-left class="h-8 text-gray-300"/>
                    </button>
                    <ul class="carousel flex bg-green-50 w-full h-[20rem] overflow-x-hidden rounded-md p-2 gap-4 shadow-md" id="img-carousel">
                        @foreach ($product->images->toArray() as $image)
                        <li class="item w-full flex-shrink-0">
                            <img src="{{ $image['image_url'] }}" class="h-full w-auto drop-shadow-lg mx-auto object-contain">
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
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
            <div class="flex flex-col w-1/2">
                <form class="flex flex-col gap-2" action="{{ url('products/' . $product->id . '/addtocart') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <label for="quantity">Quantity</label>
                    <div class="flex flex-col lg:flex-row gap-2">
                        <button type="button" onclick="this.nextElementSibling.stepDown()" class="bg-green-500 rounded-md text-white">
                            <x-heroicon-o-minus-small class="h-6"/>
                        </button>
                        <input class="rounded-md ring-gray-500 ring-2 p-2 bg-gray-100 drop-shadow-lg w-full" type="number" name="quantity" id="quantity" value="1" min="1" step="1" onchange="this.value = Math.max(0, Math.min({{$product->stock}}, parseInt(this.value)));">
                        <button type="button" onclick="this.previousElementSibling.stepUp()" class="bg-green-500 rounded-md text-white">
                            <x-heroicon-o-plus-small class="h-6"/>
                        </button>
                        <h2 class="w-full self-center">Total Stock: {{ $product->stock }}</h2>
                    </div>
                    <button type="submit" class="flex bg-green-500 text-white rounded-md p-2 gap-2">
                        <x-heroicon-o-shopping-cart class="h-6"/>
                        Add To Cart
                    </button>
                </form>
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
    let imageCarousel = document.getElementById('img-carousel');
    let imageCarouselItems = document.querySelectorAll('.carousel .item');
    let nextButton = document.querySelector('.next');
    let prevButton = document.querySelector('.prev');
    let currentIndex = 0;

    nextButton.addEventListener('click', function(event) {
        currentIndex += 1;
        currentIndex = currentIndex % imageCarouselItems.length;
        imageCarouselItems[currentIndex].scrollIntoView({
            behavior: 'smooth',
            block: 'nearest'
        });
    });

    prevButton.addEventListener('click', function(event) {
        currentIndex -= 1;
        if(currentIndex < 0) currentIndex = imageCarouselItems.length - 1;
        imageCarouselItems[currentIndex].scrollIntoView({
            behavior: 'smooth',
            block: 'nearest'
        });
    });

    imageCarousel.addEventListener('wheel', function(event) {
        event.preventDefault();
        if(event.deltaY > 0) currentIndex += 1;
        else currentIndex -= 1;
        if(currentIndex < 0) currentIndex = imageCarouselItems.length - 1;
        currentIndex = currentIndex % imageCarouselItems.length;

        imageCarouselItems[currentIndex].scrollIntoView({
            behavior: 'smooth',
            block: 'nearest'
        });
    });
</script>
@endsection
