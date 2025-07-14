<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="description" content="{{ setting('seo_meta_description', 'Find your next career opportunity.') }}">

        <title>{{ setting('site_title', config('app.name', 'Laravel')) }}</title>

        <!-- Fonts, Icons, and Styles -->
        <link rel="icon" href="{{ setting('site_favicon') ? Storage::url(setting('site_favicon')) : '/favicon.ico' }}" type="image/x-icon">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

        <!-- Tailwind CSS via CDN -->
        <script src="https://cdn.tailwindcss.com"></script>

        <!-- Custom Tailwind Config -->
        <script>
            tailwind.config = {
                theme: {
                    extend: {
                        colors: {
                            primary: {'50':'#f0f9ff','100':'#e0f2fe','200':'#bae6fd','300':'#7dd3fc','400':'#38bdf8','500':'#0ea5e9','600':'#0284c7','700':'#0369a1','800':'#075985','900':'#0c4a6e'},
                        },
                    }
                }
            }
        </script>
        <style>
             body { font-family: 'Inter', sans-serif; }
             [x-cloak] { display: none !important; }
        </style>

        <!-- Alpine.js -->
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    </head>
    <body class="font-sans text-gray-900 antialiased bg-gray-50">
        <div class="min-h-screen flex flex-col">

            {{-- ======================== --}}
            {{--      PUBLIC NAVBAR       --}}
            {{-- ======================== --}}
            <header class="bg-white shadow-md sticky top-0 z-40" x-data="{ mobileMenuOpen: false }">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between items-center h-16">
                        <!-- Logo -->
                        <div class="flex-shrink-0">
                            <a href="/" class="flex items-center">
                                @if(setting('site_logo'))
                                    <img src="{{ Storage::url(setting('site_logo')) }}" alt="Site Logo" class="h-8 w-auto">
                                @else
                                    <i class="fas fa-briefcase text-primary-500 text-3xl"></i>
                                @endif
                                <span class="ml-3 text-xl font-bold text-gray-800 hidden sm:block">{{ setting('site_title', 'JobPortal') }}</span>
                            </a>
                        </div>

                        <!-- Desktop Navigation -->
                        <nav class="hidden md:flex md:space-x-8">
                            <a href="{{ route('circulars.index') }}" class="font-medium text-gray-500 hover:text-primary-600">Available Jobs</a>
                            {{-- Add other public links like 'About Us' or 'Contact' here --}}
                        </nav>

                        <!-- Auth Links -->
                        <div class="hidden md:flex items-center space-x-4">
                            @auth
                                <a href="{{ route('dashboard') }}" class="text-sm font-medium text-white bg-primary-600 hover:bg-primary-700 px-4 py-2 rounded-lg">Dashboard</a>
                            @else
                                <a href="{{ route('login') }}" class="text-sm font-medium text-gray-600 hover:text-primary-600">Log in</a>
                                <a href="{{ route('register') }}" class="text-sm font-medium text-white bg-primary-600 hover:bg-primary-700 px-4 py-2 rounded-lg">Register</a>
                            @endauth
                        </div>

                        <!-- Mobile Menu Button -->
                        <div class="md:hidden">
                            <button @click="mobileMenuOpen = !mobileMenuOpen" class="p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100">
                                <i class="fas" :class="{ 'fa-times': mobileMenuOpen, 'fa-bars': !mobileMenuOpen }"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Mobile Menu -->
                <div x-show="mobileMenuOpen" x-transition class="md:hidden" x-cloak>
                    <div class="pt-2 pb-3 space-y-1 px-2">
                        <a href="{{ route('circulars.index') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">Available Jobs</a>
                    </div>
                    <div class="pt-4 pb-3 border-t border-gray-200">
                        <div class="px-2 space-y-1">
                            @auth
                                <a href="{{ route('dashboard') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">Dashboard</a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">Log Out</a>
                                </form>
                            @else
                                <a href="{{ route('login') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">Log in</a>
                                <a href="{{ route('register') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">Register</a>
                            @endauth
                        </div>
                    </div>
                </div>
            </header>

            {{-- ======================== --}}
            {{--     MAIN PAGE CONTENT    --}}
            {{-- ======================== --}}
            <main class="flex-grow">
                {{-- {{ $slot }} --}}
                 @yield('content')
            </main>

            {{-- ======================== --}}
            {{--          FOOTER          --}}
            {{-- ======================== --}}
            <footer class="bg-white border-t">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 text-center text-sm text-gray-500">
                    <p>{{ setting('footer_text', '© ' . date('Y') . ' ' . config('app.name') . '. All Rights Reserved.') }}</p>
                </div>
            </footer>
        </div>
    </body>
</html>
