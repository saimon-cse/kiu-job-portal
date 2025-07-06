<div class="space-y-6">

        <!-- Designation / Post -->
    <div>
        <label for="post_and_scale" class="block text-sm font-medium text-gray-700">Designation / Post</label>
        <div class="mt-1">
            <input type="text" name="post_and_scale" id="post_and_scale" value="{{ old('post_and_scale', isset($experience) ? $experience->post_and_scale : '') }}" required
                   placeholder="e.g., Software Engineer"
                   class="block w-full md:w-2/3 px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
        </div>
    </div>


    <!-- Company / Institute Name -->
    <div>
        <label for="institute_name" class="block text-sm font-medium text-gray-700">Company / Institute Name</label>
        <div class="mt-1">
            <input type="text" name="institute_name" id="institute_name" value="{{ old('institute_name', isset($experience) ? $experience->institute_name : '') }}" required
                   placeholder="e.g., ABC Corporation"
                   class="block w-full md:w-2/3 px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
        </div>
    </div>

        <!-- Institute Type -->
    <div>
        <label for="institute_type" class="block text-sm font-medium text-gray-700">Company / Institute Type (Optional)</label>
        <div class="mt-1">
            <input type="text" name="institute_type" id="institute_type" value="{{ old('institute_type', isset($experience) ? $experience->institute_type : '') }}"
                   placeholder="e.g., Private, Government, NGO, Public University"
                   class="block w-full md:w-2/3 px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Start Date -->
        <div>
            <label for="from_date" class="block text-sm font-medium text-gray-700">Start Date</label>
            <div class="mt-1">
                {{-- Safely format the date for the input field --}}
                <input type="date" name="from_date" id="from_date" value="{{ old('from_date', isset($experience) && $experience->from_date ? $experience->from_date->format('Y-m-d') : '') }}" required
                       class="block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
            </div>
        </div>
        <!-- End Date -->
        <div>
            <label for="to_date" class="block text-sm font-medium text-gray-700">End Date (Leave blank if current)</label>
            <div class="mt-1">
                <input type="date" name="to_date" id="to_date" value="{{ old('to_date', isset($experience) && $experience->to_date ? $experience->to_date->format('Y-m-d') : '') }}"
                       class="block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
            </div>
        </div>
    </div>



    <!-- Responsibilities / Courses Taught -->
    <div>
        <label for="courses_taught" class="block text-sm font-medium text-gray-700">Key Responsibilities / (Optional)</label>
        <div class="mt-1">
            <textarea name="courses_taught" id="courses_taught" rows="4"
                      {{-- placeholder="e.g., - Developed and maintained REST APIs. - Led a team of junior developers. or - Courses Taught: Data Structures, Algorithms" --}}
                      class="block w-full md:w-2/3 px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500">{{ old('courses_taught', isset($experience) ? $experience->courses_taught : '') }}</textarea>
        </div>
    </div>
</div>
