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
                        <div>
                            <p class="font-medium">{{ $address->detail_address }}</p>
                            <p class="text-sm text-gray-600">
                                {{ $address->village_name }}, {{ $address->district_name }},
                                {{ $address->regency_name }}, {{ $address->province_name }}
                            </p>
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

        <!-- Add New Address Button -->
        <div class="mt-6">
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
</section>
