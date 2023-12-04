@extends('app-layout')

@section('main')
<div class="flex flex-col gap-3 p-4 min-h-full w-full bg-green-50">
    <span class="text-2xl font-extrabold">Halo {{ Auth::user()->name }}! </span>
    <section class="flex flex-col">
        <div class="flex divide-x-2 gap-2">
            <span class="text-2xl font-extrabold my-2"> Your Products </span>
            <a href="{{url('dashboard/product')}}" class="hover:cursor-pointer text-green-400 self-center pl-2">View all</a>
        </div>
        <div class="bg-white shadow-md p-4 rounded-md">
            <div class="flex flex-col min-h-[10rem] gap-2">
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
                                <th scope="col" class="px-6 py-3">
                                    <span class="sr-only">Edit</span>
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
                                <td class="px-6 py-4 text-right">
                                    <a href="{{url('dashboard/product/' . $product->id . '/edit')}}" class="font-medium text-blue-600  hover:underline">Edit</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @endif
            </div>
        </div>
    </section>
    <section class="flex flex-col">
        <div class="flex divide-x-2 gap-2">
            <span class="text-2xl font-extrabold my-2"> Incoming Orders </span>
            <a href="{{url('dashboard/order')}}" class="hover:cursor-pointer text-green-400 self-center pl-2">View all</a>
        </div>
        <div class="bg-white shadow-md p-4 rounded-md">
            <div class="flex flex-col min-h-[10rem]">
                @if (!$incoming_orders)
                <span class="self-center my-auto text-gray-500 text-lg"> No pending orders for now... </span>
                @else
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 ">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-100 ">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    Order Id
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Buyer Name
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Shipment Address
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Status
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Total
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    <span class="sr-only">Edit</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($incoming_orders as $incoming_order)
                            <tr class="bg-white border-b ">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap ">
                                    {{$incoming_order->id}}
                                </th>
                                <td class="px-6 py-4">
                                    {{$incoming_order->user->name}}
                                </td>
                                <td class="px-6 py-4">
                                    {{$incoming_order->shipment_address}}
                                </td>
                                <td class="px-6 py-4">
                                    {{$incoming_order->status}}
                                <td class="px-6 py-4">
                                    Rp. {{number_format($incoming_order->total, thousands_separator: ".")}}
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <a href="{{url('dashboard/order/' . $incoming_order->id . '/edit')}}" class="font-medium text-blue-600  hover:underline">Edit</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @endif
            </div>
        </div>
    </section>
</div>
@endsection
