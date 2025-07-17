<x-app-layout>
    {{-- Page Header --}}
    <div class="mb-6">
        <div class="mb-2">
            <a href="{{ route('admin.circulars.index') }}" class="inline-flex items-center text-gray-500 hover:text-gray-700 font-medium group">
                <i class="fas fa-arrow-left mr-2 transition-transform group-hover:-translate-x-1"></i>
                Back to Circulars List
            </a>
        </div>
        <h1 class="text-2xl font-bold text-gray-800">Job Posts</h1>
        <p class="text-gray-500">
            Showing all posts for Circular No: <span class="font-semibold text-primary-700">{{ $circular->circular_no }}</span>
        </p>
    </div>

    <div class="bg-white p-6 rounded-xl shadow-soft">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-600">
                <thead class="text-xs text-gray-700 uppercase bg-gray-100">
                    <tr>
                        <th class="px-6 py-3">Post Name</th>
                        <th class="px-6 py-3 text-center">Total Applicants</th>
                        <th class="px-6 py-3 text-center">Paid</th>
                        <th class="px-6 py-3 text-center">Eligible/Shortlisted</th>
                        <th class="px-6 py-3 text-center">Downloads</th>
                        <th class="px-6 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($jobs as $job)
                        <tr class="bg-white border-b hover:bg-primary-50">
                            {{-- Post Details --}}
                            <td class="px-6 py-4">
                                <p class="font-semibold text-gray-900">{{ $job->post_name }}</p>
                                <p class="text-xs text-gray-500">{{ $job->department_office }}</p>
                            </td>
                            {{-- Counts --}}
                            <td class="px-6 py-4 text-center font-bold text-blue-600">{{ $job->applications_count }}</td>
                            <td class="px-6 py-4 text-center font-bold text-green-600">{{ $job->paid_applications_count }}</td>
                            <td class="px-6 py-4 text-center font-bold text-purple-600">{{ $job->eligible_applications_count }}</td>

                            {{-- Downloads Dropdown Column --}}
                            <td class="px-6 py-4 text-center">
                                {{--
                                    Each dropdown is an independent Alpine.js component.
                                    It's initialized with our dropdown() function.
                                --}}
                                <div x-data="dropdown()" @click.outside="open = false" class="relative">
                                    {{-- Dropdown Trigger Button --}}
                                    <button @click="toggle($event.currentTarget)"
                                            class="px-3 py-1 bg-gray-200 text-gray-700 rounded-md text-xs font-medium hover:bg-gray-300 focus:outline-none">
                                        Download <i class="fas fa-chevron-down ml-1 text-xs"></i>
                                    </button>

                                    {{--
                                        The x-teleport directive moves this dropdown menu to the
                                        #teleport-target div at the end of the <body> tag.
                                        This prevents it from being clipped by the scrollable table container.
                                    --}}
                                    <template x-teleport="#teleport-target">
                                        <div x-show="open"
                                             x-transition:enter="transition ease-out duration-100"
                                             x-transition:enter-start="opacity-0 scale-95"
                                             x-transition:enter-end="opacity-100 scale-100"
                                             x-transition:leave="transition ease-in duration-75"
                                             x-transition:leave-start="opacity-100 scale-100"
                                             x-transition:leave-end="opacity-0 scale-95"
                                             :style="`position: absolute; top: ${position.top}px; left: ${position.left}px;`"
                                             class="w-56 bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none text-left z-50"
                                             x-cloak>
                                            <div class="py-1">
                                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"><i class="fas fa-users fa-fw mr-2 text-gray-400"></i>All Applicants' Forms</a>
                                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"><i class="fas fa-user-check fa-fw mr-2 text-purple-500"></i>Eligible Applicants' Forms</a>
                                                <div class="border-t my-1"></div>
                                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"><i class="fas fa-id-card fa-fw mr-2 text-green-500"></i>Download Admit Cards</a>
                                            </div>
                                        </div>
                                    </template>
                                </div>
                            </td>

                            {{-- Actions --}}
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('admin.jobs.applications.index', $job) }}" class="font-medium text-primary-600 hover:text-primary-800 inline-flex items-center text-sm">
                                    View Applicants <i class="fas fa-arrow-right ml-2 text-xs"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="text-center py-8 text-gray-500">No job posts found for this circular.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-6">{{ $jobs->links() }}</div>
    </div>

    {{-- The Reusable JavaScript logic for the dropdown positioning --}}
    @push('scripts')
    <script>
        function dropdown() {
            return {
                open: false,
                position: { top: 0, left: 0 },
                toggle(button) {
                    if (this.open) {
                        return this.open = false;
                    }

                    // Get the position of the button that was clicked
                    const rect = button.getBoundingClientRect();

                    // Set the dropdown's position.
                    // It will appear below the button, and its right edge will align with the button's right edge.
                    this.position.top = rect.bottom + window.scrollY + 4; // 4px margin below the button
                    this.position.left = rect.right + window.scrollX - 224; // 224 is the width (w-56) of the dropdown

                    this.open = true;
                }
            }
        }
    </script>
    @endpush
</x-app-layout>
