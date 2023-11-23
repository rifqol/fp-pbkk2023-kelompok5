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
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
</head>
<style>
    *{
        font-family: 'Poppins', sans-serif;
    }
</style>
<body class="bg-green-300">
    <div class="flex flex-col p-10 h-screen">
        <form action="{{url('register')}}" class="flex flex-col gap-2 bg-white rounded-md p-5 drop-shadow-2xl w-5/6 self-center mt-auto mb-auto text-sm mb-1/2 sm:w-[600px] sm:text-lg" method="post" enctype="multipart/form-data" novalidate>
            @csrf
                <h1 class="text-center text-xl sm:text-2xl sm:m-4 font-bold">Register</h1>
                
                <label for="name">Name</label>
                <input type="text" name="name" class="rounded-md ring-gray-500 ring-2 p-2 bg-gray-100 drop-shadow-lg mb-4" value="{{old('name')}}" id="name" autocomplete="name">
                @error('name')
                    <h5 class="text-red-400 font-thin text-sm mt-[-1rem]">{{ $message }}</h5>
                @enderror

                <label for="username">Username</label>
                <input type="username" name="username" class="rounded-md ring-gray-500 ring-2 p-2 bg-gray-100 drop-shadow-lg mb-4" value="{{old('username')}}" id="username">
                @error('username')
                    <h5 class="text-red-400 font-thin text-sm mt-[-1rem]">{{ $message }}</h5>
                @enderror
                
                <label for="email">Email</label>
                <input type="email" name="email" class="rounded-md ring-gray-500 ring-2 p-2 bg-gray-100 drop-shadow-lg mb-4" value="{{old('email')}}" id="email">
                @error('email')
                    <h5 class="text-red-400 font-thin text-sm mt-[-1rem]">{{ $message }}</h5>
                @enderror

                <label for="phone">Phone Number</label>
                <input type="phone" name="phone" class="rounded-md ring-gray-500 ring-2 p-2 bg-gray-100 drop-shadow-lg mb-4" value="{{old('phone')}}" id="phone">
                @error('phone')
                    <h5 class="text-red-400 font-thin text-sm mt-[-1rem]">{{ $message }}</h5>
                @enderror
                
                <label for="password">Password</label>
                <input type="password" name="password" class="rounded-md ring-gray-500 ring-2 p-2 bg-gray-100 drop-shadow-lg mb-4" id="password">
                @error('password')
                    <h5 class="text-red-400 font-thin text-sm mt-[-1rem]">{{ $message }}</h5>
                @enderror

                <label for="region_code"> Location</label>
                <div class="flex flex-row gap-5">
                    <select id="province_select" class="rounded-md ring-gray-500 ring-2 p-2 bg-gray-100 drop-shadow-lg mb-4 w-1/2">
                        <option value="">Select Province</option>
                        @foreach ($provinces as $province)
                        <option value="{{$province->code}}">{{$province->name}}</option>
                        @endforeach
                    </select>
                    <select id="regency_select" class="rounded-md ring-gray-500 ring-2 p-2 bg-gray-100 drop-shadow-lg mb-4 w-1/2" name="region_code">
                        <option value="">Select Regency</option>
                    </select>
                </div>
                @error('region_code')
                    <h5 class="text-red-400 font-thin text-sm mt-[-1rem]">{{ $message }}</h5>
                @enderror

                @error('doctor_id')
                    <h5 class="text-red-400 font-thin text-sm mt-[-1rem]">{{ $message }}</h5>
                @enderror

                <label for="photo">Photo</label>
                <input type="file" accept="image/*" class="rounded-md ring-2 ring-gray-500 p-1" name="photo" id="photo">
                @error('photo')
                    <h5 class="text-red-400 font-thin text-sm">{{ $message }}</h5>
                @enderror
                <input type="submit" class="bg-black rounded-md text-white w-1/2 h-10 self-center mt-5" value="Submit">
        </form>
    </div>
</body>
</html>
<script>
    $(document).ready(function() {
        $("#province_select").on("change", function (event) {
            $("#regency_select").children().not(":first").remove();
            $.ajax({
                type: "GET",
                url: "{{ url('regions') . '?code='}}" + this.value, 
            }).done(function (data) {
                console.log(data);
                $("#regency_select").append(data);
            });
        });
    });
</script>