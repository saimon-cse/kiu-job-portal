<x-app-layout>
    {{-- Session Status Messages for password updates --}}
    @if (session('status') === 'password-updated')
         <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
            <p>Your password has been updated successfully.</p>
        </div>
    @endif

    <div class="space-y-8">
        {{-- Section 1: Update Password --}}
        <div class="bg-white p-6 rounded-xl shadow-soft">
             @include('profile.partials.update-password-form')
        </div>

        {{-- Section 2: Delete Account --}}
        {{-- <div class="bg-white p-6 rounded-xl shadow-soft">
            @include('profile.partials.delete-user-form')
        </div> --}}
    </div>
</x-app-layout>
