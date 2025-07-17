@extends(Auth::check() ? 'layouts.app' : 'layouts.public')

@section('content')
    <div class="w-full">
        {{-- Hero Section --}}
        <div class="bg-white border-b border-gray-200">
            <div class="max-w-5xl mx-auto py-12 px-4 sm:px-6 lg:px-8 text-center">
                <h1 class="text-3xl sm:text-4xl font-bold text-gray-900 tracking-tight">
                    Career Opportunities
                </h1>
                {{-- <p class="mt-4 text-lg text-gray-600 max-w-2xl mx-auto">
                    We are always looking for talented individuals to join our team. Explore our current openings below and find your next great career move.
                </p> --}}
            </div>
        </div>

        {{-- Main Content Area --}}
        <div class="max-w-5xl mx-auto py-8 sm:py-12 px-4 sm:px-6 lg:px-8">
            @include('partials._session-messages')

            {{-- Circulars Card List --}}
            <div class="space-y-6">
                @forelse ($circulars as $circular)
                    <div class="bg-white rounded-xl shadow-soft border border-gray-200 hover:border-primary-400 hover:shadow-lg transition-all duration-300 overflow-hidden">
                        <div class="p-6">
                            <div class="flex flex-col sm:flex-row justify-between">
                                {{-- Main Info --}}
                                <div class="flex-grow">
                                    <div class="flex items-center mb-2">
                                        <p class="text-sm text-gray-500">
                                            Circular No: <span class="font-semibold text-gray-700">{{ $circular->circular_no }}</span>
                                        </p>
                                    </div>
                                    {{-- <a href="{{ route('circulars.show', $circular) }}" class="block">
                                        <h2 class="text-xl font-bold text-primary-800 hover:text-primary-600">
                                            {{ $circular->jobs_count }} {{ Str::plural('Position', $circular->jobs_count) }} Available
                                        </h2>
                                    </a> --}}
                                    <p class="text-lg text-gray-600 mt-1 line-clamp-2">
                                        {{ Str::limit($circular->description, 180) }}
                                    </p>
                                </div>

                                {{-- Deadline Info --}}
                                <div class="mt-4 sm:mt-0 sm:ml-6 text-left sm:text-right shrink-0">
                                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Deadline</p>
                                    <p class="text-2xl font-bold text-red-600">{{ $circular->last_date_of_submission->format('d') }}</p>
                                    <p class="text-sm text-gray-500 -mt-1">{{ $circular->last_date_of_submission->format('M, Y') }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="border-t border-gray-100 px-6 py-4 bg-gray-50/75">
                             <a href="{{ route('circulars.show', $circular) }}" class="flex items-center justify-between text-sm font-semibold text-primary-600 hover:text-primary-800 group">
                                <span>View Details & Apply</span>
                                <i class="fas fa-arrow-right transition-transform group-hover:translate-x-1"></i>
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="text-center bg-white p-12 rounded-xl shadow-soft border">
                        <i class="fas fa-box-open text-5xl text-gray-300"></i>
                        <p class="mt-4 text-gray-600 font-semibold text-lg">No Open Circulars Found</p>
                        <p class="mt-1 text-gray-500">There are currently no open job circulars. Please check back later.</p>
                    </div>
                @endforelse
            </div>

            {{-- Pagination Links --}}
            <div class="mt-8">
                {{ $circulars->links() }}
            </div>
        </div>
    </div>
@endsection
