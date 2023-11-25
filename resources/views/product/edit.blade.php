@extends('app-layout')

@section('main')
<div class="flex flex-col gap-3 p-4 min-h-full w-full bg-green-50">
    <section class="flex flex-col gap-2">
        <div class="flex">
            <span class="text-2xl font-extrabold my-2">Edit Product</span>
            <form class="self-center ml-auto" action="{{url('dashboard/product/' . $product->id . '/remove')}}" method="POST">
                @csrf
                <button class="bg-red-500 text-white rounded-md p-2 ml-auto">Remove Product</button>
            </form>
        </div>
        @if ($message = session('edit_success'))
        <span class="flex flex-row bg-green-200 rounded-md ring-1 ring-green-900 text-green-900 p-4" onclick="">
            {{ $message }} <button class="ml-auto font-extrabold" onclick="this.parentNode.remove()">X</button>
        </span>
        @endif
        <div class="bg-white shadow-md p-4 rounded-md">
            <form class="flex flex-col px-20 py-10" action="{{url('dashboard/product/' . $product->id . '/edit')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="grid grid-cols-3 gap-20">
                    <div class="flex flex-col">
                        <label class="mb-4" for="name">Product Name</label>
                        <input type="text" name="name" class="rounded-md ring-gray-500 ring-2 p-2 bg-gray-100 drop-shadow-lg w-full mb-4" value="{{$product->name}}" id="name" placeholder="Enter Product Name..." autocomplete="name">
                        @error('name')
                            <h5 class="text-red-400 font-thin text-sm mt-[-0.5rem]">{{ $message }}</h5>
                        @enderror
                    </div>
                    <div class="flex flex-col">
                        <label class="mb-4" for="name">Product Type</label>
                        <select id="type" class="rounded-md ring-gray-500 ring-2 p-2 bg-gray-100 drop-shadow-lg mb-4" name="type">
                            <option value="">Select Type</option>
                            <option value="Books" {{$product->type == 'Books' ? 'selected' : ''}}>Books</option>
                            <option value="E-Books" {{$product->type == 'E-Books' ? 'selected' : ''}}>E-Books</option>
                            <option value="Gadgets" {{$product->type == 'Gadgets' ? 'selected' : ''}}>Gadgets</option>
                            <option value="Furniture" {{$product->type == 'Furniture' ? 'selected' : ''}}>Furniture</option>
                            <option value="Appliances" {{$product->type == 'Appliances' ? 'selected' : ''}}>Appliances</option>
                            <option value="Software" {{$product->type == 'Software' ? 'selected' : ''}}>Software</option>
                            <option value="Music" {{$product->type == 'Music' ? 'selected' : ''}}>Music</option>
                            <option value="Food" {{$product->type == 'Food' ? 'selected' : ''}}>Food</option>
                            <option value="Other" {{$product->type == 'Other' ? 'selected' : ''}}>Other</option>
                        </select>
                        @error('type')
                            <h5 class="text-red-400 font-thin text-sm mt-[-0.5rem]">{{ $message }}</h5>
                        @enderror
                    </div>
                    <div class="flex flex-col">
                        <label class="mb-4" for="condition">Product Condition</label>
                        <select id="condition" class="rounded-md ring-gray-500 ring-2 p-2 bg-gray-100 drop-shadow-lg mb-4" name="condition">
                            <option value="">Select Condition</option>
                            <option value="New" {{$product->condition == 'New' ? 'selected' : ''}}>New</option>
                            <option value="Used" {{$product->condition == 'Used' ? 'selected' : ''}}>Used</option>
                            <option value="Refurbished" {{$product->condition == 'Refurbished' ? 'selected' : ''}}>Refurbished</option>
                        </select>
                        @error('condition')
                            <h5 class="text-red-400 font-thin text-sm mt-[-0.5rem]">{{ $message }}</h5>
                        @enderror
                    </div>
                </div>
                <div class="grid grid-cols-3 gap-20">
                    <div class="flex flex-col">
                        <label class="mb-4" for="stock">Stock</label>
                        <input type="number" name="stock" min="0" step="1" onchange="this.value = Math.max(0, Math.min(999, parseInt(this.value)));" class="rounded-md ring-gray-500 ring-2 p-2 bg-gray-100 drop-shadow-lg w-full mb-4" value="{{$product->stock}}" id="stock" placeholder="Enter Stock Count...">
                        @error('stock')
                            <h5 class="text-red-400 font-thin text-sm mt-[-0.5rem]">{{ $message }}</h5>
                        @enderror
                    </div>
                    <div class="flex flex-col">
                        <label class="mb-4" for="price">Price</label>
                        <input type="number" name="price" min="10000" step="1" onchange="this.value = Math.max(10000, Math.min(50000000, parseInt(this.value)));" class="rounded-md ring-gray-500 ring-2 p-2 bg-gray-100 drop-shadow-lg w-full mb-4" value="{{$product->price}}" id="price" placeholder="Enter Product Price...">
                        @error('price')
                            <h5 class="text-red-400 font-thin text-sm mt-[-0.5rem]">{{ $message }}</h5>
                        @enderror
                    </div>
                    
                </div>
                <div class="flex flex-col">
                    <label class="mb-4" for="description">Product Description</label>
                    <textarea type="text" rows="10" name="description" class="rounded-md ring-gray-500 ring-2 p-2 bg-gray-100 drop-shadow-lg mb-4" id="description" placeholder="Enter Product Description...">{{$product->description}}</textarea> 
                    @error('description')
                        <h5 class="text-red-400 font-thin text-sm mt-[-0.5rem]">{{ $message }}</h5>
                    @enderror
                </div>
                <button type="submit" class="bg-green-400 text-white rounded-md p-2 w-fit self-end mt-4">Confirm</button>
            </form>
        </div>
    </section>
    <section class="flex flex-col gap-2" id="product_images">
        <span class="text-2xl font-extrabold my-2">Product Images</span>
        @if ($message = session('img_success'))
        <span class="flex flex-row bg-green-200 rounded-md ring-1 ring-green-900 text-green-900 p-4" onclick="">
            {{ $message }} <button class="ml-auto font-extrabold" onclick="this.parentNode.remove()">X</button>
        </span>
        @endif
        <div class="flex flex-col bg-white shadow-md p-4 rounded-md">
            <div class="grid grid-cols-3 py-2 gap-8 border-b-2">
                @foreach ($product->images->toArray() as $image)
                    <div class="flex flex-col gap-2">   
                        <img class="mx-auto h-full object-contain" src="{{$image['image_url']}}" alt="">
                        <form class="flex flex-col" action="{{url('dashboard/product/image/' . $image['id'] . '/remove')}}" method="POST">
                            @csrf
                            <button type="submit" class="bg-red-500 text-white rounded-md p-2">Remove Image</button>
                        </form>
                    </div>
                @endforeach
            </div>
            <form action="{{url('dashboard/product/image/' . $product->id . '/add')}}" enctype="multipart/form-data" method="POST">
                @csrf
                <div class="flex flex-col gap-2">
                    <label class="my-4" for="image">Add Image</label>
                    <div class="flex">
                        <input type="file" accept="image/jpg, image/png, image/jpeg" class="rounded-md ring-2 ring-gray-500 p-1" name="image" id="image">
                        <button class="self-center bg-green-400 text-white rounded-md p-2 ml-auto" type="submit">Add Image</button>
                    </div>
                    @error('image')
                    <h5 class="text-red-400 font-thin text-sm">{{ $message }}</h5>
                    @enderror
                </div>
            </form>
        </div>
    </section>
</div>
@endsection