<x-profile-layout>
    {{-- Page Header --}}
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h2 class="text-xl font-bold text-gray-800">My Language Proficiencies</h2>
            <p class="text-gray-500">Drag and drop any item to change its display order.</p>
        </div>
        <a href="{{ route('language.create') }}" class="bg-primary-600 hover:bg-primary-700 text-white py-2 px-4 rounded-lg font-medium text-sm">
            <i class="fas fa-plus mr-2"></i> Add Language
        </a>
    </div>

    @include('partials._session-messages')

    {{-- Main Content Card --}}
    <div class="bg-white p-6 rounded-xl shadow-soft">
        {{-- Initialize the Alpine.js component, passing the correct reorder URL --}}
        <div x-data="sortableComponent('{{ route('language.reorder') }}')">
            {{-- This ID is the target for SortableJS. --}}
            <div id="sortable-list" class="space-y-4">
                {{-- The collection is already sorted by rank from the controller --}}
                @forelse ($languages as $language)
                    <div class="sortable-item p-4 border rounded-lg flex justify-between items-center bg-white cursor-grab active:cursor-grabbing"
                         data-id="{{ $language->id }}">

                        <div class="flex items-center">
                             {{-- Decorative Drag Icon --}}
                            <i class="fas fa-grip-vertical text-gray-300 mr-4"></i>
                            <div>
                                <h3 class="font-bold text-lg text-gray-800">{{ $language->language }}</h3>
                                <p class="text-gray-600 capitalize">Proficiency: {{ $language->efficiency }}</p>
                            </div>
                        </div>

                        {{-- Action Buttons --}}
                        <div class="flex items-center space-x-2 shrink-0 ml-4">
                            <a href="{{ route('language.edit', $language) }}" class="flex items-center justify-center w-8 h-8 rounded-full bg-gray-100 hover:bg-primary-100 text-primary-600">
                                <i class="fas fa-pencil-alt"></i>
                            </a>
                            <form action="{{ route('language.destroy', $language) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                                @csrf @method('DELETE')
                                <button type="submit" class="flex items-center justify-center w-8 h-8 rounded-full bg-gray-100 hover:bg-red-100 text-red-600">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8">
                        <i class="fas fa-language text-4xl text-gray-300"></i>
                        <p class="mt-4 text-gray-500">You haven't added any language proficiencies yet.</p>
                        {{-- <a href="{{ route('language.create') }}" class="mt-4 inline-block text-primary-600 hover:underline">Click here to add one.</a> --}}
                    </div>
                @endforelse
            </div>

            {{-- Feedback message for the user after a drag-and-drop action --}}
            <div x-show="message" x-text="message"
                 :class="{ 'text-green-600': status === 'success', 'text-red-600': status === 'error' }"
                 class="mt-4 text-sm font-medium transition-opacity"
                 x-transition>
            </div>
        </div>
    </div>

    {{-- The reusable JavaScript function to power the drag-and-drop functionality --}}
    <script>
        function sortableComponent(url) {
            return {
                message: '',
                status: '',
                init() {
                    let sortable = new Sortable(document.getElementById('sortable-list'), {
                        animation: 150,
                        ghostClass: 'sortable-ghost',
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
