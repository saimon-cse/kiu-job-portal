<x-app-layout>
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Edit Role: <span class="text-primary-600 capitalize">{{ $role->name }}</span></h1>

    @include('partials._validation-errors')

    <div class="bg-white p-6 rounded-xl shadow-soft">
        <form action="{{ route('admin.roles.update', $role) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="space-y-8">
                {{-- Role Name --}}
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Role Name</label>
                    <div class="mt-1">
                        {{-- UPDATED CLASS --}}
                        <input type="text" name="name" id="name" value="{{ old('name', $role->name) }}" required class="block w-full md:w-1/2 px-3 py-2 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-500 sm:text-sm">
                    </div>
                </div>

                {{-- Include the shared permissions form --}}
                @include('admin.roles._permissions-form', ['rolePermissions' => $rolePermissions])
            </div>
            <div class="pt-8 flex justify-end space-x-3">
                <a href="{{ route('admin.roles.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 py-2 px-6 rounded-lg font-medium">Cancel</a>
                <button type="submit" class="bg-primary-600 hover:bg-primary-700 text-white py-2 px-6 rounded-lg font-medium">Update Role</button>
            </div>
        </form>
    </div>
</x-app-layout>
