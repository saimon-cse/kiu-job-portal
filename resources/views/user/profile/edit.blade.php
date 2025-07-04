<x-profile-layout>
    {{-- Session Status Messages --}}
    @if (session('status') === 'profile-updated')
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
            <p>Your profile has been saved successfully.</p>
        </div>
    @elseif (session('status') === 'password-updated')
         <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
            <p>Your password has been updated successfully.</p>
        </div>
    @endif

    {{-- Main Form for Personal and Account Info --}}
    <form method="post" action="{{ route('profile.update') }}">
        @csrf
        @method('patch')

        <div class="space-y-8">
            {{-- Section 1: Core Account Info --}}
            <div class="bg-white p-6 rounded-xl shadow-soft">
                @include('profile.partials.update-profile-information-form')
            </div>

            {{-- Section 2: Detailed Personal Information --}}
            <div class="bg-white p-6 rounded-xl shadow-soft">
                <h2 class="text-lg font-medium text-gray-900">
                    Detailed Personal Information
                </h2>
                <p class="mt-1 text-sm text-gray-600">
                    This information will be used for job applications.
                </p>

                <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- English Names -->
                    <div>
                        <label for="full_name_en" class="block text-sm font-medium text-gray-700">Full Name (English)</label>
                        <input id="full_name_en" name="full_name_en" type="text" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm" value="{{ old('full_name_en', $userProfile->full_name_en) }}" />
                    </div>
                    <div>
                        <label for="father_name_en" class="block text-sm font-medium text-gray-700">Father's Name (English)</label>
                        <input id="father_name_en" name="father_name_en" type="text" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm" value="{{ old('father_name_en', $userProfile->father_name_en) }}" />
                    </div>
                    <div>
                        <label for="mother_name_en" class="block text-sm font-medium text-gray-700">Mother's Name (English)</label>
                        <input id="mother_name_en" name="mother_name_en" type="text" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm" value="{{ old('mother_name_en', $userProfile->mother_name_en) }}" />
                    </div>
                    <div>
                        <label for="spouse_name_en" class="block text-sm font-medium text-gray-700">Spouse's Name (English)</label>
                        <input id="spouse_name_en" name="spouse_name_en" type="text" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm" value="{{ old('spouse_name_en', $userProfile->spouse_name_en) }}" />
                    </div>

                    <!-- Bengali Names -->
                    <div>
                        <label for="full_name_bn" class="block text-sm font-medium text-gray-700">Full Name (Bengali)</label>
                        <input id="full_name_bn" name="full_name_bn" type="text" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm" value="{{ old('full_name_bn', $userProfile->full_name_bn) }}" />
                    </div>
                    <div>
                        <label for="father_name_bn" class="block text-sm font-medium text-gray-700">Father's Name (Bengali)</label>
                        <input id="father_name_bn" name="father_name_bn" type="text" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm" value="{{ old('father_name_bn', $userProfile->father_name_bn) }}" />
                    </div>
                    <div>
                        <label for="mother_name_bn" class="block text-sm font-medium text-gray-700">Mother's Name (Bengali)</label>
                        <input id="mother_name_bn" name="mother_name_bn" type="text" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm" value="{{ old('mother_name_bn', $userProfile->mother_name_bn) }}" />
                    </div>
                     <div>
                        <label for="spouse_name_bn" class="block text-sm font-medium text-gray-700">Spouse's Name (Bengali)</label>
                        <input id="spouse_name_bn" name="spouse_name_bn" type="text" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm" value="{{ old('spouse_name_bn', $userProfile->spouse_name_bn) }}" />
                    </div>

                    {{-- Separator --}}
                    <div class="md:col-span-2 border-t my-2"></div>

                    <!-- Other Details -->
                    <div>
                        <label for="dob" class="block text-sm font-medium text-gray-700">Date of Birth</label>
                        <input id="dob" name="dob" type="date" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm" value="{{ old('dob', $userProfile->dob ? $userProfile->dob->format('Y-m-d') : '') }}" />
                    </div>
                    <div>
                        <label for="place_of_birth" class="block text-sm font-medium text-gray-700">Place of Birth</label>
                        <input id="place_of_birth" name="place_of_birth" type="text" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm" value="{{ old('place_of_birth', $userProfile->place_of_birth) }}" />
                    </div>
                     <div>
                        <label for="nationality" class="block text-sm font-medium text-gray-700">Nationality</label>
                        <input id="nationality" name="nationality" type="text" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm" value="{{ old('nationality', $userProfile->nationality) }}" />
                    </div>
                    <div>
                        <label for="phone_mobile" class="block text-sm font-medium text-gray-700">Mobile Number</label>
                        <input id="phone_mobile" name="phone_mobile" type="tel" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm" value="{{ old('phone_mobile', $userProfile->phone_mobile) }}" />
                    </div>
                    <div>
                        <label for="marital_status" class="block text-sm font-medium text-gray-700">Marital Status</label>
                        <input id="marital_status" name="marital_status" type="text" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm" value="{{ old('marital_status', $userProfile->marital_status) }}" />
                    </div>
                    <div>
                        <label for="religion" class="block text-sm font-medium text-gray-700">Religion</label>
                        <input id="religion" name="religion" type="text" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm" value="{{ old('religion', $userProfile->religion) }}" />
                    </div>

                    <!-- English Addresses -->
                    <div class="md:col-span-2">
                        <label for="present_address_en" class="block text-sm font-medium text-gray-700">Present Address (English)</label>
                        <textarea id="present_address_en" name="present_address_en" rows="3" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm">{{ old('present_address_en', $userProfile->present_address_en) }}</textarea>
                    </div>
                     <div class="md:col-span-2">
                        <label for="permanent_address_en" class="block text-sm font-medium text-gray-700">Permanent Address (English)</label>
                        <textarea id="permanent_address_en" name="permanent_address_en" rows="3" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm">{{ old('permanent_address_en', $userProfile->permanent_address_en) }}</textarea>
                    </div>

                    <!-- Bengali Addresses -->
                    <div class="md:col-span-2">
                        <label for="present_address_bn" class="block text-sm font-medium text-gray-700">Present Address (Bengali)</label>
                        <textarea id="present_address_bn" name="present_address_bn" rows="3" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm">{{ old('present_address_bn', $userProfile->present_address_bn) }}</textarea>
                    </div>
                     <div class="md:col-span-2">
                        <label for="permanent_address_bn" class="block text-sm font-medium text-gray-700">Permanent Address (Bengali)</label>
                        <textarea id="permanent_address_bn" name="permanent_address_bn" rows="3" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm">{{ old('permanent_address_bn', $userProfile->permanent_address_bn) }}</textarea>
                    </div>

                    <!-- Additional Information -->
                    <div class="md:col-span-2">
                        <label for="additional_information" class="block text-sm font-medium text-gray-700">Additional Information (Optional)</label>
                        <textarea id="additional_information" name="additional_information" rows="3" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm">{{ old('additional_information', $userProfile->additional_information) }}</textarea>
                    </div>
                    <div class="md:col-span-2">
                        <label for="quota_information" class="block text-sm font-medium text-gray-700">Quota Information (if any)</label>
                        <textarea id="quota_information" name="quota_information" rows="3" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm">{{ old('quota_information', $userProfile->quota_information) }}</textarea>
                    </div>
                </div>
            </div>

            <div class="mt-6 flex items-center justify-end">
                <button type="submit" class="bg-primary-600 hover:bg-primary-700 text-white py-2 px-6 rounded-lg font-medium">Save All Changes</button>
            </div>
        </div>
    </form>

    {{-- <div class="mt-8 space-y-6">

        <div class="bg-white p-6 rounded-xl shadow-soft">
             @include('profile.partials.update-password-form')
        </div>


        <div class="bg-white p-6 rounded-xl shadow-soft">
            @include('profile.partials.delete-user-form')
        </div>
    </div> --}}
</x-profile-layout>
