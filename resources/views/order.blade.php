<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Order List') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-2xl font-bold mb-6">All Orders</h3>

                    <!-- Tabel Daftar Pesanan -->
                    <table class="min-w-full bg-white border border-gray-300 rounded-lg shadow-md">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="py-3 px-6 text-left text-sm font-medium text-gray-600">Order ID</th>
                                <th class="py-3 px-6 text-left text-sm font-medium text-gray-600">Total Price</th>
                                <th class="py-3 px-6 text-left text-sm font-medium text-gray-600">Status</th>
                                <th class="py-3 px-6 text-left text-sm font-medium text-gray-600">Created At</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)
                                <tr class="cursor-pointer hover:bg-gray-50" onclick="window.location='{{ route('order.show', $order->id) }}'">
                                    <td class="py-4 px-6 text-sm text-gray-800">{{ $order->id }}</td>
                                    <td class="py-4 px-6 text-sm text-gray-800">IDR {{ number_format($order->total_price, 2) }}</td>
                                    <td class="py-4 px-6 text-sm text-gray-800">{{ ucfirst($order->status) }}</td>
                                    <td class="py-4 px-6 text-sm text-gray-800">{{ $order->created_at->format('d F Y, H:i') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
