<x-admin-layout>
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Orders List</h1>
        <button type="button" onclick="document.getElementById('status-form').submit();" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded">
            Save Changes
        </button>
    </div>

    <div class="overflow-x-auto bg-white shadow-md rounded-lg p-4">
        <form id="status-form" method="POST" action="{{ route('admin.orders.updateStatus') }}">
            @csrf
            @method('PUT')
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Price</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created At</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Detail Order</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($orders as $order)
                        <tr class="hover:bg-gray-100">
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $loop->iteration }}</td>
                            <td class="px-6 py-4 text-sm text-gray-900">{{ $order->user->name }}</td>
                            <td class="px-6 py-4 text-sm text-gray-900">Rp {{ number_format($order->total_price, 2) }}</td>
                            <td class="px-6 py-4 text-sm text-gray-900">
                                <select name="statuses[{{ $order->id }}]" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                    <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>Processing</option>
                                    <option value="shipped" {{ $order->status === 'shipped' ? 'selected' : '' }}>Shipped</option>
                                    <option value="delivered" {{ $order->status === 'delivered' ? 'selected' : '' }}>Delivered</option>
                                    <option value="canceled" {{ $order->status === 'canceled' ? 'selected' : '' }}>Canceled</option>
                                </select>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-900">{{ $order->created_at->format('d-m-Y H:i') }}</td>
                            <td class="px-6 py-4 text-sm text-right">
                                <a href="{{ route('admin.order.show', $order->id) }}" class="text-blue-500 hover:underline text-left" >View</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">No orders found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </form>
        <div class="mt-4">
            {{ $orders->links('pagination::tailwind') }}
        </div>
    </div>
</x-admin-layout>