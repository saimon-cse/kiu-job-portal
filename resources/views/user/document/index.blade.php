<x-profile-layout>
    @include('partials._session-messages')
    @include('partials._validation-errors')

    <!-- Upload Form -->
    <div class="bg-white p-6 rounded-xl shadow-soft mb-8">
        <h2 class="text-xl font-bold text-gray-800">Upload New Document</h2>
        <p class="mt-1 text-sm text-gray-600">Upload your CV, certificates, or other relevant files.</p>
        <form action="{{ route('document.store') }}" method="POST" enctype="multipart/form-data" class="mt-6 space-y-6">
            @csrf
            <div>
                <label for="document_type" class="block text-sm font-medium text-gray-700">Document Name / Type</label>
                <input type="text" name="document_type" id="document_type" required placeholder="e.g., My Resume, NID Card"
                       class="mt-1 block w-full md:w-2/3 px-3 py-2 border border-gray-300 rounded-lg shadow-sm">
            </div>
            <div>
                <label for="document_file" class="block text-sm font-medium text-gray-700">Select File</label>
                <input type="file" name="document_file" id="document_file" required
                       class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100">
            </div>
            <div class="flex justify-end">
                 <button type="submit" class="bg-primary-600 hover:bg-primary-700 text-white py-2 px-6 rounded-lg font-medium">Upload</button>
            </div>
        </form>
    </div>

    <!-- Document List -->
    <div class="bg-white p-6 rounded-xl shadow-soft">
        <h2 class="text-xl font-bold text-gray-800">My Uploaded Documents</h2>
        <div class="mt-4 space-y-3">
             @forelse ($documents as $document)
                <div class="p-3 border rounded-lg flex justify-between items-center">
                    <div class="flex items-center">
                        <i class="fas fa-file-pdf text-red-500 text-xl mr-4"></i>
                        <div>
                            <a href="{{ Storage::url($document->file_path) }}" target="_blank" class="font-medium text-gray-800 hover:text-primary-600">{{ $document->document_type }}</a>
                            <p class="text-xs text-gray-500">{{ $document->mime_type }}</p>
                        </div>
                    </div>
                     <div class="relative group">
                         <form action="{{ route('document.destroy', $document) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="flex items-center justify-center w-8 h-8 rounded-full bg-gray-100 hover:bg-red-100 text-red-600">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                            <span class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 px-2 py-1 text-xs text-white bg-gray-800 rounded-md opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-opacity pointer-events-none">Delete</span>
                        </form>
                    </div>
                </div>
            @empty
                <div class="text-center py-8 text-gray-500">No documents have been uploaded.</div>
            @endforelse
        </div>
    </div>
</x-profile-layout>
