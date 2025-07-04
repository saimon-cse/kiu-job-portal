<x-app-layout>
    {{-- Page Header --}}
    <div class="mb-6 flex flex-col md:flex-row justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">My Profile Preview</h1>
            <p class="text-gray-500">This is how your complete profile appears. Review it for accuracy.</p>
        </div>
        <a href="{{ route('profile.edit') }}"
            class="w-full md:w-auto mt-4 md:mt-0 bg-primary-600 hover:bg-primary-700 text-white py-2 px-4 rounded-lg font-medium text-center">
            <i class="fas fa-pencil-alt mr-2"></i> Edit My Profile
        </a>
    </div>

    <div class="space-y-8">
        {{-- Section 1: Personal Information --}}
        <div class="bg-white p-6 rounded-xl shadow-soft">
            <div class="flex items-center border-b border-gray-200 pb-4 mb-4">
                <div class="mr-4">
                    <img class="h-24 w-24 rounded-full object-cover ring-4 ring-primary-100"
                        src="{{ $user->profile_picture ? Storage::url($user->profile_picture) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&size=128' }}"
                        alt="{{ $user->name }}">
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">{{ $user->name }}</h2>
                    <p class="text-gray-600">{{ $user->email }}</p>
                    @if ($user->profile && $user->profile->phone_mobile)
                        <p class="text-sm text-gray-500 mt-1"><i
                                class="fas fa-phone-alt mr-2"></i>{{ $user->profile->phone_mobile }}</p>
                    @endif
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-4 text-sm">
                <div class="flex"><strong class="w-1/3 text-gray-500">Full Name</strong>
                    <span
                        class="w-2/3 text-gray-800">{{ $user->profile && $user->profile->full_name_en ? $user->profile->full_name_en : 'Not set' }}</span>
                </div>
                <div class="flex"><strong class="w-1/3 text-gray-500">Date of Birth</strong>
                    <span
                        class="w-2/3 text-gray-800">{{ $user->profile && $user->profile->dob ? $user->profile->dob->format('F d, Y') : 'Not set' }}</span>
                </div>
                <div class="flex"><strong class="w-1/3 text-gray-500">Father's Name</strong>
                    <span
                        class="w-2/3 text-gray-800">{{ $user->profile && $user->profile->father_name_en ? $user->profile->father_name_en : 'Not set' }}</span>
                </div>
                <div class="flex"><strong class="w-1/3 text-gray-500">Nationality</strong>
                    <span
                        class="w-2/3 text-gray-800">{{ $user->profile && $user->profile->nationality ? $user->profile->nationality : 'Not set' }}</span>
                </div>
                <div class="flex"><strong class="w-1/3 text-gray-500">Mother's Name</strong>
                    <span
                        class="w-2/3 text-gray-800">{{ $user->profile && $user->profile->mother_name_en ? $user->profile->mother_name_en : 'Not set' }}</span>
                </div>
                <div class="flex"><strong class="w-1/3 text-gray-500">Marital Status</strong>
                    <span
                        class="w-2/3 text-gray-800">{{ $user->profile && $user->profile->marital_status ? $user->profile->marital_status : 'Not set' }}</span>
                </div>
                <div class="flex col-span-full"><strong class="w-1/6 text-gray-500">Address</strong>
                    <span
                        class="w-5/6 text-gray-800">{{ $user->profile && $user->profile->present_address_en ? $user->profile->present_address_en : 'Not set' }}</span>
                </div>
            </div>

        </div>

        {{-- Section 2: Work Experience --}}
        <div class="bg-white p-6 rounded-xl shadow-soft">
            <h3 class="text-lg font-semibold text-gray-800 border-b pb-3 mb-4"><i
                    class="fas fa-briefcase mr-3 text-primary-500"></i>Work Experience</h3>
            <div class="space-y-4">
                @forelse ($user->experiences as $experience)
                    <div class="pl-4 border-l-2 border-primary-200">
                        <p class="font-bold text-gray-800">{{ $experience->post_and_scale }}</p>
                        <p class="text-gray-600">{{ $experience->institute_name }}</p>
                        <p class="text-sm text-gray-500">{{ $experience->from_date->format('M Y') }} -
                            {{ $experience->to_date ? $experience->to_date->format('M Y') : 'Present' }}</p>
                    </div>
                @empty
                    <p class="text-gray-500 pl-4">No work experience records found.</p>
                @endforelse
            </div>
        </div>

        {{-- Section 3: Education --}}
        <div class="bg-white p-6 rounded-xl shadow-soft">
            <h3 class="text-lg font-semibold text-gray-800 border-b pb-3 mb-4"><i
                    class="fas fa-graduation-cap mr-3 text-primary-500"></i>Education</h3>
            <div class="space-y-4">
                @forelse ($user->educations as $education)
                    <div class="pl-4">
                        <p class="font-bold text-gray-800">{{ $education->exam_name }}</p>
                        <p class="text-gray-600">{{ $education->institution_name }}</p>
                        <p class="text-sm text-gray-500">Passing Year: {{ $education->passing_year }} | Result:
                            {{ $education->gpa_or_cgpa ?: 'N/A' }}</p>
                    </div>
                @empty
                    <p class="text-gray-500 pl-4">No education records found.</p>
                @endforelse
            </div>
        </div>

        {{-- You can continue this pattern for all other sections --}}

        {{-- Section 4: Trainings --}}
        <div class="bg-white p-6 rounded-xl shadow-soft">
            <h3 class="text-lg font-semibold text-gray-800 border-b pb-3 mb-4"><i
                    class="fas fa-certificate mr-3 text-primary-500"></i>Trainings</h3>
            <div class="space-y-3">
                @forelse ($user->trainings as $training)
                    <p><strong class="font-medium text-gray-800">{{ $training->training_name }}</strong> from
                        {{ $training->institute_name }}</p>
                @empty
                    <p class="text-gray-500">No training records found.</p>
                @endforelse
            </div>
        </div>

        {{-- Section 5: Documents --}}
        <div class="bg-white p-6 rounded-xl shadow-soft">
            <h3 class="text-lg font-semibold text-gray-800 border-b pb-3 mb-4"><i
                    class="fas fa-file-alt mr-3 text-primary-500"></i>Uploaded Documents</h3>
            <ul class="list-disc list-inside space-y-2">
                @forelse ($user->documents as $document)
                    <li>
                        <a href="{{ Storage::url($document->file_path) }}" target="_blank"
                            class="text-primary-600 hover:underline">
                            {{ $document->document_type ?: 'Download File' }}
                        </a>
                        <span class="text-xs text-gray-400"> ({{ $document->mime_type }})</span>
                    </li>
                @empty
                    <li class="list-none text-gray-500">No documents have been uploaded.</li>
                @endforelse
            </ul>
        </div>

    </div>
</x-app-layout>
