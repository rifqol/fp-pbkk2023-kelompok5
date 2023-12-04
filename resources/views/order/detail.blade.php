@extends('app-layout')

@section('main')

<div class="flex flex-col p-4 min-h-full bg-green-50">
    <section class="flex flex-1 flex-col h-full gap-2">
        <span class="font-extrabold text-xl my-2">Order Detail</span>
        @if ($message = session('order_success'))
        <span class="flex flex-row bg-green-200 rounded-md ring-1 ring-green-900 text-green-900 p-4" onclick="">
            {{ $message }} <button class="ml-auto font-extrabold" onclick="this.parentNode.remove()">X</button>
        </span>
        @endif
        <div class="flex flex-1 h-full bg-white shadow-md p-4 rounded-md gap-2">
            <ul class="flex flex-col w-full h-full">
                @foreach ($order->products as $item)
                <li class="flex gap-4 py-2 border-b-[1px]">
                    <img class="object-cover rounded-md h-[10vw] self-center" src="{{ $item->images->toArray()[0]['image_url'] }}">
                    <div class="flex flex-col w-full">
                        <span class="flex h-full w-full">
                            <div class="flex flex-col flex-1 h-full">
                                <h1>{{ $item->name }}</h1>
                                <h2>Quantity: {{ $item->pivot->quantity }}</h2>
                                <h2 class="mt-auto">Rp. {{ number_format($item->price, thousands_separator: ".") }}</h2>
                            </div>
                        </span>
                    </div>
                </li>
                @endforeach
            </ul>
            <div class="flex flex-col w-[30rem]">
                <div class="flex flex-col gap-2 bg-green-50 p-2 rounded-md shadow-md">
                    <div class="flex flex-col gap-2 py-2 bg-white p-2 rounded-md shadow-md">
                        <h1>Seller</h1>
                        <div class="flex gap-2 py-2">
                            <img class="rounded-full w-10 h-10 object-cover shadow-md" src="{{$order->user->photo_url}}" alt="">
                            <a class="self-center text-md">{{$order->seller->name}}</a>
                        </div>
                    </div>
                    <div class="flex flex-col gap-2 py-2 bg-white p-2 rounded-md shadow-md">
                        <h1>Shipping Address</h1>
                        <p>{{ $order->region->name }}</p>
                        <p>{{ $order->shipment_address }}</p>
                    </div>
                    <div class="flex flex-col gap-2 py-2 bg-white p-2 rounded-md shadow-md">
                        <h1>Total Price</h1>
                        <div class="flex gap-2">
                            <p class="self-center">Rp. {{ number_format($order->total, thousands_separator: ".") }}</p>
                            <p class="
                                ml-auto rounded-md p-1 text-white
                                @switch($order->status)
                                    @case('Pending')
                                        bg-orange-400
                                        @break
                                    @case('Paid')
                                        bg-yellow-400
                                        @break
                                    @case('Shipping')
                                        bg-blue-400
                                        @break
                                    @case('Complete')
                                        bg-green-500
                                        @break
                                    @case('Cancelled')
                                        bg-red-500
                                        @break    
                                @endswitch
                            "> {{ $order->status }} </p>
                        </div>
                    </div>
                    <div class="flex flex-col gap-2 py-2 bg-white p-2 rounded-md shadow-md">
                    @if ($order->status == 'Pending')
                        <a class="bg-green-500 text-white p-2 rounded-md text-center" href="{{ $order->payment_url }}" target="_blank" rel="noopener noreferrer">
                            Make Payment
                        </a>
                    @elseif($order->status == 'Shipping')
                        <form class="flex flex-col gap-2" action="{{ url('orders/' . $order->id . '/mark-complete') }}" method="POST">
                            @csrf
                            <button class="bg-green-500 text-white p-2 rounded-md" type="submit">Mark Complete</button>
                        </form>
                    @else
                        <p class="text-center">Nothing to do</p>
                    @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
