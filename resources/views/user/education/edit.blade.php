<x-profile-layout>
    <div class="bg-white p-6 rounded-xl shadow-soft">
        <h1 class="text-xl font-bold text-gray-800 mb-6 border-b pb-4">Edit Education Record</h1>

        @include('partials._validation-errors')

        <form action="{{ route('education.update', $education) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- Pass the existing $education model to the form partial so it can pre-fill the values --}}
            @include('user.education._form', ['education' => $education])

            <div class="pt-8 flex justify-end space-x-3">
                <a href="{{ route('education.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 py-2 px-6 rounded-lg font-medium">Cancel</a>
                <button type="submit" class="bg-primary-600 hover:bg-primary-700 text-white py-2 px-6 rounded-lg font-medium">Update Record</button>
            </div>
        </form>
    </div>
</x-profile-layout>
