<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register page</title>
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
<body class="bg-green-500">
    <div class="flex flex-col p-10 h-screen">
        <form action="{{url('register')}}" class="flex flex-col gap-2 bg-white rounded-md p-5 drop-shadow-2xl self-center my-auto w-5/6 text-sm sm:w-[500px] sm:text-lg" method="post" enctype="multipart/form-data" novalidate>
            @csrf
                <h1 class="text-center text-xl sm:text-2xl sm:m-4 font-bold">Form Register</h1>

                <input type="text" name="name" class="rounded-md ring-gray-500 p-2 bg-gray-200 drop-shadow-lg mb-4 mt-3" value="{{old('name')}}" id="name" autocomplete="name" placeholder="Name">
                @error('name')
                    <h5 class="text-red-400 font-thin text-sm mt-[-1rem]">{{ $message }}</h5>
                @enderror

                <input type="username" name="username" class="rounded-md ring-gray-500 p-2 bg-gray-200 drop-shadow-lg mb-4" value="{{old('username')}}" id="username" placeholder="Username">
                @error('username')
                    <h5 class="text-red-400 font-thin text-sm mt-[-1rem]">{{ $message }}</h5>
                @enderror
                
                <input type="email" name="email" class="rounded-md ring-gray-500 p-2 bg-gray-200 drop-shadow-lg mb-4" value="{{old('email')}}" id="email" placeholder="Email">
                @error('email')
                    <h5 class="text-red-400 font-thin text-sm mt-[-1rem]">{{ $message }}</h5>
                @enderror

                <input type="phone" name="phone" class="rounded-md ring-gray-500 p-2 bg-gray-200 drop-shadow-lg mb-4" value="{{old('phone')}}" id="phone" placeholder="Phone Number">
                @error('phone')
                    <h5 class="text-red-400 font-thin text-sm mt-[-1rem]">{{ $message }}</h5>
                @enderror
                
                <input type="password" name="password" class="rounded-md ring-gray-500 p-2 bg-gray-200 drop-shadow-lg mb-4" id="password" placeholder="Password">
                @error('password')
                    <h5 class="text-red-400 font-thin text-sm mt-[-1rem]">{{ $message }}</h5>
                @enderror

                <label for="region_code"> Location</label>
                <div class="flex flex-row gap-5">
                    <select id="province_select" class="rounded-md ring-gray-500 p-2 bg-gray-200 drop-shadow-lg mb-4 w-1/2">
                        <option value="">Select Province</option>
                        @foreach ($provinces as $province)
                        <option value="{{$province->code}}">{{$province->name}}</option>
                        @endforeach
                    </select>
                    <select id="regency_select" class="rounded-md ring-gray-500 p-2 bg-gray-200 drop-shadow-lg mb-4 w-1/2" name="region_code">
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
                <input type="file" accept="image/*" class= "rounded-md ring-gray-500 p-1 hb-10" name="photo" id="photo">
                @error('photo')
                    <h5 class="text-red-400 font-thin text-sm">{{ $message }}</h5>
                @enderror
                <input type="submit" class="rounded-md uppercase outline-none bg-green-500 self-center my-auto w-full border-none py-3 text-white text-14 transition-all duration-300 cursor-pointer mt-10 mb-8" value="Submit">
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