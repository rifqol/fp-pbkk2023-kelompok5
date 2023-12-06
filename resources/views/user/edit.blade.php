@extends('app-layout')

@section('main')
    <div class="container mx-auto mt-8">
        <div class="bg-white p-6 rounded shadow-md">
            <h2 class="text-2xl font-semibold mb-6">Edit User</h2>

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
                        <input type="text" name="name" id="name" value="{{ $user->name }}" class="w-full border p-2">
                    </div>

                    <div class="mb-4">
                        <label for="username" class="block text-gray-700 text-sm font-bold mb-2">Username:</label>
                        <input type="text" name="username" id="username" value="{{ $user->username }}" class="w-full border p-2">
                    </div>

                    <div class="mb-4">
                        <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email:</label>
                        <input type="email" name="email" id="email" value="{{ $user->email }}" class="w-full border p-2">
                    </div>

                    <div class="mb-4">
                        <label for="phone" class="block text-gray-700 text-sm font-bold mb-2">Phone:</label>
                        <input type="text" name="phone" id="phone" value="{{ $user->phone }}" class="w-full border p-2">
                    </div>

                    <!-- <div class="mb-4">
                        <label for="password" class="block text-gray-700 text-sm font-bold mb-2">Password:</label>
                        <input type="password" name="password" id="password" class="w-full border p-2">
                    </div> -->

                    <!-- <div class="mb-4">
                        <label for="region_code" class="block text-gray-700 text-sm font-bold mb-2">Region:</label>
                        <input type="text" name="region_code" id="region_code" value="{{ $user->region->name }}" class="w-full border p-2">
                    </div> -->

                    <!-- <div class="mb-4">
                        <label for="bank_actnumber" class="block text-gray-700 text-sm font-bold mb-2">Bank Account Number:</label>
                        <input type="text" name="bank_actnumber" id="bank_actnumber" value="{{ $user->bank_actnumber }}" class="w-full border p-2">
                    </div> -->

                    <div class="mb-4">
                        <label for="photo" class="block text-gray-700 text-sm font-bold mb-2">Photo:</label>
                        <input type="file" name="photo" id="photo" class="w-full border p-2">
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
@endsection