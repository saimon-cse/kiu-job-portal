<div class="space-y-6">

    <!-- Publication Type -->
    <div>
        <label for="publication_type_id" class="block text-sm font-medium text-gray-700">Type of Publication</label>
        <div class="mt-1">
            <select name="publication_type_id" id="publication_type_id" required
                class="block w-full md:w-2/3 px-3 py-2 border border-gray-300 bg-white rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
                <option value="" disabled selected>-- Select a type --</option>
                @foreach ($publicationTypes as $id => $name)
                    <option value="{{ $id }}" @if (old('publication_type_id', isset($publication) ? $publication->publication_type_id : '') == $id) selected @endif>
                        {{ $name }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>


    <!-- Publication Title -->
    <div>
        <label for="title" class="block text-sm font-medium text-gray-700">Publication Title</label>
        <div class="mt-1">
            <textarea name="title" id="title" rows="3" required
                {{-- placeholder="e.g., A Comprehensive Study of Laravels Service Container" --}}
                class="block w-full md:w-2/3 px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500">{{ old('title', isset($publication) ? $publication->title : '') }}</textarea>
        </div>
    </div>

     <div>
        <label for="doi" class="block text-sm font-medium text-gray-700">Doi number / Link</label>
        <div class="mt-1">
            <input type="text" name="doi" id="doi" value="{{ old('doi', isset($experience) ? $experience->doi : '') }}" required

                   class="block w-full md:w-2/3 px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
        </div>
    </div>




</div>
