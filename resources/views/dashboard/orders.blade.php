@extends('app-layout')

@section('main')
<div class="flex flex-col gap-3 p-4 min-h-full w-full bg-green-50">
    <span class="text-2xl font-extrabold">Halo {{ Auth::user()->name }}! </span>
    <section class="flex flex-col gap-2">
        <div class="flex gap-2">
            <span class="text-2xl font-extrabold my-2">Your Incoming Orders</span>
            <form class="flex items-center gap-2 flex-grow justify-end"> 
                <input type="text" class="p-2 border rounded-md w-50" name="search">
                <button type="submit" class="flex gap-2 bg-green-500 rounded-md p-2 items-center justify-center">
                    <x-heroicon-o-magnifying-glass class="h-5 text-white"/>
                </button>
            </form>
        </div>
        @if ($message = session('success'))
        <span class="flex flex-row bg-green-200 rounded-md ring-1 ring-green-900 text-green-900 p-4" onclick="">
            {{ $message }} <button class="ml-auto font-extrabold" onclick="this.parentNode.remove()">X</button>
        </span>
        @endif
        <div class="bg-white shadow-md p-4 rounded-md">
            <div class="flex flex-col min-h-[10rem] gap-2">
                @if (request('search') != null)
                    <span class="self-center my-auto text-gray-500 text-lg"> Can't find what you are looking for... </span>
                @elseif ($incoming_orders->count() == 0)
                <div class="flex flex-col gap-4 self-center my-auto">
                    <span class="self-center text-gray-500 text-lg"> No pending orders for now... </span>
                </div>
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
                                    Tracking Number
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
                                </td>
                                <td class="px-6 py-4">
                                    {{$incoming_order->tracking_number ?? 'Not Added'}}
                                </td>
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
                {{$incoming_orders->links()}}
            </div>
        </div>
    </section>
</div>
@endsection
