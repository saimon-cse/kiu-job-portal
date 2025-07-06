{{-- This form needs multipart/form-data to handle file uploads --}}
<div class="space-y-6">
    <!-- Training Name -->
    <div>
        <label for="training_name" class="block text-sm font-medium text-gray-700">Training Name</label>
        <div class="mt-1">
            <input type="text" name="training_name" id="training_name" value="{{ old('training_name', isset($training) ? $training->training_name : '') }}" required
                   {{-- placeholder="e.g., Advanced Laravel Development" --}}
                   class="block w-full md:w-2/3 px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
        </div>
    </div>

    <!-- Institute Name -->
    <div>
        <label for="institute_name" class="block text-sm font-medium text-gray-700">Institute Name</label>
        <div class="mt-1">
            <input type="text" name="institute_name" id="institute_name" value="{{ old('institute_name', isset($training) ? $training->institute_name : '') }}" required
                   {{-- placeholder="e.g., Laracasts" --}}
                   class="block w-full md:w-2/3 px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Period From -->
        <div>
            <label for="period_from" class="block text-sm font-medium text-gray-700">Start Period (Optional)</label>
            <div class="mt-1">
                <input type="text" name="period_from" id="period_from" value="{{ old('period_from', isset($training) ? $training->period_from : '') }}"
                       placeholder="e.g., Jan 2023"
                       class="block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
            </div>
        </div>
        <!-- Period To -->
        <div>
            <label for="period_to" class="block text-sm font-medium text-gray-700">End Period (Optional)</label>
            <div class="mt-1">
                <input type="text" name="period_to" id="period_to" value="{{ old('period_to', isset($training) ? $training->period_to : '') }}"
                       placeholder="e.g., Mar 2023"
                       class="block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
            </div>
        </div>
    </div>

    <!-- Certificate Upload -->
    <div>
        <label for="document_path" class="block text-sm font-medium text-gray-700">Upload Documents (Optional)</label>
        <div class="mt-1">
            <input type="file" name="document_path" id="document_path"
                   class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100">
            <p class="text-xs text-gray-500 mt-1">Allowed types: PDF, JPG, PNG. Max size: 2MB.</p>

            @if (isset($training) && $training->document_path)
                <div class="mt-2">
                    <p class="text-sm text-gray-600">Current file:
                        <a href="{{ Storage::url($training->document_path) }}" target="_blank" class="text-primary-600 hover:underline">View Certificate</a>
                    </p>
                    <p class="text-xs text-gray-500">Uploading a new file will replace the current one.</p>
                </div>
            @endif
        </div>
    </div>
</div>
