<x-profile-layout>
    <div class="bg-white p-6 rounded-xl shadow-soft">
        <h2 class="text-xl font-bold text-gray-800 mb-6 border-b pb-4">Add New Publication</h2>

        @include('partials._validation-errors')

        <form action="{{ route('publication.store') }}" method="POST">
            @csrf

            {{-- Include the reusable form partial, passing the available types --}}
            @include('user.publication._form', ['publicationTypes' => $publicationTypes])

            <div class="pt-8 flex justify-end space-x-3">
                <a href="{{ route('publication.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 py-2 px-6 rounded-lg font-medium">Cancel</a>
                <button type="submit" class="bg-primary-600 hover:bg-primary-700 text-white py-2 px-6 rounded-lg font-medium">Save Publication</button>
            </div>
        </form>
    </div>
</x-profile-layout>
