<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ setting('site_title', config('app.name', 'Laravel')) }}</title>

        <!-- Fonts, Icons, and Styles (copied from your main layout for consistency) -->
        <link rel="icon" href="{{ setting('site_favicon') ? Storage::url(setting('site_favicon')) : '/favicon.ico' }}" type="image/x-icon">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
        <script src="https://cdn.tailwindcss.com"></script>
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
        </style>
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
            {{-- Logo --}}
            <div>
                <a href="/" class="flex flex-col items-center">
                    @if(setting('site_logo'))
                        <img src="{{ Storage::url(setting('site_logo')) }}" alt="Site Logo" class="h-12 w-auto">
                    @else
                        <i class="fas fa-briefcase text-primary-500 text-4xl"></i>
                    @endif
                    <span class="mt-2 text-2xl font-bold text-gray-800">{{ setting('site_title', 'JobPortal') }}</span>
                </a>
            </div>

            {{-- Form Card --}}
            <div class="w-full sm:max-w-md mt-6 px-6 py-8 bg-white shadow-md overflow-hidden sm:rounded-lg">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
