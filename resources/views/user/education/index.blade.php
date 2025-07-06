<x-profile-layout>
    {{-- Page Header --}}
    <div class="mb-6 flex flex-col md:flex-row justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">My Education</h1>
            <p class="text-gray-500">Manage your academic qualifications.</p>
        </div>
        <a href="{{ route('education.create') }}" class="w-full md:w-auto mt-4 md:mt-0 bg-primary-600 hover:bg-primary-700 text-white py-2 px-4 rounded-lg font-medium text-center text-sm">
            <i class="fas fa-plus mr-2"></i> Add Education
        </a>
    </div>

    @include('partials._session-messages')

    {{-- Main Content Card --}}
    <div class="bg-white p-6 rounded-xl shadow-soft">
        <div class="space-y-4">
            @forelse ($educations as $education)
                <div class="p-4 border rounded-lg flex justify-between items-start hover:bg-gray-50 transition-colors">
                    {{-- Education Details --}}
                    <div>
                        <h3 class="font-bold text-lg text-gray-800">{{ $education->exam_name }}</h3>
                        <p class="text-gray-600">{{ $education->institution_name }}</p>
                        <p class="text-sm text-gray-500 mt-1">
                            Passing Year: {{ $education->passing_year }}
                            @if($education->gpa_or_cgpa)
                                | GPA/CGPA: {{ $education->gpa_or_cgpa }}
                            @endif
                        </p>
                         @if($education->course_studied)
                            <p class="text-sm text-gray-500">Major: {{ $education->course_studied }}</p>
                        @endif
                    </div>
                    {{-- Action Buttons --}}
                    <div class="flex items-center space-x-2 shrink-0 ml-4">
                        <div class="relative group">
                            <a href="{{ route('education.edit', $education) }}" class="flex items-center justify-center w-8 h-8 rounded-full bg-gray-100 hover:bg-primary-100 text-primary-600 hover:text-primary-800">
                                <i class="fas fa-pencil-alt"></i>
                            </a>
                            <span class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 px-2 py-1 text-xs text-white bg-gray-800 rounded-md opacity-0 invisible group-hover:opacity-100 group-hover:visible pointer-events-none">Edit</span>
                        </div>
                        <div class="relative group">
                            <form action="{{ route('education.destroy', $education) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this record?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="flex items-center justify-center w-8 h-8 rounded-full bg-gray-100 hover:bg-red-100 text-red-600 hover:text-red-800">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                                <span class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 px-2 py-1 text-xs text-white bg-gray-800 rounded-md opacity-0 invisible group-hover:opacity-100 group-hover:visible pointer-events-none">Delete</span>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-8">
                    <i class="fas fa-graduation-cap text-4xl text-gray-300"></i>
                    <p class="mt-4 text-gray-500">You haven't added any education records yet.</p>
                    {{-- <a href="{{ route('education.create') }}" class="mt-4 inline-block text-primary-600 hover:underline">Click here to add one.</a> --}}
                </div>
            @endforelse
        </div>
    </div>
</x-profile-layout>
