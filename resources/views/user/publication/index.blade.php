<x-profile-layout>
    {{-- Page Header --}}
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h2 class="text-xl font-bold text-gray-800">My Publications</h2>
            <p class="text-gray-500">Drag and drop the items to change their display order.</p>
        </div>
        <a href="{{ route('publication.create') }}" class="bg-primary-600 hover:bg-primary-700 text-white py-2 px-4 rounded-lg font-medium text-sm">
            <i class="fas fa-plus mr-2"></i> Add Publication
        </a>
    </div>

    @include('partials._session-messages')

    {{-- Main Content Card --}}
    <div class="bg-white p-6 rounded-xl shadow-soft">
        {{--
            The x-data attribute initializes an Alpine.js component.
            The initSortable() method will be called when it's ready.
        --}}
        <div x-data="sortableComponent('{{ route('publication.reorder') }}')">
            {{--
                The id="sortable-list" is the target for SortableJS.
                The data-id attribute on each item is crucial for tracking the order.
            --}}
            <div id="sortable-list" class="space-y-4">
                @forelse ($publications->sortBy('rank') as $publication)
                    <div class="p-4 border rounded-lg flex justify-between items-center bg-white cursor-grab active:cursor-grabbing"
                         data-id="{{ $publication->id }}">

                        <div class="flex items-center">
                             {{-- Drag Handle Icon --}}
                            <i class="fas fa-grip-vertical text-gray-400 mr-4"></i>
                            <div>
                                <h3 class="font-bold text-lg text-gray-800">{{ $publication->title }}</h3>
                                <p class="text-sm text-gray-500 mt-1">
                                    <span class="font-semibold">Type:</span>
                                    {{ isset($publication->publicationType) ? $publication->publicationType->name : 'N/A' }}
                                </p>
                            </div>
                        </div>

                        {{-- Action Buttons --}}
                        <div class="flex items-center space-x-2 shrink-0 ml-4">
                            {{-- ... (Your existing edit and delete buttons go here) ... --}}
                             <a href="{{ route('publication.edit', $publication) }}" class="flex items-center justify-center w-8 h-8 rounded-full bg-gray-100 hover:bg-primary-100 text-primary-600">
                                <i class="fas fa-pencil-alt"></i>
                            </a>
                            <form action="{{ route('publication.destroy', $publication) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                                @csrf @method('DELETE')
                                <button type="submit" class="flex items-center justify-center w-8 h-8 rounded-full bg-gray-100 hover:bg-red-100 text-red-600">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8">
                        <i class="fas fa-book-open text-4xl text-gray-300"></i>
                        <p class="mt-4 text-gray-500">You haven't added any publications yet.</p>
                    </div>
                @endforelse
            </div>

            {{-- Feedback message for the user --}}
            <div x-show="message" x-text="message"
                 :class="{ 'text-green-600': status === 'success', 'text-red-600': status === 'error' }"
                 class="mt-4 text-sm font-medium transition-opacity"
                 x-transition>
            </div>
        </div>
    </div>

    {{-- The JavaScript logic to power the drag-and-drop functionality --}}
    <script>
        function sortableComponent(url) {
            return {
                message: '',
                status: '',
                init() {
                    let sortable = new Sortable(document.getElementById('sortable-list'), {
                        animation: 150,
                        ghostClass: 'bg-primary-100',
                        onEnd: () => {
                            this.saveOrder();
                        },
                    });
                },
                saveOrder() {
                    let order = Array.from(document.getElementById('sortable-list').children).map(el => {
                        return el.getAttribute('data-id');
                    });

                    fetch(url, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({ order: order })
                    })
                    .then(response => response.json())
                    .then(data => {
                        this.message = data.message;
                        this.status = data.status;
                        // Hide message after 3 seconds
                        setTimeout(() => { this.message = '' }, 3000);
                    })
                    .catch(error => {
                        this.message = 'An error occurred while saving the order.';
                        this.status = 'error';
                        console.error('Error:', error);
                    });
                }
            }
        }
    </script>
</x-profile-layout>
