<div class="space-y-6">
    <!-- Exam Name -->
    <div>
        <label for="exam_name" class="block text-sm font-medium text-gray-700">Degree / Exam Name</label>
        <div class="mt-1">
            <input type="text" name="exam_name" id="exam_name"
                value="{{ old('exam_name', isset($education) ? $education->exam_name : '') }}" required
                {{-- placeholder="e.g., Bachelor of Science (B.Sc)" --}}
                class="block w-full md:w-2/3 px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
        </div>
    </div>

     <!-- Course / Major -->
        <div>
            <label for="course_studied" class="block text-sm font-medium text-gray-700">Suject / Group</label>
            <div class="mt-1">
                <input type="text" name="course_studied" id="course_studied"
                    value="{{ old('course_studied', isset($education) ? $education->course_studied : '') }}"
                    {{-- placeholder="e.g., Computer Science and Engineering" --}}
                    class="block w-full md:w-2/3 px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
            </div>
        </div>

    <!-- Institution Name -->
    <div>
        <label for="institution_name" class="block text-sm font-medium text-gray-700">Institution Name</label>
        <div class="mt-1">
            <input type="text" name="institution_name" id="institution_name"
                value="{{ old('institution_name', isset($education) ? $education->institution_name : '') }}" required
                {{-- placeholder="e.g., University of Example" --}}
                class="block w-full md:w-2/3 px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
        </div>
    </div>



    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Passing Year -->
        <div>
            <label for="passing_year" class="block text-sm font-medium text-gray-700">Passing Year</label>
            <div class="mt-1">
                <input type="number" name="passing_year" id="passing_year"
                    value="{{ old('passing_year', isset($education) ? $education->passing_year : '') }}" required
                    {{-- placeholder="e.g., 2020" --}}
                    class="block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
            </div>
        </div>
        <!-- GPA / CGPA -->
        <div>
            <label for="gpa_or_cgpa" class="block text-sm font-medium text-gray-700">GPA / CGPA (Optional)</label>
            <div class="mt-1">
                <input type="text" name="gpa_or_cgpa" id="gpa_or_cgpa"
                    value="{{ old('gpa_or_cgpa', isset($education) ? $education->gpa_or_cgpa : '') }}"
                    {{-- placeholder="e.g., 3.85 out of 4.00" --}}
                    class="block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
            </div>
        </div>
    </div>

    <!--  Documents upload-->

    <div>
        <label for="document_path" class="block text-sm font-medium text-gray-700">Upload Documents</label>
        <div class="mt-1">
            <input type="file" name="document_path" id="document_path"
                class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100">
            <p class="text-xs text-gray-500 mt-1">Allowed types: PDF, JPG, PNG. Max size: 2MB.</p>

            @if (isset($education) && $education->document_path)
                <div class="mt-2">
                    <p class="text-sm text-gray-600">Current file:
                        <a href="{{ Storage::url($education->document_path) }}" target="_blank"
                            class="text-primary-600 hover:underline">View Docuemnts</a>
                    </p>
                    <p class="text-xs text-gray-500">Uploading a new file will replace the current one.</p>
                </div>
            @endif
        </div>




    </div>
