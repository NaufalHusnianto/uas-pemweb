<x-admin-layout>
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">User Detail</h1>
        <a href="{{ route('admin.user.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-6 rounded">
            Back to Users
        </a>
    </div>

    <div class="bg-white shadow-lg rounded-lg p-8">
        <div class="flex items-center mb-8">
            <div class="w-32 h-32 mr-6">
                <img src="{{ $user->photo_url ? asset('storage/' . $user->photo_url) : asset('user.png') }}" alt="Profile Photo" class="w-full h-full object-cover rounded-full border-2 border-gray-300">
            </div>
            <div>
                <h2 class="text-3xl font-semibold text-gray-800">{{ $user->name }}</h2>
                <p class="text-lg text-gray-500">{{ $user->email }}</p>
                <p class="text-sm text-gray-400 mt-2">
                    <strong>Registered:</strong> {{ $user->created_at->format('F j, Y') }}<br>
                    <strong>Last Updated:</strong> {{ $user->updated_at->format('F j, Y') }}<br>
                    <strong>Verified:</strong> {{ $user->email_verified_at ? $user->email_verified_at->format('F j, Y') : 'Not Verified' }}
                </p>
            </div>
        </div>

        <div class="space-y-6">
            <h3 class="text-2xl font-semibold text-gray-700">User Information</h3>
            <div class="grid grid-cols-1 gap-6">
                <div class="flex justify-between">
                    <span class="font-medium text-gray-700">Name:</span>
                    <span class="text-gray-900">{{ $user->name }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="font-medium text-gray-700">Email:</span>
                    <span class="text-gray-900">{{ $user->email }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="font-medium text-gray-700">Created At:</span>
                    <span class="text-gray-900">{{ $user->created_at->format('F j, Y') }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="font-medium text-gray-700">Updated At:</span>
                    <span class="text-gray-900">{{ $user->updated_at->format('F j, Y') }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="font-medium text-gray-700">Verified At:</span>
                    <span class="text-gray-900">{{ $user->email_verified_at ? $user->email_verified_at->format('F j, Y') : 'Not Verified' }}</span>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
