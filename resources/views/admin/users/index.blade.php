<x-admin-layout>
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Users</h1>
    </div>

    <div class="overflow-x-auto bg-white shadow-md rounded-lg p-4">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Photo</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created At</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Verified At</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($users as $user)
                    <tr class="cursor-pointer hover:bg-gray-100" onclick="window.location='{{ route('admin.user.show', $user->id) }}'">
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $loop->iteration }}</td>
                        <td class="px-6 py-4 text-sm text-gray-900">{{ $user->name }}</td>
                        <td class="px-6 py-4 text-sm text-gray-900">{{ $user->email }}</td>
                        <td class="px-6 py-4 text-sm">
                            @if ($user->photo_url)
                                <img src="{{ asset('storage/' . $user->photo_url) }}" alt="{{ $user->name }}" class="w-16 h-16 object-cover rounded-full">
                            @else
                                <span class="text-gray-500">No Photo</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900">{{ $user->created_at->format('d-m-Y H:i') }}</td>
                        <td class="px-6 py-4 text-sm text-gray-900">
                            @if ($user->verified_at)
                                {{ $user->verified_at->format('d-m-Y H:i') }}
                            @else
                                <span class="text-gray-500">Not Verified</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm">
                            <form action="{{ route('admin.user.destroy', $user->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:underline">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-4 text-center text-sm text-gray-500">No users found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-4">
            {{ $users->links('pagination::tailwind') }}
        </div>
    </div>
</x-admin-layout>
