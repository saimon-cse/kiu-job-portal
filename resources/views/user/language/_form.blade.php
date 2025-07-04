<div class="space-y-6">
    <!-- Language Name -->
    <div>
        <label for="language" class="block text-sm font-medium text-gray-700">Language</label>
        <div class="mt-1">
            <input type="text" name="language" id="language" value="{{ old('language', isset($language) ? $language->language : '') }}" required
                   placeholder="e.g., English, Bengali, French"
                   class="block w-full md:w-2/3 px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
        </div>
    </div>

    <!-- Proficiency Level (as a text input) -->
    <div>
        <label for="efficiency" class="block text-sm font-medium text-gray-700">Proficiency Level</label>
        <div class="mt-1">
            <input type="text" name="efficiency" id="efficiency" value="{{ old('efficiency', isset($language) ? $language->efficiency : '') }}" required
                   placeholder="e.g., IELTS Band 8 , Excellent, Native, Fluent in Speaking"
                   class="block w-full md:w-2/3 px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
        </div>
        <p class="mt-2 text-xs text-gray-500">Describe your proficiency level (e.g., Good, Excellent, Native, Fluent in Speaking, etc.).</p>
    </div>
</div>
