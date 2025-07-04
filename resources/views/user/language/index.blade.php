<x-profile-layout>
    {{-- Page Header --}}
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h2 class="text-xl font-bold text-gray-800">My Language Proficiencies</h2>
            <p class="text-gray-500">Manage the languages you speak and your proficiency level.</p>
        </div>
        <a href="{{ route('language.create') }}" class="bg-primary-600 hover:bg-primary-700 text-white py-2 px-4 rounded-lg font-medium text-sm">
            <i class="fas fa-plus mr-2"></i> Add Language
        </a>
    </div>

    @include('partials._session-messages')

    {{-- Main Content Card --}}
    <div class="bg-white p-6 rounded-xl shadow-soft">
        <div class="space-y-4">
            @forelse ($languages as $language)
                <div class="p-4 border rounded-lg flex justify-between items-center hover:bg-gray-50 transition-colors">
                    {{-- Language Details --}}
                    <div class="flex items-center">
                        <div class="flex-shrink-0 h-10 w-10 rounded-full bg-primary-100 flex items-center justify-center text-primary-600">
                            <i class="fas fa-language"></i>
                        </div>
                        <div class="ml-4">
                            <h3 class="font-bold text-lg text-gray-800">{{ $language->language }}</h3>
                            <p class="text-gray-600 capitalize">Proficiency: {{ $language->efficiency }}</p>
                        </div>
                    </div>
                    {{-- Action Buttons --}}
                    <div class="flex items-center space-x-2 shrink-0 ml-4">
                        <div class="relative group">
                            <a href="{{ route('language.edit', $language) }}" class="flex items-center justify-center w-8 h-8 rounded-full bg-gray-100 hover:bg-primary-100 text-primary-600 hover:text-primary-800">
                                <i class="fas fa-pencil-alt"></i>
                            </a>
                            <span class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 px-2 py-1 text-xs text-white bg-gray-800 rounded-md opacity-0 invisible group-hover:opacity-100 group-hover:visible pointer-events-none">Edit</span>
                        </div>
                        <div class="relative group">
                            <form action="{{ route('language.destroy', $language) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this language?');">
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
                    <i class="fas fa-language text-4xl text-gray-300"></i>
                    <p class="mt-4 text-gray-500">You haven't added any language proficiencies yet.</p>
                    <a href="{{ route('language.create') }}" class="mt-4 inline-block text-primary-600 hover:underline">Click here to add one.</a>
                </div>
            @endforelse
        </div>
    </div>
</x-profile-layout>
