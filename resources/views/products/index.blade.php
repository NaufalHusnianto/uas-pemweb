<x-admin-layout>
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Product</h1>

        <a href="{{ route('admin.product.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-4 rounded">
            Create Product
        </a>
    </div>

    <div class="overflow-x-auto bg-white shadow-md rounded-lg p-4">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stock</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Image</th> <!-- New column for image -->
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($products as $product)
                    <tr class="cursor-pointer hover:bg-gray-100" onclick="window.location='{{ route('admin.product.detail', $product->id) }}'">
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $loop->iteration }}</td>
                        <td class="px-6 py-4 text-sm text-gray-900">{{ $product->name }}</td>
                        <td class="px-6 py-4 text-sm text-gray-900">{{ $product->category->name }}</td>
                        <td class="px-6 py-4 text-sm text-gray-900">IDR.{{ number_format($product->price, 2) }}</td>
                        <td class="px-6 py-4 text-sm text-gray-900">{{ $product->stock }}</td>
                        <td class="px-6 py-4 text-sm text-gray-900">{{ ucfirst($product->status) }}</td>
                        
                        <td class="px-6 py-4 text-sm">
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-16 h-16 object-cover">
                        </td>

                        <td class="px-6 py-4 text-sm">
                            <a href="{{ route('admin.product.edit', $product->id) }}" class="text-blue-500 hover:underline">Edit</a> |
                            <form action="{{ route('admin.product.destroy', $product->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:underline">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="px-6 py-4 text-center text-sm text-gray-500">No products found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        
        <div class="mt-4">
            {{ $products->links('pagination::tailwind') }}
        </div>
    </div>
</x-admin-layout>
