<x-app-layout>
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Publication Types</h1>
            <p class="text-gray-500">Manage the categories for user publications (e.g., Book, Journal Article).</p>
        </div>
        <a href="{{ route('admin.publication-types.create') }}" class="bg-primary-600 hover:bg-primary-700 text-white py-2 px-4 rounded-lg font-medium">
            <i class="fas fa-plus mr-2"></i> Add New Type
        </a>
    </div>

    @include('partials._session-messages')

    <div class="bg-white p-6 rounded-xl shadow-soft">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-600">
                <thead class="text-xs text-gray-700 uppercase bg-gray-100">
                    <tr>
                        <th scope="col" class="px-6 py-3">Type Name</th>
                        <th scope="col" class="px-6 py-3">Slug</th>
                        <th scope="col" class="px-6 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($publicationTypes as $type)
                        <tr class="bg-white border-b hover:bg-primary-50">
                            <td class="px-6 py-4 font-medium text-gray-900">{{ $type->name }}</td>
                            <td class="px-6 py-4 font-mono text-sm text-gray-500">{{ $type->slug }}</td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-end space-x-2">
                                    <div class="relative group">
                                        <a href="{{ route('admin.publication-types.edit', $type) }}" class="flex items-center justify-center w-8 h-8 rounded-full bg-gray-100 hover:bg-primary-100 text-primary-600">
                                            <i class="fas fa-pencil-alt"></i>
                                        </a>
                                        <span class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 px-2 py-1 text-xs text-white bg-gray-800 rounded-md opacity-0 invisible group-hover:opacity-100 group-hover:visible pointer-events-none">Edit</span>
                                    </div>
                                    <div class="relative group">
                                        <form action="{{ route('admin.publication-types.destroy', $type) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this type?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="flex items-center justify-center w-8 h-8 rounded-full bg-gray-100 hover:bg-red-100 text-red-600">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                            <span class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 px-2 py-1 text-xs text-white bg-gray-800 rounded-md opacity-0 invisible group-hover:opacity-100 group-hover:visible pointer-events-none">Delete</span>
                                        </form>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center py-4">No publication types found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">{{ $publicationTypes->links() }}</div>
    </div>
</x-app-layout>
