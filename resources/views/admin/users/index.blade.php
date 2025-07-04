<x-app-layout>
    {{-- Page Header --}}
    <div class="mb-6 flex flex-col md:flex-row justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">User Management</h1>
            <p class="text-gray-500">Manage all application users and their assigned roles.</p>
        </div>
        <a href="{{ route('admin.users.create') }}" class="w-full md:w-auto mt-4 md:mt-0 bg-primary-600 hover:bg-primary-700 text-white py-2 px-4 rounded-lg font-medium text-center">
            <i class="fas fa-plus mr-2"></i> Add New User
        </a>
    </div>

    @include('partials._session-messages')

    <div class="bg-white p-6 rounded-xl shadow-soft">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-600">
                <thead class="text-xs text-gray-700 uppercase bg-gray-100">
                    <tr>
                        <th scope="col" class="px-6 py-3">Name</th>
                        <th scope="col" class="px-6 py-3">Email</th>
                        <th scope="col" class="px-6 py-3">Roles</th>
                        <th scope="col" class="px-6 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        <tr class="bg-white border-b hover:bg-primary-50">
                            <td class="px-6 py-4 font-medium text-gray-900">{{ $user->name }}</td>
                            <td class="px-6 py-4">{{ $user->email }}</td>
                            <td class="px-6 py-4">
                                <div class="flex flex-wrap gap-1">
                                    @foreach($user->roles as $role)
                                        <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-full capitalize">{{ $role->name }}</span>
                                    @endforeach
                                </div>
                            </td>
                           {{-- This is the <td class="px-6 py-4"> cell for the actions --}}
<td class="px-6 py-4">
    <div class="flex items-center justify-end space-x-2">
        <!-- Edit Button with Tooltip -->
        <div class="relative group">
            <a href="{{ route('admin.users.edit', $user) }}" class="flex items-center justify-center w-8 h-8 rounded-full bg-gray-100 hover:bg-primary-100 text-primary-600 hover:text-primary-800 transition-colors">
                <i class="fas fa-pencil-alt"></i>
            </a>
            <span class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 px-2 py-1 text-xs text-white bg-gray-800 rounded-md opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-opacity pointer-events-none whitespace-nowrap">
                Edit User
            </span>
        </div>

        <!-- Delete Button with Tooltip -->
        @if (!$user->hasRole('super-admin') && auth()->id() !== $user->id)
            <div class="relative group">
                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this user?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="flex items-center justify-center w-8 h-8 rounded-full bg-gray-100 hover:bg-red-100 text-red-600 hover:text-red-800 transition-colors">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                    <span class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 px-2 py-1 text-xs text-white bg-gray-800 rounded-md opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-opacity pointer-events-none whitespace-nowrap">
                        Delete User
                    </span>
                </form>
            </div>
        @endif
    </div>
</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-4 text-gray-500">No users found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            {{ $users->links() }}
        </div>
    </div>
</x-app-layout>
