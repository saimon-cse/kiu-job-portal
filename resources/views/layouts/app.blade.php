<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ setting('site_title', config('app.name', 'Laravel')) }}</title>

    <!-- Site Favicon -->
    <link rel="icon" href="{{ setting('site_favicon') ? Storage::url(setting('site_favicon')) : '/favicon.ico' }}" type="image/x-icon">

    <!-- Fonts & Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- STYLES -->
    <!-- Tailwind CSS via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Your Custom Tailwind Config -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {'50':'#f0f9ff','100':'#e0f2fe','200':'#bae6fd','300':'#7dd3fc','400':'#38bdf8','500':'#0ea5e9','600':'#0284c7','700':'#0369a1','800':'#075985','900':'#0c4a6e'},
                    },
                    boxShadow: { 'soft': '0 4px 14px 0 rgba(0, 0, 0, 0.08)' }
                }
            }
        }
    </script>
    <!-- Custom Layout Styles -->
    <style>
        body { font-family: 'Inter', sans-serif; }
        [x-cloak] { display: none !important; } /* Style for Alpine.js to prevent flickering on load */
        .sidebar-item { transition: all 0.2s ease; border-left: 4px solid transparent; }
        .sidebar-item:hover { background-color: rgba(14, 165, 233, 0.05); transform: translateX(2px); }
        .active-sidebar-item { border-left-color: #0ea5e9; background-color: rgba(14, 165, 233, 0.08); }
    </style>
    @stack('styles')

    <!-- SCRIPTS -->
    <!-- Alpine.js (for UI interactivity) -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

<style>
     .sortable-item {
            transition: transform 0.2s cubic-bezier(0.2, 0, 0, 1);
        }

        /* --- ADD THIS NEW CLASS --- */
        /* This class will be applied to the placeholder item while dragging */
        .sortable-ghost {
            background-color: #e0f2fe; /* This is the hex code for primary-100 */
            opacity: 0.5;
        }
</style>


    <!-- SortableJS (for drag-and-drop) -->
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>

    <!-- SweetAlert2 (for beautiful pop-ups/modals) -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Chart.js (for data visualization) -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</head>
<body class="bg-gray-50 text-gray-800 antialiased" x-data="{}">
    <div class="flex h-screen overflow-hidden">
        <!-- Mobile Sidebar Overlay -->
        <div id="mobile-sidebar-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 md:hidden hidden"></div>

        <!-- Sidebar -->
        @include('layouts.sidebar')

        <!-- Main Content -->
        <div class="flex flex-col flex-1 overflow-hidden">
            <!-- Header -->
            @include('layouts.navigation')

            <!-- Main Content Area -->
            <main class="flex-1 overflow-y-auto p-4 md:p-6 bg-gray-50">
                {{-- @include('partials._session-messages')
                @include('partials._validation-errors') --}}
                @if (isset($slot) && $slot->isNotEmpty())
                    {{ $slot }}
                @elseif (View::hasSection('content'))
                @yield('content')

                @endif
                {{-- {{ $slot }} --}}

            </main>
        </div>
    </div>

    <!-- Sidebar Toggle JS (Plain JS, no dependencies) -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const openSidebarBtn = document.getElementById('open-sidebar');
            const closeSidebarBtn = document.getElementById('close-sidebar');
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('mobile-sidebar-overlay');

            if (openSidebarBtn) {
                openSidebarBtn.addEventListener('click', () => {
                    sidebar.classList.remove('-translate-x-full');
                    overlay.classList.remove('hidden');
                });
            }

            if (closeSidebarBtn) {
                closeSidebarBtn.addEventListener('click', () => {
                    sidebar.classList.add('-translate-x-full');
                    overlay.classList.add('hidden');
                });
            }

            if (overlay) {
                overlay.addEventListener('click', () => {
                    sidebar.classList.add('-translate-x-full');
                    overlay.classList.add('hidden');
                });
            }
        });
    </script>

    @stack('scripts')

</body>
</html>
