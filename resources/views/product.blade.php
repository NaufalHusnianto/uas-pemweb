<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Our Products') }}
        </h2>
    </x-slot>

    <div class="py-6 flex">
        <!-- Sidebar -->
        @include('components.category-sidebar', ['categories' => $categories, 'selectedCategories' => $selectedCategories])

        <div class="w-3/4 pl-6">
            <h1 class="text-3xl mb-4">
                Our Products
            </h1>

            @if($selectedCategories && !in_array('all', $selectedCategories))
                <p class="text-lg text-gray-600 mb-4">Showing products for categories: 
                    {{ implode(', ', $categories->whereIn('id', $selectedCategories)->pluck('name')->toArray()) }}
                </p>
            @endif

            @if($products->isEmpty())
                <p class="text-lg text-gray-600">No products available.</p>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    @foreach($products as $product)
                        <div class="bg-white p-4 rounded-lg shadow-md">
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-48 object-cover rounded-md mb-4">
                            <h2 class="text-xl font-semibold">{{ $product->name }}</h2>
                            <p class="text-gray-600 mt-2">
                                @foreach($product->categories as $category)
                                    {{ $category->name }}@if(!$loop->last), @endif
                                @endforeach
                            </p>
                            <p class="text-lg font-semibold text-blue-600 mt-2">IDR {{ number_format($product->price, 2) }}</p>

                            <div class="mt-4">
                                <a href="{{ route('products.show', $product->id) }}" class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded-md">View Details</a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

            <!-- Pagination -->
            <div class="mt-6">
                {{ $products->links('pagination::tailwind') }}
            </div>
        </div>
    </div>
</x-app-layout>
