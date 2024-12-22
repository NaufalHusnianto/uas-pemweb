<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Manage Addresses') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Add or update your delivery addresses.') }}
        </p>
    </header>

    <div class="mt-6">
        <!-- Addresses List -->
        @if ($addresses->count() > 0)
            <div class="space-y-6">
                @foreach ($addresses as $address)
                    <div class="flex justify-between p-4 bg-white shadow rounded-lg">
                        <div class="flex justify-evenly items-center gap-5">
                            <input type="radio" name="selected_address" value="{{ $address->id }}" class="address-radio"
                                {{ $addresses->count() == 1 || (isset($selectedAddressId) && $selectedAddressId == $address->id) ? 'checked' : '' }}>
                            <div>
                                <p class="font-medium">{{ $address->detail_address }}</p>
                                <p class="text-sm text-gray-600">
                                    {{ $address->village_name }}, {{ $address->district_name }},
                                    {{ $address->regency_name }}, {{ $address->province_name }}
                                </p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-2">
                            <a href="{{ route('address.edit', $address) }}"
                                class="text-sm text-blue-600 hover:text-blue-800">
                                {{ __('Edit') }}
                            </a>
                            <form method="POST" action="{{ route('address.destroy', $address) }}" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-sm text-red-600 hover:text-red-800"
                                    onclick="return confirm('{{ __('Are you sure you want to delete this address?') }}')">
                                    {{ __('Delete') }}
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-600">{{ __('No addresses added yet.') }}</p>
        @endif

        <!-- Action Buttons -->
        <div class="mt-6 flex gap-4">
            <form method="POST" action="{{ route('address.select', $address) }}">

                <button onclick="saveSelectedAddress()"
                    class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700">
                    {{ __('Save Selection') }}
                </button>
            </form>

            <a href="{{ route('address.create') }}"
                class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                {{ __('Add New Address') }}
            </a>
        </div>
    </div>

    <!-- Success Message -->
    @if (session('success'))
        <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
            class="mt-4 p-4 text-sm text-green-600 bg-green-100 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    <!-- Alert Message Div -->
    <div id="alert-message" class="mt-4 p-4 text-sm rounded-lg hidden"></div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const addresses = document.querySelectorAll('.address-radio');
                if (addresses.length === 1) {
                    saveSelectedAddress();
                }
            });

            function saveSelectedAddress() {
                const selectedRadio = document.querySelector('input[name="selected_address"]:checked');

                if (!selectedRadio) {
                    showAlert('Please select an address first', 'error');
                    return;
                }

                const addressId = selectedRadio.value;

                fetch('{{ route('address.select') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            address_id: addressId
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            showAlert('Address saved successfully', 'success');
                        } else {
                            showAlert(data.message || 'Error saving address', 'error');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showAlert('Error saving address', 'error');
                    });
            }

            function showAlert(message, type) {
                const alertDiv = document.getElementById('alert-message');
                alertDiv.textContent = message;
                alertDiv.className = 'mt-4 p-4 text-sm rounded-lg';

                if (type === 'success') {
                    alertDiv.classList.add('bg-green-100', 'text-green-600');
                } else {
                    alertDiv.classList.add('bg-red-100', 'text-red-600');
                }

                alertDiv.classList.remove('hidden');

                setTimeout(() => {
                    alertDiv.classList.add('hidden');
                }, 3000);
            }
        </script>
    @endpush
</section>
