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
    <span class="text-2xl font-extrabold">User Detail</span>

    <div class="bg-green-50">
        <div class="flex items-center justify-start">
            <img src="{{ $user->photo_url }}" alt="Profile Photo" class="w-24 h-24 rounded-full object-cover shadow-md ml-2">
            <div class="flex flex-col ml-4">
                <h1 class="text-2xl font-bold">{{ $user->name }}</h1>
            </div>
        </div>

    <div class="flex flex-col gap-2 bg-white rounded-md p-2 shadow-md mt-4">
        
        <div class="flex items-center justify-start">
            <h2 class="text-xl font-bold ml-3">Data User</h2>
            
            <div class="text-md flex ml-3">
                <a href="{{ url('/chats/'. $user->id)}}" class="{{ (request()->is('chats')) || request()->is('chats/*') ? 'bg-green-500 text-white' : 'bg-white'}} flex items-center justify-center rounded-md p-2 ml-2 shadow-md hover:ring-2 hover:ring-green-900" style="flex-basis: 25%;">
                    <div class="flex items-center">
                        <x-heroicon-o-pencil-square class="w-5 h-auto"/>
                     </div>
                </a>

                <a href="{{ url('/chats/'. $user->id)}}" class="{{ (request()->is('chats')) || request()->is('chats/*') ? 'bg-green-500 text-white' : 'bg-white'}} flex items-center justify-center rounded-md p-2 ml-2 shadow-md hover:ring-2 hover:ring-green-900" style="flex-basis: 25%;">
                    <div class="flex items-center">
                        <x-heroicon-o-chat-bubble-oval-left-ellipsis class="w-5 h-auto"/>
                    </div>
                </a>
            </div>
        </div>
        <div class="flex items-center justify start ml-3 mt-3">
            <x-heroicon-o-envelope class="w-8 h-auto"/>
            <div class="text-md flex flex-col ml-3">
                <p class="font-bold">{{ $user->email }}</p>
                <p class="text-gray-600">Email Address</p>
            </div>
        </div>

        <div class="flex items-center justify start ml-3 mt-3">
            <x-heroicon-s-map-pin class="w-8 h-auto"/>
            <div class="text-md flex flex-col ml-3">
                <p class="font-bold">{{ $user->region->name }}</p>
                <p class="text-gray-600">Region</p>
            </div>
        </div>

        <div class="flex items-center justify start ml-3 mt-3">
            <x-heroicon-o-phone class="w-8 h-auto"/>
            <div class="text-md flex flex-col ml-3">
                <p class="font-bold">{{ $user->phone }}</p>
                <p class="text-gray-600">Phone Number</p>
            </div>
        </div>

        <div class="flex items-center justify start ml-3 mt-3">
            <x-heroicon-o-building-library class="w-8 h-auto"/>
            <div class="text-md flex flex-col ml-3">
                <p class="font-bold">{{ $user->bank_actnumber }}</p>
                <p class="text-gray-600">Bank Account</p>
            </div>
        </div>
    </div>

    <div class="flex flex-col gap-2 bg-white rounded-md p-2 shadow-md mt-4">
        <h2 class="text-xl font-bold ml-3 mt-3">User Product</h2>

                @if ($products->count() == 0)
                <div class="flex flex-col gap-4 self-center my-auto">
                    <span class="self-center text-gray-500 text-lg"> You don't have any products for sale yet... </span>
                    <button class="self-center bg-green-400 text-white p-2 rounded-md">Add Product</button>
                </div>
                @else
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 ">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-100 ">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    Product name
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Stock
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Status
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Price
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $product)
                            <tr class="bg-white border-b ">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap ">
                                    {{$product->name}}
                                </th>
                                <td class="px-6 py-4">
                                    {{$product->stock}}
                                </td>
                                <td class="px-6 py-4">
                                    {{$product->is_public ? 'Public' : 'Draft'}}
                                <td class="px-6 py-4">
                                    Rp. {{number_format($product->price, thousands_separator: ".")}}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @endif
    </div>

    </div>
</div>

@endsection
