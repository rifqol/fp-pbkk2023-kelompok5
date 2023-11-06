@extends('app-layout')

@section('main')

<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="chat">

</div>

<form id="send_chat" action="{{url('/chats/' . $receiver_id . '/send')}}" class="flex flex-col gap-2" method="post" enctype="multipart/form-data" novalidate>
    @csrf
    <label for="message">Message</label>
    <input type="message" name="message" class="rounded-md ring-gray-500 ring-2 p-2 bg-gray-100 drop-shadow-lg mb-4" value="{{old('message')}}" id="message">
    @error('message')
        <h5 class="text-red-400 font-thin text-sm mt-[-1rem]">{{ $message }}</h5>
    @enderror
    <input type="submit" class="bg-black rounded-md text-white w-1/2 h-10 self-center mt-5" value="Send">
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

        window.Echo.private("chat.message.{{Auth::user()->id}}")
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