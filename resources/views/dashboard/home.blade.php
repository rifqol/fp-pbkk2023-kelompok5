@extends('app-layout')

@section('main')
<div class="flex flex-col gap-3 p-4 min-h-full w-full bg-slate-200">
    <h1 class="text-2xl font-extrabold">Halo {{ Auth::user()->name }}! </h1>
    <p class="self-center font-bold text-lg">Your photo</p>
    <img src="{{ Auth::user()->photo_url }}" class="w-1/4 h-auto rounded-2xl self-center drop-shadow-lg mx-auto" alt="user_photo">
</div>
@endsection
