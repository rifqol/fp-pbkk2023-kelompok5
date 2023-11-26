<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
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
<body class="flex flex-col bg-gradient-to-r from-green-500 to-green-700 antialiased h-screen">
    <div class="flex flex-col gap-2 bg-white rounded-md p-5 drop-shadow-2xl self-center my-auto w-3/4 text-sm sm:w-[400px] sm:text-lg">
        <form id="login" action="{{url('/login')}}" class="flex flex-col gap-2 my-auto " method="post" enctype="multipart/form-data" novalidate>
            @csrf
                <input type="email" name="email" class="rounded-md ring-gray-500 p-2 bg-gray-200 drop-shadow-lg self-center my-auto w-5/6 mt-10" value="{{old('email')}}" id="email" placeholder="Email">
                @error('email')
                    <h5 class="text-red-400 font-thin text-sm mt-2 ml-8">{{ $message }}</h5>
                @enderror
                
                <input type="password" name="password" class="rounded-md ring-gray-500 p-2 bg-gray-200 drop-shadow-lg self-center my-auto w-5/6" id="password" placeholder="Password">
                @error('password')
                    <h5 class="text-red-400 font-thin text-sm mt-2 ml-8">{{ $message }}</h5>
                @enderror
                @error('credentials')
                    <h5 class="text-red-400 font-thin text-sm">{{ $message }}</h5>
                @enderror
        </form>
        <form id="register" action="{{ url('register') }}" method="GET"></form>
        @if ($message = session('success'))
        <span class="flex flex-row bg-green-200 ring-1 ring-green-900 text-green-900 p-4" onclick="">
            {{ $message }} <button class="ml-auto font-extrabold" onclick="this.parentNode.remove()">X</button>
        </span>
        @endif
            <button type="submit" class="rounded-md uppercase outline-none bg-green-500 self-center my-auto w-5/6 border-none py-1 text-white text-14 transition-all duration-300 cursor-pointer" form="login">Login</button>
            <p class="message text-sm text-gray-600 self-center my-auto w-5/6 mb-6">Not registered? <a href="register" class="text-green-400 text-sm">Create an account</a></p>
    </div>
</body>
</html> 




