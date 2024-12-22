<x-admin-layout>
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Order Detail</h1>
        <a href="{{ route('admin.order.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-6 rounded">
            Back to Orders
        </a>
    </div>

    <div class="bg-white shadow-lg rounded-lg p-8">
        <!-- Order Information -->
        <div class="mb-8">
            <h2 class="text-2xl font-semibold text-gray-700">Order Information</h2>
            <div class="space-y-2 mt-4">
                <div class="flex justify-between">
                    <span class="font-medium text-gray-700">Order ID:</span>
                    <span class="text-gray-900">{{ $order->id }}</span>
                </div>
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

        <!-- Order Items -->
        <div>
            <h2 class="text-2xl font-semibold text-gray-700 mb-4">Order Items</h2>
            <table class="min-w-full divide-y divide-gray-200 bg-white shadow-md rounded-lg">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price / Unit</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($order->orderItems as $item)
                        <tr class="hover:bg-gray-100">
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $loop->iteration }}</td>
                            <td class="px-6 py-4 text-sm text-gray-900">{{ $item->product->id }}</td>
                            <td class="px-6 py-4 text-sm text-gray-900">{{ $item->product->name }}</td>
                            <td class="px-6 py-4 text-sm text-gray-900">{{ $item->quantity }}</td>
                            <td class="px-6 py-4 text-sm text-gray-900">Rp {{ number_format($item->price, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Payment Section -->
        <div class="mt-6">
            <h2 class="text-xl font-semibold text-gray-700">Payment Information</h2>
            @if ($order->payment)
                <div class="mt-2">
                    <p><strong>Payment Method:</strong> {{ ucfirst($order->payment->method) }}</p>
                    <p><strong>Status:</strong> 
                        @if($order->payment->status === 'confirmed')
                            <span class="text-green-600">Confirmed</span>
                        @elseif($order->payment->status === 'failed')
                            <span class="text-red-600">Failed</span>
                        @else
                            <span class="text-gray-600">Pending</span>
                        @endif
                    </p>

                    <!-- Update Payment Status Form -->
                    <form action="{{ route('admin.order.updatePaymentStatus', $order->id) }}" method="POST" class="mt-4">
                        @csrf
                        @method('PUT')
                        <div class="flex items-center">
                            <label for="payment_status" class="mr-4">Update Payment Status:</label>
                            <select name="payment_status" id="payment_status" class="px-8 py-2 border rounded-md">
                                <option value="pending" {{ $order->payment->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="confirmed" {{ $order->payment->status === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                <option value="failed" {{ $order->payment->status === 'failed' ? 'selected' : '' }}>Failed</option>
                            </select>
                            <button type="submit" class="ml-4 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Update</button>
                        </div>
                    </form>
                </div>
            @else
                <p>No payment information available.</p>
            @endif
        </div>

        <!-- Shipment Section -->
        <div class="mt-6">
            <h2 class="text-xl font-semibold text-gray-700">Shipment Information</h2>
            @if ($order->payment && $order->payment->status === 'confirmed')
                @if ($order->shipment)
                    <!-- Update Shipment Status Form -->
                    <p>
                        <strong>Status:</strong>
                        <span class="{{ $order->shipment->status === 'delivered' ? 'text-green-500' : '' }}">
                            {{ ucfirst($order->shipment->status) }}
                        </span>
                    </p>
                    
                    @if ($order->shipment->status === 'shipped')
                        <p><strong>Shipped At:</strong> {{ $order->shipment->created_at->format('d-m-Y H:i') }}</p>
                    @elseif ($order->shipment->status === 'delivered')
                        <p><strong>Delivered At:</strong> {{ $order->shipment->created_at->format('d-m-Y H:i') }}</p>
                    @endif
                    
                    <form action="{{ route('admin.order.updateShipmentStatus', $order->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="flex items-center">
                            <label for="status" class="mr-4">Update Shipment Status:</label>
                            <select name="status" id="status" class="px-8 py-2 border rounded-md" required>
                                <option value="pending" {{ $order->shipment->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="shipped" {{ $order->shipment->status === 'shipped' ? 'selected' : '' }}>Shipped</option>
                                <option value="delivered" {{ $order->shipment->status === 'delivered' ? 'selected' : '' }}>Delivered</option>
                            </select>
                            <button type="submit" class="ml-4 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Update</button>
                        </div>
                    </form>                    
                @else
                    <!-- Create Shipment Form -->
                    <form action="{{ route('admin.order.createShipment', $order->id) }}" method="POST">
                        @csrf
                        <label for="status">Shipment Status:</label>
                        <select name="status" id="status" required>
                            <option value="pending">Pending</option>
                            <option value="shipped">Shipped</option>
                            <option value="delivered">Delivered</option>
                        </select>

                        <button type="submit" class="ml-4 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Create Shipment</button>
                    </form>
                @endif
            @else
                <p>No shipment information available.</p>
            @endif
        </div>
    </div>
</x-admin-layout>
