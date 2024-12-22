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
                    <h3 class="text-2xl font-bold">Order Summary</h3>
                    <p>Total Price: IDR {{ number_format($order->total_price, 2) }}</p>
                    <p>Status: {{ ucfirst($order->status) }}</p>
                    <a href="{{ route('payment.show', $order->id) }}" class="mt-4 inline-block px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                        Proceed to Payment
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
