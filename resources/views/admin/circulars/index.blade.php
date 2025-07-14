<x-app-layout>

    <div class="mb-6 flex flex-col md:flex-row justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Circulars & Job Posts</h1>
            <p class="text-gray-500">Manage all job circulars and view application counts.</p>
        </div>
        <a href="{{ route('admin.circulars.create') }}" class="w-full md:w-auto mt-4 md:mt-0 bg-primary-600 hover:bg-primary-700 text-white py-2 px-4 rounded-lg font-medium text-center">
            <i class="fas fa-plus mr-2"></i> Add New Circular
        </a>
    </div>

    @include('partials._session-messages')

    {{-- Main Content Card --}}
    <div class="bg-white p-6 rounded-xl shadow-soft">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-600">
                <thead class="text-xs text-gray-700 uppercase bg-gray-100">
                    <tr>
                        <th scope="col" class="px-6 py-3">Circular Details</th>
                        <th scope="col" class="px-6 py-3">Dates</th>
                        <th scope="col" class="px-6 py-3 text-center">Posts</th>
                        <th scope="col" class="px-6 py-3 text-center">Applications</th>
                        <th scope="col" class="px-6 py-3">Status</th>
                        <th scope="col" class="px-6 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($circulars as $circular)
                        <tr class="bg-white border-b hover:bg-primary-50">
                            {{-- Circular Details --}}
                            <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                <p class="font-semibold">{{ $circular->circular_no }}</p>
                                <p class="text-xs text-gray-500">
                                    Created by:
                                    {{-- Safely access the creator's name --}}
                                    {{ isset($circular->creator) ? $circular->creator->name : 'N/A' }}
                                </p>
                            </td>
                            {{-- Dates --}}
                            <td class="px-6 py-4 whitespace-nowrap text-xs">
                                <div>
                                    <span class="font-semibold text-gray-500">Post:</span>
                                    <span>{{ $circular->post_date->format('d M, Y') }}</span>
                                </div>
                                <div class="mt-1">
                                    <span class="font-semibold text-red-500">Last:</span>
                                    <span>{{ $circular->last_date_of_submission->format('d M, Y') }}</span>
                                </div>
                            </td>
                            {{-- Number of Posts --}}
                            <td class="px-6 py-4 text-center">
                                <span class="text-lg font-bold text-gray-800">{{ $circular->jobs_count }}</span>
                            </td>
                            {{-- Number of Applications --}}
                            <td class="px-6 py-4 text-center">
                                <span class="text-lg font-bold text-primary-700">{{ $circular->job_applications_count }}</span>
                            </td>
                            {{-- Status Badge --}}
                            <td class="px-6 py-4">
                                <span class="px-2.5 py-1 text-xs font-semibold rounded-full capitalize
                                    @if($circular->status == 'open') bg-green-100 text-green-800 @endif
                                    @if($circular->status == 'closed') bg-red-100 text-red-800 @endif
                                    @if($circular->status == 'archived') bg-gray-100 text-gray-800 @endif
                                ">
                                    {{ $circular->status }}
                                </span>
                            </td>
                            {{-- Action Buttons --}}
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-end space-x-2">
                                    <div class="relative group">
                                        <a href="{{ route('admin.circulars.edit', $circular) }}" class="flex items-center justify-center w-8 h-8 rounded-full bg-gray-100 hover:bg-primary-100 text-primary-600">
                                            <i class="fas fa-pencil-alt"></i>
                                        </a>
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
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-8 text-gray-500">
                                <i class="fas fa-file-alt text-4xl text-gray-300"></i>
                                <p class="mt-4">No circulars have been created yet.</p>
                                <a href="{{ route('admin.circulars.create') }}" class="mt-4 inline-block text-primary-600 hover:underline font-medium">Create the first one</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{-- Pagination Links --}}
        <div class="mt-6">
            {{ $circulars->links() }}
        </div>
    </div>
</x-app-layout>
