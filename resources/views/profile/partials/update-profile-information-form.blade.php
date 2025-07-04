<header>
    <h2 class="text-lg font-medium text-gray-900">
        Account Information
    </h2>
    <p class="mt-1 text-sm text-gray-600">
        Update your account's display name and email address.
    </p>
</header>
<div class="mt-6 space-y-6">
    <div>
        <label for="name" class="block text-sm font-medium text-gray-700">Display Name</label>
        <input id="name" name="name" type="text" class="mt-1 block w-full md:w-2/3 px-3 py-2 border border-gray-300 rounded-lg shadow-sm" value="{{ old('name', $user->name) }}" required autofocus />
        <x-input-error class="mt-2" :messages="$errors->get('name')" />
    </div>
    <div>
        <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
        <input id="email" name="email" type="email" class="mt-1 block w-full md:w-2/3 px-3 py-2 border border-gray-300 rounded-lg shadow-sm" value="{{ old('email', $user->email) }}" required />
        <x-input-error class="mt-2" :messages="$errors->get('email')" />

        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
            <div class="mt-2">
                <p class="text-sm text-gray-800">
                    Your email address is unverified.
                    <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Click here to re-send the verification email.
                    </button>
                </p>
                @if (session('status') === 'verification-link-sent')
                    <p class="mt-2 font-medium text-sm text-green-600">
                        A new verification link has been sent to your email address.
                    </p>
                @endif
            </div>
        @endif
    </div>
</div>
