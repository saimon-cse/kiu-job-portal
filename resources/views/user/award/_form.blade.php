<div class="space-y-6">
    <!-- Award Name -->
    <div>
        <label for="award_name" class="block text-sm font-medium text-gray-700">Award Name</label>
        <div class="mt-1">
            <input type="text" name="award_name" id="award_name" value="{{ old('award_name', isset($award) ? $award->award_name : '') }}" required
                   placeholder="e.g., Dean's List, Employee of the Month"
                   class="block w-full md:w-2/3 px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
        </div>
    </div>

    <!-- Awarding Body -->
    <div>
        <label for="awarding_body" class="block text-sm font-medium text-gray-700">Awarding Body</label>
        <div class="mt-1">
            <input type="text" name="awarding_body" id="awarding_body" value="{{ old('awarding_body', isset($award) ? $award->awarding_body : '') }}" required
                   placeholder="e.g., University of Example, Acme Corporation"
                   class="block w-full md:w-2/3 px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Year Received -->
        <div>
            <label for="year_received" class="block text-sm font-medium text-gray-700">Year Received</label>
            <div class="mt-1">
                <input type="number" name="year_received" id="year_received" value="{{ old('year_received', isset($award) ? $award->year_received : '') }}" required
                       placeholder="e.g., 2022"
                       class="block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
            </div>
        </div>
        <!-- Country -->
        <div>
            <label for="country" class="block text-sm font-medium text-gray-700">Country (Optional)</label>
            <div class="mt-1">
                <input type="text" name="country" id="country" value="{{ old('country', isset($award) ? $award->country : '') }}"
                       placeholder="e.g., Bangladesh, USA"
                       class="block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
            </div>
        </div>
    </div>

    <!-- Description -->
    <div>
        <label for="description" class="block text-sm font-medium text-gray-700">Description (Optional)</label>
        <div class="mt-1">
            <textarea name="description" id="description" rows="3"
                      placeholder="Provide a brief description of the achievement."
                      class="block w-full md:w-2/3 px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500">{{ old('description', isset($award) ? $award->description : '') }}</textarea>
        </div>
    </div>
</div>
