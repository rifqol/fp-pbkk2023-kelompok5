@extends('app-layout')

@section('main')

<style>
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

<div class="flex flex-col p-4 min-h-full bg-green-50">
    <section class="flex flex-1 flex-col h-full gap-2">
        <span class="font-extrabold text-xl my-2">Your Cart</span>
        @if ($message = session('cart_success'))
        <span class="flex flex-row bg-green-200 rounded-md ring-1 ring-green-900 text-green-900 p-4" onclick="">
            {{ $message }} <button class="ml-auto font-extrabold" onclick="this.parentNode.remove()">X</button>
        </span>
        @endif
        @if ($message = session('cart_error'))
        <span class="flex flex-row bg-green-200 rounded-md ring-1 ring-green-900 text-green-900 p-4" onclick="">
            {{ $message }} <button class="ml-auto font-extrabold" onclick="this.parentNode.remove()">X</button>
        </span>
        @endif
        <div class="flex flex-1 h-full bg-white shadow-md p-4 rounded-md gap-2">
            <ul class="flex flex-col w-full h-full">
                @foreach ($cart_items as $item)
                <li class="flex gap-4 py-2 border-b-[1px]">
                    <img class="object-cover rounded-md h-[10vw] self-center" src="{{ $item->images->toArray()[0]['image_url'] }}">
                    <div class="flex flex-col w-full">
                        <span class="flex h-full w-full">
                            <div class="flex flex-col flex-1 h-full">
                                <h1>{{ $item->name }}</h1>
                                <h2 class="mt-auto">Rp. {{ number_format($item->price, thousands_separator: ".") }}</h2>
                            </div>
                            <div class="flex flex-col gap-2">
                                <form action="{{ url('products/' . $item->id . '/removecart') }}" method="POST">
                                    @csrf
                                    <button class="flex gap-2 text-white bg-red-500 p-2 rounded-md ml-auto" type="submit">
                                        <x-heroicon-o-trash class="h-6"/>
                                    </button>
                                </form>
                                <form class="flex flex-col gap-2 self-center ml-auto" action="{{ url('products/' . $item->id . '/editcart') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <label for="quantity">Quantity</label>
                                    <div class="flex flex-col xl:flex-row gap-2">
                                        <button type="button" onclick="this.nextElementSibling.stepDown()" class="bg-green-500 rounded-md text-white">
                                            <x-heroicon-o-minus-small class="h-6"/>
                                        </button>
                                        <input class="rounded-md ring-gray-500 ring-2 p-2 bg-gray-100 drop-shadow-lg w-[10rem]" type="number" name="quantity" id="quantity" value="{{ $item->pivot->quantity }}" min="1" step="1" onchange="this.value = Math.max(0, Math.min({{$item->stock}}, parseInt(this.value)));">
                                        <button type="button" onclick="this.previousElementSibling.stepUp()" class="bg-green-500 rounded-md text-white">
                                            <x-heroicon-o-plus-small class="h-6"/>
                                        </button>
                                    </div>
                                    <button type="submit" class="flex bg-green-500 text-white rounded-md p-2 gap-2">
                                        Confirm
                                    </button>
                                </form>
                            </div>
                        </span>
                    </div>
                </li>
                @endforeach
            </ul>
            <div class="flex flex-col w-[30rem]">
                <div class="flex flex-col gap-2 bg-green-50 p-2 rounded-md shadow-md">
                    @if ($cart_items->count())
                    <div class="flex flex-col gap-2 py-2 bg-white p-2 rounded-md shadow-md">
                        <h1>Seller</h1>
                        <div class="flex flex gap-2 py-2">
                            <img class="rounded-full w-10 h-10 object-cover shadow-md" src="{{$cart_items->toArray()[0]['seller']['photo_url']}}" alt="">
                            <a class="self-center text-md">{{$cart_items->toArray()[0]['seller']['name']}}</a>
                        </div>
                    </div> 
                    @endif
                    <div class="flex flex-col gap-2 py-2 bg-white p-2 rounded-md shadow-md">
                        <h1>Total Price</h1>
                        <h1>Rp. {{ number_format($total, thousands_separator: ".") }}</h1>
                    </div>
                    <div class="flex flex-col gap-2 py-2 bg-white p-2 rounded-md shadow-md">
                        <form class="flex flex-col mt-2" action="{{ url('orders/create') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <label for="region_code"> Location</label>
                            <div class="flex flex-row gap-5">
                                <select id="province_select" class="rounded-md ring-gray-500 ring-2 p-2 bg-gray-100 drop-shadow-lg w-full mb-4">
                                    <option value="">Select Province</option>
                                    @foreach ($provinces as $province)
                                    <option value="{{$province->code}}">{{$province->name}}</option>
                                    @endforeach
                                </select>
                                <select id="regency_select" class="rounded-md ring-gray-500 ring-2 p-2 bg-gray-100 drop-shadow-lg w-full mb-4" name="region_code">
                                    <option value="">Select Regency</option>
                                </select>
                            </div>
                            <label class="" for="shipment_address">Shipment Address</label>
                            <input type="text" name="shipment_address" class="rounded-md ring-gray-500 ring-2 p-2 bg-gray-100 drop-shadow-lg w-full mb-4" value="{{ old('shipment_address') }}" id="shipment_address" placeholder="Enter Shipment Address...">
                            @error('name')
                                <h5 class="text-red-400 font-thin text-sm mt-[-0.5rem]">{{ $message }}</h5>
                            @enderror
                            <button class="bg-green-500 text-white rounded-md p-1 text-sm" type="submit">Order</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<script>
    $(document).ready(function() {
        $("#province_select").on("change", function (event) {
            $("#regency_select").children().not(":first").remove();
            $.ajax({
                type: "GET",
                url: "{{ url('regions') . '?code='}}" + this.value, 
            }).done(function (data) {
                console.log(data);
                $("#regency_select").append(data);
            });
        });
    });
</script>
@endsection
