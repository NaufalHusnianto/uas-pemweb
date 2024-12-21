<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Your Favourite Items') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <!-- Favourite Section -->
        <div class="max-w-7xl mx-auto px-6 sm:px-6 lg:px-8">
            @if ($favourites->isEmpty())
                <div class="text-center text-lg text-gray-700 py-24">
                    You haven't added your favorite items yet.
                    <a href="{{ route('products') }}" class="text-blue-600 hover:underline">Browse products</a> and add
                    some items!
                </div>
            @else
                <!-- Favourite Items -->
                <div class="space-y-6">
                    @foreach ($favourites as $favourite)
                        <div class="flex items-center justify-between p-4 border rounded-md shadow-sm">
                            <a href="{{ route('products.detail', $favourite->product->id) }}">
                                <div class="flex items-center space-x-4">

                                    <img src="{{ asset('storage/' . $favourite->product->image) }}"
                                        alt="{{ $favourite->product->name }}" class="w-20 h-20 object-cover rounded-md">
                                    <div>
                                        <h3 class="text-lg font-semibold">{{ $favourite->product->name }}</h3>
                                        <p class="text-sm text-gray-600">Price:
                                            ${{ number_format($favourite->product->price, 2) }}</p>
                                    </div>
                                </div>
                            </a>
                            <div class="flex items-center space-x-4">
                                <form action="{{ route('favourit.remove', $favourite->id) }}" method="POST"
                                    class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800">Remove</button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
