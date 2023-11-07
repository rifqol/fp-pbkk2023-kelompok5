@foreach ($messages as $message)
    @if ($message->sender->id == Auth::id())
        <div class="message-sent bg-green-500">{{$message->message}}</div>
    @else
        <div class="message-received">{{$message->message}}</div>
    @endif
@endforeach

