@extends('app-layout')

@section('main')
    <div class="container mx-auto mt-8">
        <div class="bg-white p-6 rounded shadow-md">
            <h2 class="text-2xl font-semibold mb-6">{{ request()->is('admin/*') ? 'Edit User' : 'Edit Profile' }}</h2>

            @if(session('success'))
                <div class="bg-green-200 text-green-800 p-4 mb-4 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ url('/users/edit' , $user->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Tambahkan formulir sesuai kebutuhan -->
                <div class="mb-4">
                    <div class="mb-4">
                        <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Name:</label>
                        <input class="rounded-md ring-gray-500 ring-2 p-2 bg-gray-100 drop-shadow-lg w-full" type="text" name="name" id="name" value="" class="w-full border p-2" placeholder="{{ $user->name }}">
                    </div>

                    <div class="mb-4">
                        <label for="username" class="block text-gray-700 text-sm font-bold mb-2">Username:</label>
                        <input class="rounded-md ring-gray-500 ring-2 p-2 bg-gray-100 drop-shadow-lg w-full" type="text" name="username" id="username" value="" class="w-full border p-2" placeholder="{{ $user->username }}">
                    </div>

                    <div class="mb-4">
                        <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email:</label>
                        <input class="rounded-md ring-gray-500 ring-2 p-2 bg-gray-100 drop-shadow-lg w-full" type="email" name="email" id="email" value="" class="w-full border p-2" placeholder="{{ $user->email }}">
                    </div>

                    <div class="mb-4">
                        <label for="phone" class="block text-gray-700 text-sm font-bold mb-2">Phone:</label>
                        <input class="rounded-md ring-gray-500 ring-2 p-2 bg-gray-100 drop-shadow-lg w-full" type="text" name="phone" id="phone" value="" class="w-full border p-2" placeholder="{{ $user->phone }}">
                    </div>

                    <div class="mb-4">
                        <label for="password" class="block text-gray-700 text-sm font-bold mb-2">Password:</label>
                        <input class="rounded-md ring-gray-500 ring-2 p-2 bg-gray-100 drop-shadow-lg w-full" type="password" name="password" id="password" class="w-full border p-2">
                    </div>

                    <label for="region_code" class="block text-gray-700 text-sm font-bold mb-2">Location</label>
                    <div class="flex flex-row gap-5">
                        <select id="province_select" class="rounded-md ring-gray-500 ring-2 p-2 bg-gray-100 drop-shadow-lg w-full mb-4">
                            <option value="">Select Province</option>
                            @foreach ($provinces as $province)
                            <option value="{{$province->code}}">{{$province->name}}</option>
                            @endforeach
                        </select>
                        <select id="regency_select" class="rounded-md ring-gray-500 ring-2 p-2 bg-gray-100 drop-shadow-lg w-full mb-4" name="region_code">
                            <option value="">Select Regency</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="bank_actnumber" class="block text-gray-700 text-sm font-bold mb-2">Bank Account Number:</label>
                        <input class="rounded-md ring-gray-500 ring-2 p-2 bg-gray-100 drop-shadow-lg w-full" type="text" name="bank_actnumber" id="bank_actnumber" value="" class="w-full border p-2" placeholder="{{ $user->bank_actnumber }}">
                    </div>

                    <div class="mb-4">
                        <label for="photo" class="block text-gray-700 text-sm font-bold mb-2">Photo:</label>
                        <input class="rounded-md ring-gray-500 ring-2 p-2 bg-gray-100 drop-shadow-lg w-full" type="file" name="photo" id="photo" class="w-full border p-2">
                    </div>
                    @if($errors->any())
                        {{ implode('', $errors->all('<div>:message</div>')) }}
                    @endif
                </div>

                <div class="mt-6">
                    <button type="submit" class="bg-green-500 text-white p-2 rounded">Confirm</button>
                </div>
            </form>
        </div>
    </div>

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
@endsection