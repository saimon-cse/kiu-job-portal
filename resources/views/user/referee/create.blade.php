<x-profile-layout>
    <div class="bg-white p-6 rounded-xl shadow-soft">
        <h2 class="text-xl font-bold text-gray-800 mb-6 border-b pb-4">Add New Referee</h2>

        @include('partials._validation-errors')

        <form action="{{ route('referee.store') }}" method="POST">
            @csrf

            {{-- Include the reusable form partial --}}
            @include('user.referee._form')

            <div class="pt-8 flex justify-end space-x-3">
                <a href="{{ route('referee.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 py-2 px-6 rounded-lg font-medium">Cancel</a>
                <button type="submit" class="bg-primary-600 hover:bg-primary-700 text-white py-2 px-6 rounded-lg font-medium">Save Referee</button>
            </div>
        </form>
    </div>
</x-profile-layout>
