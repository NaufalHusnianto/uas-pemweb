<x-admin-layout>
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-3xl font-bold">Edit Product</h1>
        <a href="{{ route('admin.product.index') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-4 rounded">
            Back
        </a>
    </div>

    <div class="bg-white p-6 rounded shadow-md">
        <form action="{{ route('admin.product.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                <input type="text" name="name" id="name" class="w-full border-gray-300 rounded-md" value="{{ old('name', $product->name) }}">
                @error('name')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                <textarea name="description" id="description" rows="4" class="w-full border-gray-300 rounded-md">{{ old('description', $product->description) }}</textarea>
                @error('description')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Categories</label>
                <div class="grid grid-cols-2 gap-2">
                    @foreach ($categories as $category)
                        <div class="flex items-center">
                            <input type="checkbox" name="category_id[]" value="{{ $category->id }}" 
                            @if(in_array($category->id, old('category_id', $product->categories->pluck('id')->toArray()))) checked @endif>
                            <label>{{ $category->name }}</label>
                        </div>
                    @endforeach
                </div>
                @error('category_id')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="price" class="block text-sm font-medium text-gray-700">Price</label>
                <input type="number" name="price" id="price" class="w-full border-gray-300 rounded-md" value="{{ old('price', $product->price) }}">
                @error('price')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="stock" class="block text-sm font-medium text-gray-700">Stock</label>
                <input type="number" name="stock" id="stock" class="w-full border-gray-300 rounded-md" value="{{ old('stock', $product->stock) }}">
                @error('stock')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="image" class="block text-sm font-medium text-gray-700">Image</label>
                <input type="file" name="image" id="image" class="w-full border-gray-300 rounded-md">
                @if ($product->image)
                    <div class="mt-2">
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-32 h-32 object-cover">
                    </div>
                @endif
                @error('image')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="text-right">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-md">
                    Update Product
                </button>
            </div>
        </form>
    </div>
</x-admin-layout>
