<x-profile-layout>
    <div class="bg-white p-6 rounded-xl shadow-soft">
        <h2 class="text-xl font-bold text-gray-800 mb-6 border-b pb-4">Edit Work Experience</h2>

        @include('partials._validation-errors')

        <form action="{{ route('experience.update', $experience) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- Pass the existing $experience model to the form partial so it can pre-fill the values --}}
            @include('user.experience._form', ['experience' => $experience])

            <div class="pt-8 flex justify-end space-x-3">
                <a href="{{ route('experience.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 py-2 px-6 rounded-lg font-medium">Cancel</a>
                <button type="submit" class="bg-primary-600 hover:bg-primary-700 text-white py-2 px-6 rounded-lg font-medium">Update Experience</button>
            </div>
        </form>
    </div>
</x-profile-layout>
