<div class="w-1/4 px-16 py-4 border-r border-gray-400">
    <h3 class="font-semibold text-lg mb-4">Categories</h3>
    <ul class="space-y-2">
        <li>
            <a href="{{ route('products', ['category' => null]) }}" class="text-gray-700 p-2 rounded-full w-full hover:text-gray-600 {{ $category === null ? 'bg-gray-700 text-white' : '' }}">
                All
            </a>
        </li>
        @foreach($categories as $categoryItem)
            <li>
                <a href="{{ route('products', ['category' => $categoryItem->id]) }}" class="text-gray-700 p-2 rounded-full w-full hover:text-gray-600 {{ $category && $categoryItem->id === $category->id ? 'bg-gray-700 text-white' : '' }}">
                    {{ $categoryItem->name }}
                </a>
            </li>
        @endforeach
    </ul>
</div>
