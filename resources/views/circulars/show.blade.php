@extends(Auth::check() ? 'layouts.app' : 'layouts.public')

@section('content')
    <div class="max-w-7xl mx-auto py-8 sm:py-12 px-4 sm:px-6 lg:px-8">
        {{-- Back Link --}}
        <div class="mb-6">
            <a href="{{ route('circulars.index') }}"
                class="inline-flex items-center text-gray-500 hover:text-gray-700 font-medium group">
                <i class="fas fa-arrow-left mr-2 transition-transform group-hover:-translate-x-1"></i>
                Back to All Circulars
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            {{-- Left Column: Circular Details --}}
            <div class="lg:col-span-1">
                <div class="bg-white p-6 rounded-xl shadow-soft border border-gray-200 sticky top-24">
                    <h1 class="text-xl font-bold text-gray-900">Circular Details</h1>
                    <p class="text-sm text-gray-500 mt-1">Circular No: {{ $circular->circular_no }}</p>

                    <div class="mt-4 space-y-3 text-sm text-gray-700 border-t pt-4">
                        <div class="flex items-start">
                            <i class="fas fa-calendar-check text-gray-400 mr-3 mt-1 w-4 text-center"></i>
                            <div>
                                <span class="font-semibold">Post Date</span><br>
                                <span>{{ $circular->post_date->format('d F, Y') }}</span>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <i class="fas fa-calendar-times text-red-500 mr-3 mt-1 w-4 text-center"></i>
                            <div>
                                <span class="font-semibold">Application Deadline</span><br>
                                <span
                                    class="font-bold text-red-600">{{ $circular->last_date_of_submission->format('d F, Y') }}</span>
                            </div>
                        </div>
                    </div>

                    @if ($circular->description)
                        <div class="mt-4 border-t pt-4">
                            <h3 class="font-semibold text-gray-800 mb-1">Description</h3>
                            <p class="text-sm text-gray-600">{!! nl2br(e($circular->description)) !!}</p>
                        </div>
                    @endif

                    @if ($circular->document_path)
                        <div class="mt-6">
                            <a href="{{ Storage::url($circular->document_path) }}" target="_blank"
                                class="w-full inline-flex items-center justify-center px-4 py-2 bg-primary-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-primary-700">
                                <i class="fas fa-download mr-2"></i>
                                Download Full Circular
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            {{-- {{ dd($circular->last_date_of_submission->isFuture()) }} --}}
            {{-- Right Column: Available Job Posts --}}
            <div class="lg:col-span-2">
                <h2 class="text-2xl font-semibold text-gray-800 mb-4">Available Positions ({{ $circular->jobs->count() }})
                </h2>
                <div class="space-y-4">
                    @forelse($circular->jobs->sortBy('rank') as $job)
                        <div
                            class="bg-white rounded-xl shadow-soft border border-gray-200 p-5 flex flex-col md:flex-row justify-between md:items-center">
                            <div>
                                <h3 class="text-xl font-bold text-primary-800">{{ $job->post_name }}</h3>
                                @if ($job->department_office)
                                    <p class="text-gray-600 mt-1">{{ $job->department_office }}</p>
                                @endif
                                <p class="text-sm text-gray-500 mt-2">
                                    Application Fee: <span class="font-semibold text-gray-800">BDT
                                        {{ number_format($job->application_fee, 2) }}</span>
                                </p>
                            </div>
                            <div class="mt-4 md:mt-0 md:ml-6 shrink-0">
                                @auth
                                    @if (auth()->user()->hasAppliedFor($job->id))
                                        <button
                                            class="w-full md:w-auto flex items-center justify-center bg-green-100 text-green-700 py-2 px-6 rounded-lg font-medium cursor-not-allowed"
                                            disabled>
                                            <i class="fas fa-check-circle mr-2"></i>
                                            Applied
                                        </button>
                                    @elseif($circular->last_date_of_submission->isFuture())
                                        <form action="{{ route('jobs.apply', $job) }}" method="POST"
                                            onsubmit="return confirm('Apply for the post of \'{{ $job->post_name }}\'? Your current profile information will be saved for this application.');">
                                            @csrf
                                            <button type="submit"
                                                class="w-full md:w-auto flex items-center justify-center bg-primary-600 hover:bg-primary-700 text-white py-2 px-6 rounded-lg font-medium">
                                                <i class="fas fa-paper-plane mr-2"></i>
                                                Apply Now
                                            </button>
                                        </form>
                                    @else
                                        <div
                                            class="font-medium text-white bg-gray-400 py-2 px-5 rounded-lg text-sm inline-flex items-center cursor-not-allowed">
                                            <i class="fas fa-times-circle mr-2"></i>
                                            Deadline Passed
                                        </div>
                                    @endif
                                @else
                                    <a href="{{ route('login') }}"
                                        class="w-full md:w-auto flex items-center justify-center bg-gray-700 hover:bg-gray-800 text-white py-2 px-6 rounded-lg font-medium">
                                        <i class="fas fa-sign-in-alt mr-2"></i>
                                        Login to Apply
                                    </a>
                                @endauth
                            </div>
                        </div>
                    @empty
                        <div class="bg-white rounded-xl shadow-soft border p-8 text-center">
                            <p class="text-gray-500">No specific job posts were found for this circular.</p>
                        </div>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
@endsection
