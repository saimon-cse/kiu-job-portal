<x-app-layout>
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Edit Publication Type</h1>

    @include('partials._validation-errors')

    <div class="bg-white p-6 rounded-xl shadow-soft">
        <form action="{{ route('admin.publication-types.update', $publicationType) }}" method="POST">
            @csrf
            @method('PUT')

            @include('admin.publication-types._form', ['publicationType' => $publicationType])

            <div class="pt-8 flex justify-end space-x-3">
                <a href="{{ route('admin.publication-types.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 py-2 px-6 rounded-lg font-medium">Cancel</a>
                <button type="submit" class="bg-primary-600 hover:bg-primary-700 text-white py-2 px-6 rounded-lg font-medium">Update Type</button>
            </div>
        </form>
    </div>
</x-app-layout>
