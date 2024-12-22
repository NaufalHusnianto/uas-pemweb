<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Order Confirmation') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-2xl font-bold mb-6">Order Summary</h3>

                    <!-- Order Details -->
                    <div class="mb-4">
                        <p><strong>Order ID:</strong> {{ $order->id }}</p>
                        <p><strong>User:</strong> {{ $order->user->name }}</p>
                        <p><strong>Total Price:</strong> IDR {{ number_format($order->total_price, 2) }}</p>
                        <p><strong>Status:</strong> {{ ucfirst($order->status) }}</p>
                        <p><strong>Created At:</strong> {{ $order->created_at->format('d F Y, H:i') }}</p>
                        <p><strong>Last Updated:</strong> {{ $order->updated_at->format('d F Y, H:i') }}</p>
                    </div>

                    <!-- Order Items -->
                    <h4 class="text-xl font-bold mb-4">Order Items</h4>
                    <div class="overflow-auto">
                        <table class="w-full border-collapse border border-gray-300">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th class="border border-gray-300 px-4 py-2 text-left">#</th>
                                    <th class="border border-gray-300 px-4 py-2 text-left">Product Name</th>
                                    <th class="border border-gray-300 px-4 py-2 text-center">Quantity</th>
                                    <th class="border border-gray-300 px-4 py-2 text-right">Price</th>
                                    <th class="border border-gray-300 px-4 py-2 text-right">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($order->orderItems as $index => $item)
                                    <tr>
                                        <td class="border border-gray-300 px-4 py-2">{{ $index + 1 }}</td>
                                        <td class="border border-gray-300 px-4 py-2">{{ $item->product->name }}</td>
                                        <td class="border border-gray-300 px-4 py-2 text-center">{{ $item->quantity }}</td>
                                        <td class="border border-gray-300 px-4 py-2 text-right">IDR {{ number_format($item->price, 2) }}</td>
                                        <td class="border border-gray-300 px-4 py-2 text-right">IDR {{ number_format($item->quantity * $item->price, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-6">
                        @if ($order->status !== 'cancelled')
                            <form method="POST" action="{{ route('order.cancel', $order->id) }}" class="inline-block ml-4">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                                    Cancel Order
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
