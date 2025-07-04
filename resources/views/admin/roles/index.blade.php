<x-app-layout>
    <div class="mb-6 flex flex-col md:flex-row justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Roles & Permissions</h1>
            <p class="text-gray-500">Manage user roles and what they are permitted to do.</p>
        </div>
        <a href="{{ route('admin.roles.create') }}" class="w-full md:w-auto mt-4 md:mt-0 bg-primary-600 hover:bg-primary-700 text-white py-2 px-4 rounded-lg font-medium text-center">
            <i class="fas fa-plus mr-2"></i> Add New Role
        </a>
    </div>

    @include('partials._session-messages')

    <div class="bg-white p-6 rounded-xl shadow-soft">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-600">
                <thead class="text-xs text-gray-700 uppercase bg-gray-100">
                    <tr>
                        <th scope="col" class="px-6 py-3">Role Name</th>
                        <th scope="col" class="px-6 py-3">Permissions</th>
                        <th scope="col" class="px-6 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($roles as $role)
                        <tr class="bg-white border-b hover:bg-primary-50">
                            <td class="px-6 py-4 font-bold text-gray-900 capitalize">{{ $role->name }}</td>
                            <td class="px-6 py-4">
                                <div class="flex flex-wrap gap-1">
                                    @if($role->name === 'super-admin')
                                        <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full">All Permissions</span>
                                    @else
                                        @forelse($role->permissions->sortBy('name') as $permission)
                                            <span class="bg-gray-200 text-gray-800 text-xs font-medium px-2.5 py-0.5 rounded-full">{{ $permission->name }}</span>
                                        @empty
                                            <span class="text-gray-400">No permissions assigned.</span>
                                        @endforelse
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 text-right">
                                @if($role->name !== 'super-admin')
                                    <div class="flex items-center justify-end space-x-3">
                                        <a href="{{ route('admin.roles.edit', $role) }}" class="text-primary-600 hover:text-primary-800 font-medium">Edit</a>

                                        @if(!in_array($role->name, ['admin', 'user']))
                                            <form action="{{ route('admin.roles.destroy', $role) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this role? This cannot be undone.');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-800 font-medium">Delete</button>
                                            </form>
                                        @endif
                                    </div>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center py-4 text-gray-500">No roles found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">{{ $roles->links() }}</div>
    </div>
</x-app-layout>
