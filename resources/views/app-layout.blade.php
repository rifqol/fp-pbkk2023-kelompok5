<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>E-Commerce App</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&family=Titillium+Web:wght@300&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
</head>
<style>
    *{
        font-family: 'Poppins', sans-serif;
    }
    @media only screen and (max-width: 640px) {
        html {
            font-size: 3.5vw;
        }
    }
</style>
<body class="flex flex-row">
    <!-- sidebar -->
    <nav class="absolute sm:relative z-10 drop-shadow-lg">
        <x-sidebar></x-sidebar>
    </nav>

    <!-- main content -->
    <div class="relative z-0 pl-[5rem] overflow-y-auto sm:pl-0 h-screen w-full">
        @yield('main')
    </div>
</body>

@vite('resources/js/app.js')