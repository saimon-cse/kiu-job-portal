<x-app-layout>
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">My Application History</h1>
        <p class="text-gray-500">Track the status of your applications and complete any required actions.</p>
    </div>

    @include('partials._session-messages')

    <div class="space-y-6">
        @forelse ($applications as $application)
            <div class="bg-white rounded-xl shadow-soft border border-gray-200 overflow-hidden">
                <div class="p-6">
                    <div class="flex flex-col sm:flex-row justify-between">
                        <!-- Main Application Info -->
                        <div class="flex-grow">
                            <div class="flex items-center mb-2">
                                <!-- Status Badge -->
                                <span
                                    class="px-3 py-1 text-xs font-semibold rounded-full capitalize
                                    @if ($application->status == 'submitted') bg-green-100 text-green-800 @endif
                                    @if ($application->status == 'pending') bg-yellow-100 text-yellow-800 @endif
                                    @if ($application->status == 'rejected') bg-red-100 text-red-800 @endif
                                    @if ($application->status == 'accepted') bg-blue-100 text-blue-800 @endif
                                ">
                                    {{ $application->status }}
                                </span>
                                <p class="ml-3 text-sm text-gray-500">
                                    Applied on: <span
                                        class="font-medium text-gray-700">{{ $application->created_at->format('d M, Y') }}</span>
                                </p>
                            </div>

                            <!-- Post Name -->
                            <a href="{{ route('circulars.show', $application->job->circular) }}" class="block">
                                <h2 class="text-xl font-bold text-primary-800 hover:text-primary-600">
                                    {{ $application->job->post_name }}
                                </h2>
                            </a>

                            <!-- Circular & Fee Info -->
                            <p class="text-sm text-gray-600 mt-1">
                                From Circular: <span
                                    class="font-medium">{{ $application->job->circular->circular_no }}</span>
                                <span class="mx-2 text-gray-300">|</span>
                                Fee: <span class="font-medium">BDT
                                    {{ number_format($application->due_amount, 2) }}</span>
                            </p>
                        </div>

                        <!-- Deadline Info -->
                        <div class="mt-4 sm:mt-0 sm:ml-6 text-left sm:text-right shrink-0">
                            <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Application Deadline
                            </p>
                            <p
                                class="text-2xl font-bold {{ $application->job->circular->last_date_of_submission->isPast() ? 'text-gray-400' : 'text-red-600' }}">
                                {{ $application->job->circular->last_date_of_submission->format('d') }}
                            </p>
                            <p class="text-sm text-gray-500 -mt-1">
                                {{ $application->job->circular->last_date_of_submission->format('M, Y') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Action Footer -->
                @if ($application->status == 'pending')
                    <div class="border-t border-gray-100 px-6 py-4 bg-gray-50/75">
                        <div class="flex items-center justify-between">
                            {{-- Delete Button (on the left) --}}
                            <div>
                                <form action="{{ route('applications.history.destroy', $application) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this pending application?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="font-medium text-red-600 hover:text-red-800 text-sm inline-flex items-center">
                                        <i class="fas fa-trash-alt mr-2"></i>
                                        Delete Application
                                    </button>
                                </form>
                            </div>

                            {{-- Payment Button (on the right) --}}
                            <div>
                                @if ($application->job->circular->last_date_of_submission->isFuture())
                                    <a href="{{ route('payment.pay', ['application' => $application->id]) }}"
                                        class="font-medium text-white bg-primary-600 hover:bg-primary-700 py-2 px-5 rounded-lg text-sm inline-flex items-center">
                                        <i class="fas fa-credit-card mr-2"></i>
                                        Complete Payment
                                    </a>
                                @else
                                    <div class="font-medium text-white bg-gray-400 py-2 px-5 rounded-lg text-sm inline-flex items-center cursor-not-allowed">
                                        <i class="fas fa-times-circle mr-2"></i>
                                        Deadline Passed
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        @empty
            <div class="text-center bg-white p-12 rounded-xl shadow-soft border">
                <i class="fas fa-file-alt text-5xl text-gray-300"></i>
                <p class="mt-4 text-gray-600 font-semibold text-lg">No Applications Found</p>
                <p class="mt-1 text-gray-500">You have not applied for any jobs yet.</p>
                <a href="{{ route('circulars.index') }}"
                    class="mt-6 inline-flex items-center px-4 py-2 bg-primary-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-primary-700">
                    Browse Available Jobs
                </a>
            </div>
        @endforelse
    </div>

    {{-- Pagination Links --}}
    <div class="mt-8">
        {{ $applications->links() }}
    </div>



</x-app-layout>
