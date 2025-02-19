<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Your Cart') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <!-- Cart Section -->
        <div class="max-w-7xl mx-auto px-6 sm:px-6 lg:px-8">
            @if ($carts->isEmpty())
                <div class="text-center text-lg text-gray-700 py-24">
                    Your cart is empty. <a href="{{ route('products') }}" class="text-blue-600 hover:underline">Browse products</a> and add some items!
                </div>
            @else
                <!-- Cart Items -->
                <div class="space-y-6">
                    @foreach ($carts as $cart)
                        <div class="flex items-center justify-between p-4 border rounded-md shadow-sm">
                            <div class="flex items-center space-x-4">
                                <input type="checkbox" class="cart-checkbox" data-id="{{ $cart->id }}" data-price="{{ $cart->product->price }}" data-quantity="{{ $cart->quantity }}">
                                <img src="{{ asset('storage/'.$cart->product->image) }}" alt="{{ $cart->product->name }}" class="w-20 h-20 object-cover rounded-md">
                                <div>
                                    <h3 class="text-lg font-semibold">{{ $cart->product->name }}</h3>
                                    <p class="text-sm text-gray-600">Quantity: {{ $cart->quantity }}</p>
                                </div>
                            </div>
                            <div class="flex items-center space-x-4">
                                <span class="text-lg font-semibold">${{ number_format($cart->product->price * $cart->quantity, 2) }}</span>
                                <form action="{{ route('cart.remove', $cart->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800">Remove</button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Cart Summary -->
                <div class="mt-6 flex justify-between items-center bg-gray-100 p-4 rounded-md shadow-md">
                    <div>
                        <h3 class="text-xl font-semibold">Cart Summary</h3>
                    </div>
                    <div>
                        <p class="text-lg font-semibold">Total: <span class="cart-summary-total">${{ number_format($carts->sum(function ($cart) { return $cart->product->price * $cart->quantity; }), 2) }}</span></p>
                    </div>
                </div>

                <!-- Checkout Form -->
                <form id="checkout-form" action="{{ route('order.confirm') }}" method="POST" class="hidden">
                    @csrf
                    <input type="hidden" name="selected_items" id="selected-items" value="">
                    <input type="hidden" name="total_price" id="total-price" value="">
                </form>

                <!-- Checkout Buttons -->
                <div class="mt-6 flex justify-between">
                    <a href="{{ route('products') }}" class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                        Continue Shopping
                    </a>
                    <button type="button" id="proceed-to-checkout" class="px-6 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                        Proceed to Checkout
                    </button>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>

<script>
    $(document).ready(function() {
        function updateTotalPrice() {
            let total = 0;
            $('.cart-checkbox:checked').each(function() {
                let price = $(this).data('price');
                let quantity = $(this).data('quantity');
                total += price * quantity;
            });

            $('.cart-summary-total').text('$' + total.toFixed(2));
            $('#total-price').val(total.toFixed(2));
        }

        function updateSelectedItems() {
            let selectedItems = [];
            $('.cart-checkbox:checked').each(function() {
                selectedItems.push($(this).data('id'));
            });

            $('#selected-items').val(JSON.stringify(selectedItems));
        }

        $('.cart-checkbox').on('change', function() {
            updateTotalPrice();
            updateSelectedItems();
        });

        $('#proceed-to-checkout').on('click', function() {
            if ($('.cart-checkbox:checked').length === 0) {
                alert('Please select at least one item to proceed to checkout.');
                return;
            }

            $('#checkout-form').submit();
        });

        updateTotalPrice();
        updateSelectedItems();
    });
</script>
