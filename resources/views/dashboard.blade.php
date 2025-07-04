<x-app-layout>
    {{-- Page-specific content goes here --}}

    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Welcome back, {{ Auth::user()->name }}</h1>
        <p class="text-gray-500">Here's your job search at a glance</p>
    </div>

    <!-- All your dashboard cards and content from the original template would go here -->
    <div class="bg-white p-6 rounded-xl shadow-soft">
        <p>Dashboard content lives here.</p>
    </div>

</x-app-layout>
