@extends('app-layout')

@section('main')
<div class="flex flex-col gap-3 p-4 min-h-full w-full bg-green-50">
    <section class="flex flex-col gap-2">
        <div class="flex gap-2">
            <span class="text-2xl font-extrabold my-2"> Your Orders </span>
        </div>
        <form class="flex items-center gap-2 justify-start"> 
            <input type="text" class="p-2 border rounded-md w-50" name="search">
            <button type="submit" class="flex gap-2 bg-green-500 rounded-md p-2">
                <x-heroicon-o-magnifying-glass class="h-5 text-white"/>
            </button>
        </form>  
        @if ($message = session('success'))
        <span class="flex flex-row bg-green-200 rounded-md ring-1 ring-green-900 text-green-900 p-4" onclick="">
            {{ $message }} <button class="ml-auto font-extrabold" onclick="this.parentNode.remove()">X</button>
        </span>
        @endif
        <div class="bg-white shadow-md p-4 rounded-md">
            <div class="flex flex-col min-h-[10rem] gap-2">
                @if ($orders->count() == 0)
                <div class="flex flex-col gap-4 self-center my-auto">
                    <span class="self-center text-gray-500 text-lg"> You have no orders yet... </span>
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
                                    Seller
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
                                    <span class="sr-only">View</span>
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    <span class="sr-only">Chat</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)
                            <tr class="bg-white border-b ">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap ">
                                    {{$order->id}}
                                </th>
                                <td class="px-6 py-4">
                                    {{$order->seller->name}}
                                </td>
                                <td class="px-6 py-4">
                                    {{$order->shipment_address}}
                                </td>
                                <td class="px-6 py-4">
                                    {{$order->status}}
                                </td>
                                <td class="px-6 py-4">
                                    {{$order->tracking_number ?? 'Not Added'}}
                                </td>
                                <td class="px-6 py-4">
                                    Rp. {{number_format($order->total, thousands_separator: ".")}}
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <a href="{{url('orders/' . $order->id)}}" class="font-medium text-blue-600  hover:underline">View</a>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <a href="{{ url('/chats/'. $order->seller->id)}}" class="{{ (request()->is('chats')) || request()->is('chats/*') ? 'font-medium text-blue-600  hover:underline' : 'bg-white'}}">
                                        <x-heroicon-o-chat-bubble-oval-left-ellipsis class="w-6 h-auto"/>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @endif
            </div>
            {{$orders->links()}}
        </div>
    </section>
</div>
@endsection
