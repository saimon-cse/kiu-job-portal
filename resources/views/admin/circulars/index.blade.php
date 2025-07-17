<x-app-layout>
    {{-- Page Header --}}
    <div class="mb-6 flex flex-col md:flex-row justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Circulars Management</h1>
            <p class="text-gray-500">Overview of all job circulars and their application statistics.</p>
        </div>
        <a href="{{ route('admin.circulars.create') }}" class="w-full md:w-auto mt-4 md:mt-0 bg-primary-600 hover:bg-primary-700 text-white py-2 px-4 rounded-lg font-medium text-center">
            <i class="fas fa-plus mr-2"></i> Add New Circular
        </a>
    </div>

    @include('partials._session-messages')

    {{-- Search and Filter Form --}}
    <div class="mb-6 bg-white p-4 rounded-xl shadow-soft">
        <form action="{{ route('admin.circulars.index') }}" method="GET">
            <div class="flex items-center">
                <input type="text" name="search" placeholder="Search by Circular No..." value="{{ request('search') }}"
                       class="block w-full md:w-1/3 px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
                <button type="submit" class="ml-3 bg-primary-600 text-white py-2 px-4 rounded-lg">Search</button>
                <a href="{{ route('admin.circulars.index') }}" class="ml-2 text-gray-600 hover:text-primary-600 py-2 px-4 rounded-lg">Reset</a>
            </div>
        </form>
    </div>

    {{-- Main Content Card with Table --}}
    <div class="bg-white p-6 rounded-xl shadow-soft">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-600">
                <thead class="text-xs text-gray-700 uppercase bg-gray-100">
                    <tr>
                        <th class="px-6 py-3">Circular Details</th>
                        <th class="px-6 py-3">Dates</th>
                        <th class="px-6 py-3 text-center">Posts</th>
                        <th class="px-6 py-3 text-center">Applications</th>
                        <th class="px-6 py-3 text-center">Paid</th>
                        <th class="px-6 py-3 text-center">Unpaid</th>
                        <th class="px-6 py-3 text-center">Eligible</th>
                        <th class="px-6 py-3">Status</th>
                        <th class="px-6 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($circulars as $circular)
                        <tr class="bg-white border-b hover:bg-primary-50">
                            <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap"><p class="font-semibold">{{ $circular->circular_no }}</p></td>
                            <td class="px-6 py-4 whitespace-nowrap text-xs">
                                <div><span class="font-semibold text-gray-500">Post:</span> {{ $circular->post_date->format('d M, Y') }}</div>
                                <div class="mt-1"><span class="font-semibold text-red-500">Last:</span> {{ $circular->last_date_of_submission->format('d M, Y') }}</div>
                            </td>
                            <td class="px-6 py-4 text-center font-bold text-gray-800">{{ $circular->jobs_count }}</td>
                            <td class="px-6 py-4 text-center font-bold text-blue-600">{{ $circular->job_applications_count }}</td>
                            <td class="px-6 py-4 text-center font-bold text-green-600">{{ $circular->paid_applications_count }}</td>
                            <td class="px-6 py-4 text-center font-bold text-yellow-600">{{ $circular->unpaid_applications_count }}</td>
                            <td class="px-6 py-4 text-center font-bold text-purple-600">{{ $circular->eligible_applications_count }}</td>
                            <td class="px-6 py-4">
                                <span class="px-2.5 py-1 text-xs font-semibold rounded-full capitalize @if($circular->status == 'open') bg-green-100 text-green-800 @else bg-gray-100 text-gray-800 @endif">
                                    {{ $circular->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-end space-x-2">
                                    <div class="relative group">
                                        <a href="{{ route('admin.circulars.jobs.index', $circular) }}" class="flex items-center justify-center w-8 h-8 rounded-full bg-gray-100 hover:bg-blue-100 text-blue-600"><i class="fas fa-list-ul"></i></a>
                                        <span class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 px-2 py-1 text-xs text-white bg-gray-800 rounded-md opacity-0 invisible group-hover:opacity-100 group-hover:visible pointer-events-none">View Posts</span>
                                    </div>
                                    <div class="relative group">
                                        <a href="{{ route('admin.circulars.edit', $circular) }}" class="flex items-center justify-center w-8 h-8 rounded-full bg-gray-100 hover:bg-primary-100 text-primary-600"><i class="fas fa-pencil-alt"></i></a>
                                                                                <span class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 px-2 py-1 text-xs text-white bg-gray-800 rounded-md opacity-0 invisible group-hover:opacity-100 group-hover:visible pointer-events-none">Edit</span>
                                    </div>
                                     <div class="relative group">
                                        <form action="{{ route('admin.circulars.destroy', $circular) }}" method="POST" onsubmit="return confirm('Are you sure? This will delete the circular and ALL its associated job posts.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="flex items-center justify-center w-8 h-8 rounded-full bg-gray-100 hover:bg-red-100 text-red-600">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                            <span class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 px-2 py-1 text-xs text-white bg-gray-800 rounded-md opacity-0 invisible group-hover:opacity-100 group-hover:visible pointer-events-none">Delete</span>
                                        </form>
                                    </div>
                                    {{-- ... Delete button ... --}}
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="9" class="text-center py-8 text-gray-500">No circulars found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-6">{{ $circulars->links() }}</div>
    </div>
</x-app-layout>
