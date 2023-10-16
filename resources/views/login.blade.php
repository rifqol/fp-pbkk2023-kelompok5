<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form App</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&family=Titillium+Web:wght@300&display=swap" rel="stylesheet">
</head>
<style>
    *{
        font-family: 'Poppins', sans-serif;
    }
</style>
<body class="flex flex-col bg-green-300 h-screen">
    <div class="flex flex-col gap-2 bg-white rounded-md p-5 drop-shadow-2xl self-center my-auto w-5/6 text-sm sm:w-[600px] sm:text-lg">
        <form id="login" action="{{url('/login')}}" class="flex flex-col gap-2" method="post" enctype="multipart/form-data" novalidate>
            @csrf
                <h1 class="text-center text-xl sm:text-2xl sm:m-4 font-bold">Form App</h1>
                
                <label for="email">Email</label>
                <input type="email" name="email" class="rounded-md ring-gray-500 ring-2 p-2 bg-gray-100 drop-shadow-lg mb-4" value="{{old('email')}}" id="email">
                @error('email')
                    <h5 class="text-red-400 font-thin text-sm mt-[-1rem]">{{ $message }}</h5>
                @enderror
                
                <label for="password">Password</label>
                <input type="password" name="password" class="rounded-md ring-gray-500 ring-2 p-2 bg-gray-100 drop-shadow-lg mb-4" id="password">
                @error('password')
                    <h5 class="text-red-400 font-thin text-sm mt-[-1rem]">{{ $message }}</h5>
                @enderror
                @error('credentials')
                    <h5 class="text-red-400 font-thin text-sm">{{ $message }}</h5>
                @enderror
        </form>
        <form id="register" action="{{ url('register') }}" method="GET"></form>
        @if ($message = session('success'))
        <span class="flex flex-row bg-green-200 rounded-md ring-1 ring-green-900 text-green-900 p-4" onclick="">
            {{ $message }} <button class="ml-auto font-extrabold" onclick="this.parentNode.remove()">X</button>
        </span>
        @endif
        <div class="flex w-full gap-2">
            <button type="submit" class="bg-black rounded-md text-white w-1/2 h-10 self-center mt-5" form="login">Login</button>
            <button type="submit" class="bg-black rounded-md text-white w-1/2 h-10 self-center mt-5" form="register">Register</button>
        </div>
    </div>
</body>
</html>