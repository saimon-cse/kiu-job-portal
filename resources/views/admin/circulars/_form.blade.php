{{--
    This Alpine.js component manages the dynamic job post rows.
    It's initialized with existing jobs for the edit form, or a default empty row for the create form.
--}}
<div x-data='jobPostsManager({ jobs: {{ json_encode(old('jobs', isset($circular) ? $circular->jobs->toArray() : [['post_name' => '', 'department_office' => '', 'application_fee' => '0']])) }} })'>
    <div class="space-y-8">

        {{-- Section 1: Circular Details --}}
        <div class="bg-white p-6 rounded-xl shadow-soft">
            <h3 class="text-lg font-semibold text-gray-900 border-b pb-4 mb-6">
                <i class="fas fa-file-alt text-primary-500 mr-2"></i>
                Circular Details
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Circular No -->
                <div>
                    <label for="circular_no" class="block text-sm font-medium text-gray-700">Circular No.</label>
                    <input type="text" name="circular_no" id="circular_no" value="{{ old('circular_no', isset($circular) ? $circular->circular_no : '') }}" required
                           class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
                </div>
                <!-- Status -->
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                    <select name="status" id="status" class="mt-1 block w-full px-3 py-2 border border-gray-300 bg-white rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
                        @php
                            $selectedStatus = old('status', isset($circular) ? $circular->status : 'open');
                        @endphp
                        <option value="open" @if($selectedStatus == 'open') selected @endif>Open</option>
                        <option value="closed" @if($selectedStatus == 'closed') selected @endif>Closed</option>
                        <option value="archived" @if($selectedStatus == 'archived') selected @endif>Archived</option>
                    </select>
                </div>
                <!-- Post Date -->
                <div>
                    <label for="post_date" class="block text-sm font-medium text-gray-700">Post Date</label>
                    <input type="date" name="post_date" id="post_date" value="{{ old('post_date', (isset($circular) && $circular->post_date) ? $circular->post_date->format('Y-m-d') : '') }}" required
                           class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
                </div>
                <!-- Last Date of Submission -->
                <div>
                    <label for="last_date_of_submission" class="block text-sm font-medium text-gray-700">Last Date of Submission</label>
                    <input type="date" name="last_date_of_submission" id="last_date_of_submission" value="{{ old('last_date_of_submission', (isset($circular) && $circular->last_date_of_submission) ? $circular->last_date_of_submission->format('Y-m-d') : '') }}" required
                           class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
                </div>
                <!-- Document Upload -->
                <div class="md:col-span-2">
                    <label for="document_path" class="block text-sm font-medium text-gray-700">Upload Document (PDF)</label>
                    <input type="file" name="document_path" id="document_path" accept=".pdf,.doc,.docx"
                           class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:font-semibold file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100 cursor-pointer">
                    @if(isset($circular) && $circular->document_path)
                        <p class="text-sm mt-2 text-gray-600">Current Document:
                            <a href="{{ Storage::url($circular->document_path) }}" target="_blank" class="text-primary-600 hover:underline font-medium">View Document</a>
                        </p>
                    @endif
                </div>
                <!-- Description -->
                <div class="md:col-span-2">
                    <label for="description" class="block text-sm font-medium text-gray-700">Description (Optional)</label>
                    <textarea name="description" id="description" rows="5"
                              class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500">{{ old('description', isset($circular) ? $circular->description : '') }}</textarea>
                </div>
            </div>
        </div>

        {{-- Section 2: Job Posts --}}
        <div class="bg-white p-6 rounded-xl shadow-soft">
            <div class="flex justify-between items-center border-b pb-4 mb-6">
                <h3 class="text-lg font-semibold text-gray-900">
                    <i class="fas fa-briefcase text-primary-500 mr-2"></i>
                    Job Posts for this Circular
                </h3>
                <button @click="addJob" type="button" class="bg-primary-600 hover:bg-primary-700 text-white py-2 px-4 rounded-lg font-medium text-sm">
                    <i class="fas fa-plus mr-2"></i> Add Another Post
                </button>
            </div>

            <p class="text-sm text-gray-500 mb-6">Add one or more job posts that belong to this circular number.</p>

            <div class="space-y-6">
                {{-- Alpine.js will loop through the 'jobs' array and create this block for each one --}}
                <template x-for="(job, index) in jobs" :key="index">
                    <div class="border-2 border-dashed rounded-lg p-4 bg-gray-50/50 relative">
                        <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                            <!-- Post Name -->
                            <div class="md:col-span-2">
                                <label :for="`post_name_${index}`" class="text-sm font-medium text-gray-700">Post Name</label>
                                <input type="text" :name="`jobs[${index}][post_name]`" :id="`post_name_${index}`" x-model="job.post_name" required
                                       class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm">
                            </div>
                            <!-- Department -->
                            <div class="md:col-span-2">
                                <label :for="`department_${index}`" class="text-sm font-medium text-gray-700">Department/Office</label>
                                <input type="text" :name="`jobs[${index}][department_office]`" :id="`department_${index}`" x-model="job.department_office"
                                       class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm">
                            </div>
                            <!-- Fee -->
                            <div>
                                <label :for="`fee_${index}`" class="text-sm font-medium text-gray-700">Application Fee</label>
                                <input type="number" step="0.01" min="0" :name="`jobs[${index}][application_fee]`" :id="`fee_${index}`" x-model="job.application_fee" required
                                       class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm">
                            </div>
                        </div>

                        {{-- Hidden input for existing job IDs during update --}}
                        <input type="hidden" :name="`jobs[${index}][id]`" x-model="job.id">

                        {{-- Remove Button for the row --}}
                        <div class="absolute -top-3 -right-3">
                            <button @click="removeJob(index)" type="button" x-show="jobs.length > 1"
                                    class="text-red-500 bg-white hover:bg-red-500 hover:text-white w-7 h-7 rounded-full border-2 border-red-500 flex items-center justify-center transition-colors">
                                <i class="fas fa-times text-sm"></i>
                            </button>
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </div>
</div>

{{-- The Alpine.js logic for the dynamic form (no changes needed here) --}}
<script>
    function jobPostsManager(data) {
        return {
            jobs: data.jobs,
            addJob() {
                this.jobs.push({
                    id: null,
                    post_name: '',
                    department_office: '',
                    application_fee: '0' // Default value for new rows
                });
            },
            removeJob(index) {
                // To be safe, add a confirmation before removing
                if (confirm('Are you sure you want to remove this post?')) {
                    this.jobs.splice(index, 1);
                }
            }
        }
    }
</script>
