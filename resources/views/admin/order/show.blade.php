<x-admin-layout>
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Order Detail</h1>
        <a href="{{ route('admin.order.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-6 rounded">
            Back to Orders
        </a>
    </div>

    <div class="bg-white shadow-lg rounded-lg p-8">
        <div class="mb-8">
            <h2 class="text-2xl font-semibold text-gray-700">Order Information</h2>
            <div class="space-y-2 mt-4">
                <div class="flex justify-between">
                    <span class="font-medium text-gray-700">Customer Name:</span>
                    <span class="text-gray-900">{{ $order->user->name }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="font-medium text-gray-700">Total Price:</span>
                    <span class="text-gray-900">Rp {{ number_format($order->total_price, 2) }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="font-medium text-gray-700">Status:</span>
                    <span class="text-gray-900">{{ ucfirst($order->status) }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="font-medium text-gray-700">Created At:</span>
                    <span class="text-gray-900">{{ $order->created_at->format('d-m-Y H:i') }}</span>
                </div>
            </div>
        </div>

        <div>
            <h2 class="text-2xl font-semibold text-gray-700 mb-4">Order Items</h2>
            <table class="min-w-full divide-y divide-gray-200 bg-white shadow-md rounded-lg">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($order->orderItems as $item)
                        <tr class="hover:bg-gray-100">
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $loop->iteration }}</td>
                            <td class="px-6 py-4 text-sm text-gray-900">{{ $item->product->name }}</td>
                            <td class="px-6 py-4 text-sm text-gray-900">{{ $item->quantity }}</td>
                            <td class="px-6 py-4 text-sm text-gray-900">Rp {{ number_format($item->price, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-admin-layout>