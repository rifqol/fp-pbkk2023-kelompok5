@extends('app-layout')

@section('main')
<div class="flex flex-col gap-3 p-4 min-h-full w-full bg-green-50">
    <span class="text-2xl font-extrabold">Halo {{ Auth::user()->name }}! </span>
    <section class="flex flex-col gap-2">
        <div class="flex gap-2">
            <span class="text-2xl font-extrabold my-2"> Your Products </span>
            <a href="{{url('dashboard/products')}}" class="flex hover:cursor-pointer bg-green-400 text-white p-2 rounded-md self-center ml-auto">
                <x-heroicon-o-plus class="h-6 mr-2"/> New Product
            </a>
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
                                    {{$product->is_public ? 'Public' : 'Private'}}
                                <td class="px-6 py-4">
                                    Rp. {{number_format($product->price, thousands_separator: ".")}}
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <a href="{{url('products/' . $product->id . '/edit')}}" class="font-medium text-blue-600  hover:underline">Edit</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @endif
            </div>
            {{$products->links()}}
        </div>
    </section>
</div>
@endsection
