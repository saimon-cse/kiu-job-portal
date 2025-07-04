<x-app-layout>
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Edit User: <span class="text-primary-600">{{ $user->name }}</span></h1>

    @include('partials._validation-errors')

    <div class="bg-white p-6 rounded-xl shadow-soft">
        <form action="{{ route('admin.users.update', $user) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="space-y-6">
                <!-- Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Full Name</label>
                    <div class="mt-1">
                        <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required
                               class="block w-full md:w-1/2 px-3 py-2 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-500 sm:text-sm">
                    </div>
                </div>
                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                    <div class="mt-1">
                        <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required
                               class="block w-full md:w-1/2 px-3 py-2 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-500 sm:text-sm">
                    </div>
                </div>
                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">New Password (leave blank to keep current)</label>
                    <div class="mt-1">
                        <input type="password" name="password" id="password"
                               class="block w-full md:w-1/2 px-3 py-2 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-500 sm:text-sm">
                    </div>
                </div>
                <!-- Confirm Password -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm New Password</label>
                    <div class="mt-1">
                        <input type="password" name="password_confirmation" id="password_confirmation"
                               class="block w-full md:w-1/2 px-3 py-2 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-500 sm:text-sm">
                    </div>
                </div>
                <!-- Roles -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Roles</label>
                    <div class="mt-2 space-y-2">
                        @foreach($roles as $role)
                            <div class="flex items-center">
                                <input type="checkbox" name="roles[]" value="{{ $role }}" id="role_{{ $role }}"
                                       @if(in_array($role, old('roles', $userRoles))) checked @endif
                                       class="h-4 w-4 rounded border-gray-300 text-primary-600 focus:ring-primary-500">
                                <label for="role_{{ $role }}" class="ml-2 text-sm text-gray-700 capitalize">{{ $role }}</label>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="pt-8 flex justify-end space-x-3">
                <a href="{{ route('admin.users.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 py-2 px-6 rounded-lg font-medium">Cancel</a>
                <button type="submit" class="bg-primary-600 hover:bg-primary-700 text-white py-2 px-6 rounded-lg font-medium">Update User</button>
            </div>
        </form>
    </div>
</x-app-layout>
