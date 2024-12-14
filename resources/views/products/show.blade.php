<x-admin-layout>
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-3xl font-bold">{{ $product->name }}</h1>
        <a href="{{ route('admin.product.index') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-4 rounded">
            Back to Product List
        </a>
    </div>

    <div class="bg-white p-6 rounded-lg shadow-lg">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="flex flex-col">
                <h2 class="text-xl font-semibold mb-2">Product Details</h2>
                <p><strong>Name:</strong> {{ $product->name }}</p>
                <p><strong>Category:</strong> {{ $product->category->name }}</p>
                <p><strong>Description:</strong> {{ $product->description }}</p>
                <p><strong>Price:</strong> ${{ number_format($product->price, 2) }}</p>
                <p><strong>Stock:</strong> {{ $product->stock }}</p>
                <p><strong>Status:</strong> {{ ucfirst($product->status) }}</p>
            </div>

            <div class="flex justify-center items-center">
                @if($product->image)
                    <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}" class="rounded-lg shadow-lg">
                @else
                    <p>No image available</p>
                @endif
            </div>
        </div>
        <a href="{{ route('admin.product.edit', $product->id) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-4 rounded">Edit</a>
        <a href="{{ route('admin.product.destroy', $product->id) }}" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-4 rounded">Delete</a>
    </div>
</x-admin-layout>
