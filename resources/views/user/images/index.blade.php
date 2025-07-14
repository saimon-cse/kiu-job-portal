<x-profile-layout>
    <div class="space-y-8">
        @include('partials._session-messages')

        {{-- Main Form Card --}}
        <div class="bg-white p-6 rounded-xl shadow-soft">
            <h2 class="text-xl font-bold text-gray-800 mb-6 border-b pb-4">Manage Picture & Signature</h2>

            <form action="{{ route('images.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-start">

                    {{-- Profile Picture Section --}}
                    <div>
                        <h3 class="font-semibold text-lg text-gray-700">Profile Picture</h3>
                        <p class="text-sm text-gray-500 mt-1">Upload a professional headshot. (Max 1MB)</p>

                        <div class="mt-4">
                            <label for="profile_picture" class="block text-sm font-medium text-gray-700">Choose file</label>
                            <input type="file" name="profile_picture" id="profile_picture" accept="image/jpeg,image/png"
                                   class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:font-semibold file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100 cursor-pointer">
                            <x-input-error :messages="$errors->get('profile_picture')" class="mt-2" />
                        </div>

                        @if ($user->profile_picture)
                            <div class="mt-4">
                                <p class="text-sm font-medium text-gray-700">Current Picture:</p>
                                <img src="{{ Storage::url($user->profile_picture) }}" alt="Current Profile Picture" class="mt-2 h-32 w-32 rounded-full object-cover border-4 border-white shadow">
                            </div>
                        @endif
                    </div>

                    {{-- Signature Section --}}
                    <div>
                        <h3 class="font-semibold text-lg text-gray-700">Signature</h3>
                        <p class="text-sm text-gray-500 mt-1">Upload a clear image of your signature. (Max 512KB)</p>

                        <div class="mt-4">
                            <label for="signature_path" class="block text-sm font-medium text-gray-700">Choose file</label>
                            <input type="file" name="signature_path" id="signature_path" accept="image/jpeg,image/png"
                                   class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:font-semibold file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100 cursor-pointer">
                            <x-input-error :messages="$errors->get('signature_path')" class="mt-2" />
                        </div>

                        @if ($userProfile->signature_path)
                            <div class="mt-4">
                                <p class="text-sm font-medium text-gray-700">Current Signature:</p>
                                <div class="mt-2 p-4 bg-gray-100 rounded-lg inline-block">
                                    <img src="{{ Storage::url($userProfile->signature_path) }}" alt="Current Signature" class="h-16 w-auto">
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="pt-8 flex justify-end">
                    <button type="submit" class="bg-primary-600 hover:bg-primary-700 text-white py-2 px-6 rounded-lg font-medium">
                        Upload & Save Images
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-profile-layout>
