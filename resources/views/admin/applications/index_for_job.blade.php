<x-app-layout>
    {{-- Page Header --}}
    <div class="mb-6">
        <div class="mb-4">
            <a href="{{ route('admin.circulars.jobs.index', $job->circular) }}" class="inline-flex items-center text-gray-500 hover:text-gray-700 font-medium group text-sm">
                <i class="fas fa-arrow-left mr-2 transition-transform group-hover:-translate-x-1"></i>
                Back to Posts List
            </a>
        </div>
        <h1 class="text-3xl font-bold text-gray-900">Applicant List</h1>
        <p class="text-lg text-gray-600 mt-1">
            For post: <span class="font-semibold text-primary-700">{{ $job->post_name }}</span>
        </p>
    </div>

    @include('partials._session-messages')

    {{-- Main Form for Bulk Actions, powered by Alpine.js --}}
    <form action="{{ route('admin.applications.status.bulk-update') }}" method="POST"
          x-data="{
              allSelected: false,
              selectedCount: 0,
              applicationIds: [],
              toggleAll() {
                  this.allSelected = !this.allSelected;
                  document.querySelectorAll('.applicant-checkbox').forEach(checkbox => checkbox.checked = this.allSelected);
                  this.updateCount();
              },
              updateCount() {
                  this.applicationIds = Array.from(document.querySelectorAll('.applicant-checkbox:checked')).map(el => el.value);
                  this.selectedCount = this.applicationIds.length;
                  // If no checkboxes are checked, or not all are checked, uncheck the 'select all' master checkbox
                  if (this.selectedCount < document.querySelectorAll('.applicant-checkbox').length) {
                      this.allSelected = false;
                  } else if (this.selectedCount > 0) {
                      this.allSelected = true;
                  }
              }
          }">
        @csrf

        {{-- Bulk Action Bar --}}
        <div class="mb-6 bg-white p-4 rounded-xl shadow-soft border border-gray-200"
             x-data="{ open: false }" @click.away="open = false">
            <div class="flex items-center justify-between">
                <span class="text-sm font-medium text-gray-700">
                    <span x-text="selectedCount" class="font-bold text-primary-600"></span>
                    Applicant(s) Selected
                </span>
                {{-- <button @click="open = !open" type="button" x-bind:disabled="selectedCount === 0"
                        class="inline-flex items-center px-4 py-2 bg-primary-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-primary-700 disabled:bg-gray-300 disabled:cursor-not-allowed">
                    Actions <i class="fas fa-chevron-down ml-2 text-xs"></i>
                </button> --}}
            </div>

            {{-- Dropdown for Bulk Actions --}}
            {{-- <div x-show="open" x-transition class="mt-2 border-t pt-4" x-cloak> --}}
            <div  x-transition class="mt-2 border-t pt-4" x-cloak>
                <div class="flex items-center space-x-3">
                    <label for="bulk_status" class="text-sm font-medium">Set status to:</label>
                    <select name="status" id="bulk_status" class="block w-auto px-3 py-2 border border-gray-300 bg-white rounded-lg shadow-sm text-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
                        <option value="accepted">Mark as Eligible</option>
                        <option value="rejected">Mark as Rejected</option>
                        <option value="submitted">Reset to Submitted</option>
                    </select>
                    <button type="submit" class="bg-primary-800 hover:bg-gray-900 text-white py-2 px-4 rounded-lg text-sm font-medium">Apply Action</button>
                </div>
            </div>
        </div>

        {{-- Main Content Card with Table --}}
        <div class="bg-white rounded-xl shadow-soft border border-gray-200">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-600">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                        <tr>
                            <th class="p-4 w-4">
                                <input type="checkbox" @click="toggleAll()" :checked="allSelected"
                                       class="rounded border-gray-300 text-primary-600 shadow-sm focus:ring-primary-500">
                            </th>
                            <th scope="col" class="px-6 py-3">Applicant Details</th>
                            <th scope="col" class="px-6 py-3">Applied On</th>
                            {{-- <th scope="col" class="px-6 py-3">Payment Status</th> --}}
                            <th scope="col" class="px-6 py-3">Application Status</th>
                            <th scope="col" class="px-6 py-3 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($applications as $application)
                            <tr class="bg-white border-b hover:bg-primary-50/50">
                                <td class="w-4 p-4">
                                    <input type="checkbox" name="application_ids[]" value="{{ $application->id }}" @click="updateCount()"
                                           class="applicant-checkbox rounded border-gray-300 text-primary-600 shadow-sm focus:ring-primary-500">
                                </td>
                                {{-- Applicant Details --}}
                                <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                    <p class="font-semibold">{{ $application->user->name }}</p>
                                    <p class="text-xs text-gray-500">{{ $application->user->email }}</p>
                                </td>
                                {{-- Applied Date --}}
                                <td class="px-6 py-4 whitespace-nowrap">{{ $application->created_at->format('d M, Y') }}</td>
                                {{-- Payment Status --}}
                                {{-- <td class="px-6 py-4">
                                    @if($application->paid_amount > 0)
                                        <span class="inline-flex items-center px-2.5 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                            <i class="fas fa-check-circle mr-1.5"></i> Paid
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                            <i class="fas fa-exclamation-circle mr-1.5"></i> Unpaid
                                        </span>
                                    @endif
                                </td> --}}
                                {{-- Application Status --}}
                                <td class="px-6 py-4">
                                    <span class="px-2.5 py-1 text-xs font-semibold rounded-full capitalize @if($application->status == 'submitted') bg-green-100 text-green-800 @elseif(in_array($application->status, ['accepted', 'shortlisted', 'reviewed'])) bg-blue-100 text-blue-800 @else bg-red-100 text-red-800 @endif">
                                        {{ str_replace('_', ' ', $application->status) }}
                                    </span>
                                </td>
                                {{-- Actions Column --}}
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-end space-x-2">
                                        <div class="relative group">
                                            <a target="_blank" href="{{ route('admin.applications.show', $application) }}" class="flex items-center justify-center w-8 h-8 rounded-full bg-gray-100 hover:bg-blue-100 text-blue-600">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <span class="absolute bottom-full right-0 mb-2 px-2 py-1 text-xs text-white bg-gray-800 rounded-md opacity-0 invisible group-hover:opacity-100 group-hover:visible pointer-events-none">View Details</span>
                                        </div>
                                        <div class="relative group">
                                            <a href="#" class="flex items-center justify-center w-8 h-8 rounded-full bg-gray-100 hover:bg-green-100 text-green-600">
                                                <i class="fas fa-file-pdf"></i>
                                            </a>
                                            <span class="absolute bottom-full right-0 mb-2 px-2 py-1 text-xs text-white bg-gray-800 rounded-md opacity-0 invisible group-hover:opacity-100 group-hover:visible pointer-events-none">Export Form</span>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-8 text-gray-500">
                                    <i class="fas fa-user-slash text-4xl text-gray-300"></i>
                                    <p class="mt-4">No applications have been submitted for this post.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="p-6 border-t">
                {{ $applications->links() }}
            </div>
        </div>
    </form>
</x-app-layout>
