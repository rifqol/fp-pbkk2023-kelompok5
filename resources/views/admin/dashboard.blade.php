@extends('app-layout')

@section('main')
<div class="flex flex-col gap-3 p-4 min-h-full w-full bg-green-50">
    <span class="text-2xl font-extrabold">Halo {{ Auth::user()->name }}! </span>
    <section class="flex flex-col">
        <span class="text-2xl font-extrabold my-2"> Dashboard </span>
        <div class="flex gap-2">
            <div class="flex flex-col bg-white rounded-md shadow-md w-full p-6">
                <h1 class="text-2xl font-extrabold">{{ $public_product_count }}</h1>
                <p>Public Products</p>
                <a class="bg-green-500 text-white rounded-md p-2 text-center w-fit mt-5" href="{{ url('admin/product') }}">View All</a>
            </div>
            <div class="flex flex-col bg-white rounded-md shadow-md w-full p-6">
                <h1 class="text-2xl font-extrabold">{{ $order_count }}</h1>
                <p>Orders</p>
                <a class="bg-green-500 text-white rounded-md p-2 text-center w-fit mt-5" href="{{ url('admin/order') }}">View All</a>
            </div>
            <div class="flex flex-col bg-white rounded-md shadow-md w-full p-6">
                <h1 class="text-2xl font-extrabold">Rp {{ number_format($total_income, thousands_separator: '.') }}</h1>
                <p>Income</p>
                <a class="bg-green-500 text-white rounded-md p-2 text-center w-fit mt-5" href="{{ url('admin/order') }}">View All</a>
            </div>
            <div class="flex flex-col bg-white rounded-md shadow-md w-full p-6">
                <h1 class="text-2xl font-extrabold">{{ $user_count }}</h1>
                <p>Users</p>
                <a class="bg-green-500 text-white rounded-md p-2 text-center w-fit mt-5" href="{{ url('admin/user') }}">View All</a>
            </div>
        </div>
    </section>
</div>
@endsection
