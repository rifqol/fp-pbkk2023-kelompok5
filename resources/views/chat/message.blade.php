@foreach ($messages as $message)
    @if ($message->sender->id == Auth::id())
        <div class="text-right">{{$message->message}}</div>
    @else
        <div>{{$message->message}}</div>
    @endif
@endforeach
