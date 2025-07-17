<x-app-layout>
    {{-- Page Header --}}
    <div class="mb-6">
        <div class="mb-2">
            <a href="{{ route('admin.circulars.index') }}" class="inline-flex items-center text-gray-500 hover:text-gray-700 font-medium group">
                <i class="fas fa-arrow-left mr-2 transition-transform group-hover:-translate-x-1"></i>
                Back to Circulars
            </a>
        </div>
        <h1 class="text-2xl font-bold text-gray-800">Application Submissions</h1>
        <p class="text-gray-500">
            Showing applications for Circular No: <span class="font-semibold text-primary-700">{{ $circular->circular_no }}</span>
        </p>
    </div>

    @include('partials._session-messages')

    <div class="bg-white p-6 rounded-xl shadow-soft">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-600">
                <thead class="text-xs text-gray-700 uppercase bg-gray-100">
                    <tr>
                        <th scope="col" class="px-6 py-3">Applicant Name</th>
                        <th scope="col" class="px-6 py-3">Applied For</th>
                        <th scope="col" class="px-6 py-3">Applied On</th>
                        <th scope="col" class="px-6 py-3">Status</th>
                        <th scope="col" class="px-6 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($applications as $application)
                        <tr class="bg-white border-b hover:bg-primary-50">
                            <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                <p class="font-semibold">{{ $application->user->name }}</p>
                                <p class="text-xs text-gray-500">{{ $application->user->email }}</p>
                            </td>
                            <td class="px-6 py-4">{{ $application->job->post_name }}</td>
                            <td class="px-6 py-4">{{ $application->created_at->format('d M, Y h:i A') }}</td>
                            <td class="px-6 py-4">
                                <span class="px-2.5 py-1 text-xs font-semibold rounded-full capitalize
                                    @if($application->status == 'submitted') bg-green-100 text-green-800 @endif
                                    @if($application->status == 'pending') bg-yellow-100 text-yellow-800 @endif
                                    @if($application->status == 'rejected') bg-red-100 text-red-800 @endif
                                    @if($application->status == 'accepted' || $application->status == 'shortlisted' || $application->status == 'reviewed') bg-blue-100 text-blue-800 @endif
                                ">
                                    {{ str_replace('_', ' ', $application->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-end">
                                    <a href="{{ route('admin.applications.show', $application) }}" class="font-medium text-primary-600 hover:text-primary-800 inline-flex items-center">
                                        View Details <i class="fas fa-arrow-right ml-2"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-8 text-gray-500">
                                <i class="fas fa-user-slash text-4xl text-gray-300"></i>
                                <p class="mt-4">No applications have been submitted for this circular yet.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-6">{{ $applications->links() }}</div>
    </div>
</x-app-layout>
