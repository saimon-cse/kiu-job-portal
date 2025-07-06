<div class="space-y-6">
    <div>
        <label for="name" class="block text-sm font-medium text-gray-700">Type Name</label>
        <div class="mt-1">
            <input type="text" name="name" id="name" value="{{ old('name', isset($publicationType) ? $publicationType->name : '') }}" required
                   placeholder="e.g., Journal Article, Book, Conference Paper"
                   class="block w-full md:w-1/2 px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
            <p class="mt-2 text-xs text-gray-500">The "slug" (URL-friendly version) will be generated automatically from this name.</p>
        </div>
    </div>
</div>
