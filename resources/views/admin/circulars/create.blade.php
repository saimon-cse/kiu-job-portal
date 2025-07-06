<x-app-layout>
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Create New Circular</h1>
    @include('partials._validation-errors')

    <form action="{{ route('admin.circulars.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @include('admin.circulars._form')

        <div class="mt-8 flex justify-end space-x-3">
            <a href="{{ route('admin.circulars.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 py-2 px-6 rounded-lg font-medium">Cancel</a>
            <button type="submit" class="bg-primary-600 hover:bg-primary-700 text-white py-2 px-6 rounded-lg font-medium">Create Circular</button>
        </div>
    </form>
</x-app-layout>
