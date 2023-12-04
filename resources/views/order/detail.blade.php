@extends('app-layout')

@section('main')

<div class="flex flex-col p-4 min-h-full bg-green-50">
    <section class="flex flex-1 flex-col h-full gap-2">
        <span id="top-span" class="font-extrabold text-xl my-2">Order Detail</span>
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
                                <h1 class="text-2xl font-extrabold">{{ $item->name }}</h1>
                                <h2>Quantity: {{ $item->pivot->quantity }}</h2>
                                <h2 class="mt-auto">Rp. {{ number_format($item->price, thousands_separator: ".") }}</h2>
                                @if ($order->status == "Complete")
                                <form class="review-form border-t-[1px] flex flex-col self-start w-full mt-2" action="{{url( $item->reviews->count() ? 'reviews/update/' . $item->reviews->first()->id : 'reviews/create')}}" method="POST">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $item->id }}">
                                    <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                                    <label for="is_public">Rating</label>
                                    <select id="rating" class="rounded-md ring-gray-500 ring-2 p-2 bg-gray-100 drop-shadow-lg mb-4" name="rating">
                                        <option value="">Select Rating</option>
                                        <option value="1" {{ $item->reviews->count() && $item->reviews->first()->rating == 1 ? 'selected' : '' }}>1 Star</option>
                                        <option value="2" {{ $item->reviews->count() && $item->reviews->first()->rating == 2 ? 'selected' : '' }}>2 Stars</option>
                                        <option value="3" {{ $item->reviews->count() && $item->reviews->first()->rating == 3 ? 'selected' : '' }}>3 Stars</option>
                                        <option value="4" {{ $item->reviews->count() && $item->reviews->first()->rating == 4 ? 'selected' : '' }}>4 Stars</option>
                                        <option value="5" {{ $item->reviews->count() && $item->reviews->first()->rating == 5 ? 'selected' : '' }}>5 Stars</option>
                                    </select>
                                    @error('condition')
                                        <h5 class="text-red-400 font-thin text-sm mt-[-0.5rem]">{{ $message }}</h5>
                                    @enderror
                                    <label for="description">Product Review</label>
                                    <textarea type="text" rows="4" name="review" class="rounded-md ring-gray-500 ring-2 p-2 bg-gray-100 drop-shadow-lg mb-4 w-full" id="review" placeholder="Type Your Review...">{{$item->reviews->count() ? $item->reviews->first()->review : '' }}</textarea> 
                                    @error('description')
                                        <h5 class="text-red-400 font-thin text-sm mt-[-0.5rem]">{{ $message }}</h5>
                                    @enderror
                                    {{-- <div class="flex self-end gap-2">
                                        <button class="submit-review rounded-md bg-green-500 text-white p-2 w-fit" type="button">{{$item->reviews->count() ? 'Update Review' : 'Submit Review'}}</button>
                                        @if ($item->reviews->count())
                                        <form class="review-delete-form" action="{{ url('reviews/delete' . $item->reviews->first()->id) }}" method="post">
                                            <button class="delete-review rounded-md bg-red-500 text-white p-2 w-fit" type="button">Delete Review</button>
                                        </form>
                                        @endif
                                    </div> --}}
    
                                </form>
                                <div class="flex self-end gap-2">
                                    <button class="submit-review rounded-md bg-green-500 text-white p-2 w-fit" type="button">{{$item->reviews->count() ? 'Update Review' : 'Submit Review'}}</button>
                                    @if ($item->reviews->count())
                                    <form class="review-delete-form" action="{{ url('reviews/delete/' . $item->reviews->first()->id) }}" method="post">
                                        <button class="delete-review rounded-md bg-red-500 text-white p-2 w-fit" type="button">Delete Review</button>
                                    </form>
                                    @endif
                                </div>
                                @endif
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
                            <img class="rounded-full w-10 h-10 object-cover shadow-md" src="{{$order->seller->photo_url}}" alt="">
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
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).ready(function () {
        $(".submit-review").on("click", function() {
            $(this).parent().prev(".review-form").triggerHandler("submit");
            console.log("submit");
        });

        $(".delete-review").on("click", function() {
            $(this).closest(".review-delete-form").triggerHandler("submit");
            console.log("delete");
        });

        $(".review-form").on("submit", function(event) {
            var url = $(this).attr("action");
            var formData = $(this).serialize();

            $.ajax({
                url: url,
                type: "POST",
                data: formData,
                success: function (response) {
                    console.log(response);
                    location.reload();
                },
                error: function(xhr, text, error) {
                    console.log(xhr.responseJSON)
                    if(xhr.responseJSON.errors.rating != null) {
                        $("#top-span").after(`
                        <span class="flex flex-row bg-red-200 rounded-md ring-1 ring-red-900 text-red-900 p-4" onclick="">
                            ${xhr.responseJSON.errors.rating} <button class="ml-auto font-extrabold" onclick="this.parentNode.remove()">X</button>
                        </span>
                        `);
                    }
                }
            });
        })

        $(".review-delete-form").on("submit", function(event) {
            var url = $(this).attr("action");
            var formData = $(this).serialize();

            $.ajax({
                url: url,
                type: "POST",
                success: function (response) {
                    console.log(response);
                    location.reload();
                },
                error: function(xhr, text, error) {
                    console.log(xhr.responseJSON)
                }
            });
        })
    });
</script>
@endsection
