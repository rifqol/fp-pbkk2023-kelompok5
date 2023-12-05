@extends('app-layout')

@section('main')

<meta name="csrf-token" content="{{ csrf_token() }}">

<style>
.message-sent {
    color: #fff; /* White text */
    border-radius: 15px; /* Rounded corners */
    padding: 10px; /* Spacing inside the bubble */
    max-width: fit-content;
    margin: 5px; /* Spacing between bubbles */
    margin-left: auto;
    text-align: right; 
    max-height: 10vh;
}

    .message-received {
    background-color: #f0f0f0; /* Light gray color */
    border-radius: 15px; /* Rounded corners */
    padding: 10px; /* Spacing inside the bubble */
    max-width: fit-content;
    margin: 5px; /* Spacing between bubbles */
    margin-right: auto;
    text-align: left;
    max-height: 10vh;
}
</style>


<header class="bg-slate-50 border-b-2 border-gray-200 py-3 text-center flex items-center justify-between">
    <div class="flex items-center ml-2 mt-2 justify-between">
        <img src="{{ $chatPartner->photo_url }}" class="w-12 h-12 rounded-full object-cover shadow-md ml-2" alt="{{ $chatPartner->name }}">
        <h1 class="text-xl ml-2">{{ $chatPartner->name }}</h1>
    </div>
</header>


<div class="chat max-h-[90vh] overflow-x-auto">
    
</div>


<form id="send_chat" action="{{ url('/chats/' . $receiver_id . '/send') }}" class="flex flex-col gap-2 fixed right-2 bottom-3 w-[75%] max-h-[40vh]" method="post" enctype="multipart/form-data" novalidate>
    @csrf
    <div class="flex flex-wrap gap-2 w-full">
        <input type="message" name="message" class="rounded-md ring-gray-500 ring-2 p-2 bg-gray-100 drop-shadow-lg w-[92.5%]" value="{{ old('message') }}" id="message">
        @error('message')
            <h5 class="text-red-400 font-thin text-sm mt-[-1rem]">{{ $message }}</h5>
        @enderror
        <button type="submit" class="bg-none flex justify-center items-center">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-10 h-10">
                <path d="M3.478 2.405a.75.75 0 00-.926.94l2.432 7.905H13.5a.75.75 0 010 1.5H4.984l-2.432 7.905a.75.75 0 00.926.94 60.519 60.519 0 0018.445-8.986.75.75 0 000-1.218A60.517 60.517 0 003.478 2.405z" />
            </svg>
        </button>
    </div>
</form>


<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).ready(function() {
        $.ajax({
            type: "GET",
            url: "{{ url('/chats/' . $receiver_id . '/reload') }}", 
        }).done(function (data) {
            console.log(data);
            $(".chat").append(data);
        });
        
        console.log(window.Echo);

        window.Echo.private("chat.message.{{$receiver_id}}-{{Auth::user()->id}}")
            .listen('.incoming-message', (e) => {
                console.log(e);
                reloadChat();
            });
    });

    $("#send_chat").submit(function (event) {
        messageForm = $("#message");

        var formData = {
            message: messageForm.val(),
        };

        $.ajax({
            type: "POST",
            url: "{{ url('/chats/' . $receiver_id . '/send') }}",
            data: formData,
            dataType: "json",
            encode: true, 
        }).done(function (data) {
            console.log(data);
            messageForm.val('');
            reloadChat();
        });
        
        event.preventDefault();
    });

    function reloadChat()
    {
        $.ajax({
            type: "GET",
            url: "{{ url('/chats/' . $receiver_id . '/reload') }}", 
        }).done(function (data) {
            console.log(data);
            $(".chat").empty().append(data);
        });
    }
</script>
@endsection