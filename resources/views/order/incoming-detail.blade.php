@extends('app-layout')

@section('main')

<div class="flex flex-col p-4 min-h-full bg-green-50">
    <section class="flex flex-1 flex-col h-full">
        <span class="font-extrabold text-xl my-2">Incoming Order Detail</span>
        <div class="flex flex-1 h-full bg-white shadow-md p-4 rounded-md gap-2">
            <ul class="flex flex-col w-full h-full">
                @foreach ($incoming_order->products as $item)
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
                        <h1>Buyer</h1>
                        <div class="flex flex gap-2 py-2">
                            <img class="rounded-full w-10 h-10 object-cover shadow-md" src="{{$incoming_order->user->photo_url}}" alt="">
                            <a class="self-center text-md">{{$incoming_order->user->name}}</a>
                        </div>
                    </div>
                    <div class="flex flex-col gap-2 py-2 bg-white p-2 rounded-md shadow-md">
                        <h1>Shipping Address</h1>
                        <p>{{ $incoming_order->region->name }}</p>
                        <p>{{ $incoming_order->shipment_address }}</p>
                    </div>
                    <div class="flex flex-col gap-2 py-2 bg-white p-2 rounded-md shadow-md">
                        <h1>Total Price</h1>
                        <div class="flex gap-2">
                            <p class="self-center">Rp. {{ number_format($incoming_order->total, thousands_separator: ".") }}</p>
                            <p class="
                                ml-auto rounded-md p-1 text-white
                                @switch($incoming_order->status)
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
                                    @case('Canceled')
                                        bg-red-500
                                        @break    
                                @endswitch
                            "> {{ $incoming_order->status }} </p>
                        </div>
                    </div>
                    <div class="flex flex-col gap-2 py-2 bg-white p-2 rounded-md shadow-md">
                    @if ($incoming_order->status == 'Pending')
                        <p class="text-center">Nothing to do yet...</p>
                    @elseif($incoming_order->status == 'Paid' || $incoming_order->status == 'Shipping')
                        <form class="flex flex-col gap-2" action="{{ url('dashboard/order/' . $incoming_order->id . '/update-tracking-number') }}" method="POST">
                            @csrf
                            <label for="tracking_number">Tracking Number</label>
                            <div class="flex gap-2">
                                <input type="text" name="tracking_number" class="rounded-md ring-gray-500 ring-2 p-2 bg-gray-100 drop-shadow-lg w-full" value="{{ old('tracking_number') ?? $incoming_order->tracking_number }}" id="tracking_number" placeholder="Enter Tracking Number...">
                                @error('tracking_number')
                                    <h5 class="text-red-400 font-thin text-sm mt-[-0.5rem]">{{ $message }}</h5>
                                @enderror
                                <button class="bg-green-500 text-white p-2 rounded-md" type="submit">Update</button>
                            </div>
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
