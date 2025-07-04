<header class="flex items-center justify-between h-16 px-4 bg-white border-b border-gray-200 shrink-0">
    <div class="flex items-center">
        <button id="open-sidebar" class="md:hidden p-2 text-gray-500 hover:text-gray-700 rounded-lg">
            <i class="fas fa-bars"></i>
        </button>
        <!-- You can add a dynamic page title here if you want -->
    </div>
    <div class="flex items-center space-x-3">
        <button class="p-2 text-gray-500 hover:text-gray-700 rounded-full hover:bg-gray-100 relative">
            <i class="fas fa-bell"></i>
            <span class="absolute top-1 right-1 h-2 w-2 rounded-full bg-red-500"></span>
        </button>

        <div class="flex items-center ml-2">
            <div class="relative">
                <img class="w-8 h-8 rounded-full object-cover" src="{{ Auth::user()->profile_picture ?? 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name) }}" alt="User">
                <span class="absolute bottom-0 right-0 block h-2 w-2 rounded-full ring-2 ring-white bg-green-400"></span>
            </div>
            <span class="ml-2 text-sm font-medium hidden md:inline">{{ Auth::user()->name }}</span>
        </div>
    </div>
</header>
