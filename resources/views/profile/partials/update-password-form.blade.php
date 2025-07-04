<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            Update Password
        </h2>
        <p class="mt-1 text-sm text-gray-600">
            Ensure your account is using a long, random password to stay secure.
        </p>
    </header>
    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')
        <div>
            <label for="update_password_current_password" class="block text-sm font-medium text-gray-700">Current Password</label>
            <input id="update_password_current_password" name="current_password" type="password" class="mt-1 block w-full md:w-2/3 px-3 py-2 border border-gray-300 rounded-lg shadow-sm" autocomplete="current-password" />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>
        <div>
            <label for="update_password_password" class="block text-sm font-medium text-gray-700">New Password</label>
            <input id="update_password_password" name="password" type="password" class="mt-1 block w-full md:w-2/3 px-3 py-2 border border-gray-300 rounded-lg shadow-sm" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>
        <div>
            <label for="update_password_password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password</label>
            <input id="update_password_password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full md:w-2/3 px-3 py-2 border border-gray-300 rounded-lg shadow-sm" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>
        <div class="flex items-center gap-4">
            <button type="submit" class="bg-primary-600 hover:bg-primary-700 text-white py-2 px-6 rounded-lg font-medium">Save</button>
        </div>
    </form>
</section>
