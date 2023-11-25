@extends('app-layout')

@section('main')
<div class="flex flex-col gap-3 p-4 min-h-full w-full bg-green-50">
    <span class="text-2xl font-extrabold">Add Product</span>
    <section class="flex flex-col">
        <div class="bg-white shadow-md p-4 rounded-md">
            <form class="flex flex-col px-20 py-10" action="{{url('dashboard/product/create')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="grid grid-cols-3 gap-20">
                    <div class="flex flex-col">
                        <label class="mb-4" for="name">Product Name</label>
                        <input type="text" name="name" class="rounded-md ring-gray-500 ring-2 p-2 bg-gray-100 drop-shadow-lg w-full mb-4" value="{{old('name')}}" id="name" placeholder="Enter Product Name..." autocomplete="name">
                        @error('name')
                            <h5 class="text-red-400 font-thin text-sm mt-[-0.5rem]">{{ $message }}</h5>
                        @enderror
                    </div>
                    <div class="flex flex-col">
                        <label class="mb-4" for="name">Product Type</label>
                        <select id="type" class="rounded-md ring-gray-500 ring-2 p-2 bg-gray-100 drop-shadow-lg mb-4" name="type">
                            <option value="">Select Type</option>
                            <option value="Books" {{old('type') == 'Books' ? 'selected' : ''}}>Books</option>
                            <option value="E-Books" {{old('type') == 'E-Books' ? 'selected' : ''}}>E-Books</option>
                            <option value="Gadgets" {{old('type') == 'Gadgets' ? 'selected' : ''}}>Gadgets</option>
                            <option value="Furniture" {{old('type') == 'Furniture' ? 'selected' : ''}}>Furniture</option>
                            <option value="Appliances" {{old('type') == 'Appliances' ? 'selected' : ''}}>Appliances</option>
                            <option value="Software" {{old('type') == 'Software' ? 'selected' : ''}}>Software</option>
                            <option value="Music" {{old('type') == 'Music' ? 'selected' : ''}}>Music</option>
                            <option value="Food" {{old('type') == 'Food' ? 'selected' : ''}}>Food</option>
                            <option value="Other" {{old('type') == 'Other' ? 'selected' : ''}}>Other</option>
                        </select>
                        @error('type')
                            <h5 class="text-red-400 font-thin text-sm mt-[-0.5rem]">{{ $message }}</h5>
                        @enderror
                    </div>
                    <div class="flex flex-col">
                        <label class="mb-4" for="condition">Product Condition</label>
                        <select id="condition" class="rounded-md ring-gray-500 ring-2 p-2 bg-gray-100 drop-shadow-lg mb-4" name="condition">
                            <option value="">Select Condition</option>
                            <option value="New" {{old('condition') == 'New' ? 'selected' : ''}}>New</option>
                            <option value="Used" {{old('condition') == 'Used' ? 'selected' : ''}}>Used</option>
                            <option value="Refurbished" {{old('condition') == 'Refurbished' ? 'selected' : ''}}>Refurbished</option>
                        </select>
                        @error('condition')
                            <h5 class="text-red-400 font-thin text-sm mt-[-0.5rem]">{{ $message }}</h5>
                        @enderror
                    </div>
                </div>
                <div class="grid grid-cols-3 gap-20">
                    <div class="flex flex-col">
                        <label class="mb-4" for="stock">Stock</label>
                        <input type="number" name="stock" min="0" step="1" onchange="this.value = Math.max(0, Math.min(999, parseInt(this.value)));" class="rounded-md ring-gray-500 ring-2 p-2 bg-gray-100 drop-shadow-lg w-full mb-4" value="{{old('stock')}}" id="stock" placeholder="Enter Stock Count...">
                        @error('stock')
                            <h5 class="text-red-400 font-thin text-sm mt-[-0.5rem]">{{ $message }}</h5>
                        @enderror
                    </div>
                    <div class="flex flex-col">
                        <label class="mb-4" for="price">Price</label>
                        <input type="number" name="price" min="10000" step="1" onchange="this.value = Math.max(10000, Math.min(50000000, parseInt(this.value)));" class="rounded-md ring-gray-500 ring-2 p-2 bg-gray-100 drop-shadow-lg w-full mb-4" value="{{old('price')}}" id="price" placeholder="Enter Product Price...">
                        @error('price')
                            <h5 class="text-red-400 font-thin text-sm mt-[-0.5rem]">{{ $message }}</h5>
                        @enderror
                    </div>
                    <div class="flex flex-col">
                        <label class="mb-4" for="image">Image</label>
                        <input type="file" accept="image/jpg, image/png, image/jpeg" class="rounded-md ring-2 ring-gray-500 p-1 mb-4" name="image" id="image">
                    @error('image')
                        <h5 class="text-red-400 font-thin text-sm mt-[-0.5rem]">{{ $message }}</h5>
                    @enderror
                    </div>
                </div>
                <div class="flex flex-col">
                    <label class="mb-4" for="description">Product Description</label>
                    <textarea type="text" rows="10" name="description" class="rounded-md ring-gray-500 ring-2 p-2 bg-gray-100 drop-shadow-lg mb-4" id="description" placeholder="Enter Product Description...">{{old('description')}}</textarea> 
                    @error('description')
                        <h5 class="text-red-400 font-thin text-sm mt-[-0.5rem]">{{ $message }}</h5>
                    @enderror
                </div>
                <button type="submit" class="bg-green-400 text-white rounded-md p-2 w-fit self-end mt-4">Add Product</button>
            </form>
        </div>
    </section>
</div>
@endsection