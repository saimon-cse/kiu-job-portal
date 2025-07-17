<x-app-layout>
    {{-- ======================== --}}
    {{--      PAGE HEADER         --}}
    {{-- ======================== --}}
    <div class="mb-6">
        <div class="mb-2">
            <a href="{{ route('admin.jobs.applications.index', $application->job) }}" class="inline-flex items-center text-gray-500 hover:text-gray-700 font-medium group">
                <i class="fas fa-arrow-left mr-2 transition-transform group-hover:-translate-x-1"></i>
                Back to Applicants List for this Post
            </a>
        </div>
        <h1 class="text-2xl font-bold text-gray-800">Application Details</h1>
        <p class="text-gray-500">
            Viewing application from <span class="font-semibold text-primary-700">{{ $application->user->name }}</span> for the post of <span class="font-semibold text-primary-700">{{ $application->job->post_name }}</span>.
        </p>
    </div>

    @include('partials._session-messages')

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        {{-- ===================================================== --}}
        {{-- Right Column: Actions & Status (Sticky on Large Screens) --}}
        {{-- ===================================================== --}}
        <div class="lg:col-span-1 lg:order-last">
            <div class="bg-white p-6 rounded-xl shadow-soft border border-gray-200 sticky top-24">
                {{-- Applicant Summary --}}
                <div class="flex items-center">
                    <img class="h-16 w-16 rounded-full object-cover" src="{{ $application->user->profile_picture ? Storage::url($application->user->profile_picture) : 'https://ui-avatars.com/api/?name='.urlencode($application->user->name) }}" alt="Applicant Photo">
                    <div class="ml-4">
                        <h3 class="text-lg font-bold text-gray-900">{{ $application->user->name }}</h3>
                        <p class="text-sm text-gray-500">{{ $application->user->email }}</p>
                    </div>
                </div>

                {{-- Status Management --}}
                <div class="mt-6 border-t pt-4">
                    <p class="text-sm font-medium text-gray-700">Current Status:</p>
                    <p class="text-xl font-bold capitalize
                        @if($application->status == 'submitted') text-green-600 @endif
                        @if($application->status == 'rejected') text-red-600 @endif
                        @if(in_array($application->status, ['accepted', 'shortlisted', 'reviewed'])) text-blue-600 @endif
                    ">
                        {{ str_replace('_', ' ', $application->status) }}
                    </p>
                </div>

                @can('update-application-status')
                <div class="mt-4 border-t pt-4">
                    <form action="{{ route('admin.applications.status.update', $application) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Change Status</label>
                        <select name="status" id="status" class="block w-full px-3 py-2 border border-gray-300 bg-white rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
                            <option value="submitted" @if($application->status == 'submitted') selected @endif>Submitted</option>
                            <option value="reviewed" @if($application->status == 'reviewed') selected @endif>Reviewed</option>
                            <option value="shortlisted" @if($application->status == 'shortlisted') selected @endif>Shortlisted</option>
                            <option value="accepted" @if($application->status == 'accepted') selected @endif>Accepted</option>
                            <option value="rejected" @if($application->status == 'rejected') selected @endif>Rejected</option>
                        </select>
                        <button type="submit" class="mt-3 w-full bg-primary-600 hover:bg-primary-700 text-white py-2 px-4 rounded-lg font-medium text-sm">Update Status</button>
                    </form>
                </div>
                @endcan

                <div class="mt-4 border-t pt-4 text-xs text-gray-500">
                    <p><strong>Applicant:</strong> {{ $application->user->name }}</p>
                    <p><strong>Applied On:</strong> {{ $application->created_at->format('d M, Y') }}</p>
                    <p><strong>Transaction ID:</strong> {{ $application->transaction_id ?? 'N/A' }}</p>
                </div>
            </div>
        </div>

        {{-- =================================== --}}
        {{-- Left Column: Snapshot Details      --}}
        {{-- =================================== --}}
        <div class="lg:col-span-2 space-y-8">

            {{-- Personal Information Snapshot --}}
            @if ($snapshot['profile'])
            <div class="bg-white p-6 rounded-xl shadow-soft">
                <h3 class="text-lg font-semibold text-gray-900 border-b pb-4 mb-4 flex items-center"><i class="fas fa-user-circle mr-3 text-primary-500"></i>Personal Information (Snapshot)</h3>
                <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-3 text-sm">
                    <div class="sm:col-span-1"><dt class="font-medium text-gray-500">Full Name</dt><dd class="text-gray-900 mt-1">{{ $snapshot['profile']->full_name_en }}</dd></div>
                    <div class="sm:col-span-1"><dt class="font-medium text-gray-500">Father's Name</dt><dd class="text-gray-900 mt-1">{{ $snapshot['profile']->father_name_en }}</dd></div>
                    <div class="sm:col-span-1"><dt class="font-medium text-gray-500">Mother's Name</dt><dd class="text-gray-900 mt-1">{{ $snapshot['profile']->mother_name_en }}</dd></div>
                    <div class="sm:col-span-1"><dt class="font-medium text-gray-500">Date of Birth</dt><dd class="text-gray-900 mt-1">{{ \Carbon\Carbon::parse($snapshot['profile']->dob)->format('d F, Y') }}</dd></div>
                    <div class="sm:col-span-1"><dt class="font-medium text-gray-500">Mobile</dt><dd class="text-gray-900 mt-1">{{ $snapshot['profile']->phone_mobile }}</dd></div>
                    <div class="sm:col-span-1"><dt class="font-medium text-gray-500">Marital Status</dt><dd class="text-gray-900 mt-1">{{ $snapshot['profile']->marital_status }}</dd></div>
                    <div class="sm:col-span-2"><dt class="font-medium text-gray-500">Present Address</dt><dd class="text-gray-900 mt-1">{{ $snapshot['profile']->present_address_en }}</dd></div>
                </dl>
            </div>
            @endif

            {{-- Education Snapshot --}}
            @if (!$snapshot['educations']->isEmpty())
            <div class="bg-white p-6 rounded-xl shadow-soft">
                <h3 class="text-lg font-semibold text-gray-900 border-b pb-4 mb-4 flex items-center"><i class="fas fa-graduation-cap mr-3 text-primary-500"></i>Education (Snapshot)</h3>
                <div class="space-y-4">
                    @foreach($snapshot['educations'] as $education)
                    <div class="text-sm border-l-4 border-gray-100 pl-4">
                        <p class="font-bold text-gray-800">{{ $education->exam_name }}</p>
                        <p class="text-gray-600">{{ $education->institution_name }}</p>
                        <p class="text-gray-500">Year: {{ $education->passing_year }}, Result: {{ $education->gpa_or_cgpa }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- Experience Snapshot --}}
            @if (!$snapshot['experiences']->isEmpty())
            <div class="bg-white p-6 rounded-xl shadow-soft">
                <h3 class="text-lg font-semibold text-gray-900 border-b pb-4 mb-4 flex items-center"><i class="fas fa-briefcase mr-3 text-primary-500"></i>Experience (Snapshot)</h3>
                <div class="space-y-4">
                    @foreach($snapshot['experiences'] as $experience)
                     <div class="text-sm border-l-4 border-gray-100 pl-4">
                        <p class="font-bold text-gray-800">{{ $experience->post_and_scale }}</p>
                        <p class="text-gray-600">{{ $experience->institute_name }}</p>
                        <p class="text-gray-500">{{ \Carbon\Carbon::parse($experience->from_date)->format('M, Y') }} - {{ $experience->to_date ? \Carbon\Carbon::parse($experience->to_date)->format('M, Y') : 'Present' }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- Publications Snapshot --}}
            @if (!$snapshot['publications']->isEmpty())
            <div class="bg-white p-6 rounded-xl shadow-soft">
                <h3 class="text-lg font-semibold text-gray-900 border-b pb-4 mb-4 flex items-center"><i class="fas fa-book-open mr-3 text-primary-500"></i>Publications (Snapshot)</h3>
                <ul class="list-disc list-inside space-y-2 text-sm text-gray-700">
                    @foreach($snapshot['publications'] as $publication)
                        <li>{{ $publication->title }} <span class="text-gray-500">({{ $publication->publicationType->name }})</span></li>
                    @endforeach
                </ul>
            </div>
            @endif

            {{-- Trainings Snapshot --}}
            @if (!$snapshot['trainings']->isEmpty())
            <div class="bg-white p-6 rounded-xl shadow-soft">
                <h3 class="text-lg font-semibold text-gray-900 border-b pb-4 mb-4 flex items-center"><i class="fas fa-certificate mr-3 text-primary-500"></i>Trainings (Snapshot)</h3>
                <div class="space-y-4">
                    @foreach($snapshot['trainings'] as $training)
                     <div class="text-sm border-l-4 border-gray-100 pl-4">
                        <p class="font-bold text-gray-800">{{ $training->training_name }}</p>
                        <p class="text-gray-600">{{ $training->institute_name }}</p>
                        <p class="text-gray-500">Period: {{ $training->period_from }} to {{ $training->period_to }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- Awards Snapshot --}}
            @if (!$snapshot['awards']->isEmpty())
            <div class="bg-white p-6 rounded-xl shadow-soft">
                <h3 class="text-lg font-semibold text-gray-900 border-b pb-4 mb-4 flex items-center"><i class="fas fa-award mr-3 text-primary-500"></i>Awards (Snapshot)</h3>
                <ul class="list-disc list-inside space-y-2 text-sm text-gray-700">
                    @foreach($snapshot['awards'] as $award)
                        <li>{{ $award->award_name }} - {{ $award->awarding_body }} ({{ $award->year_received }})</li>
                    @endforeach
                </ul>
            </div>
            @endif

            {{-- Referees Snapshot --}}
            @if (!$snapshot['referees']->isEmpty())
            <div class="bg-white p-6 rounded-xl shadow-soft">
                <h3 class="text-lg font-semibold text-gray-900 border-b pb-4 mb-4 flex items-center"><i class="fas fa-users mr-3 text-primary-500"></i>Referees (Snapshot)</h3>
                <div class="space-y-4">
                    @foreach($snapshot['referees'] as $referee)
                     <div class="text-sm border-l-4 border-gray-100 pl-4">
                        <p class="font-bold text-gray-800">{{ $referee->name }}</p>
                        <p class="text-gray-600">{{ $referee->designation }}, {{ $referee->organization }}</p>
                        <p class="text-gray-500">Email: {{ $referee->email }}, Phone: {{ $referee->phone }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

        </div>
    </div>
</x-app-layout>
