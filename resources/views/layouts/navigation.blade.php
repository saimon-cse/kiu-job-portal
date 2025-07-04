<header class="flex items-center justify-between h-16 px-4 bg-white border-b border-gray-200 shrink-0">
    <div class="flex items-center">
        <button id="open-sidebar" class="md:hidden p-2 text-gray-500 hover:text-gray-700 rounded-lg">
            <i class="fas fa-bars"></i>
        </button>
    </div>
    <div class="flex items-center space-x-3">
        <button class="p-2 text-gray-500 hover:text-gray-700 rounded-full hover:bg-gray-100 relative">
            <i class="fas fa-bell"></i>
            <span class="absolute top-1 right-1 h-2 w-2 rounded-full bg-red-500"></span>
        </button>

        <!-- Profile Dropdown -->
        <div x-data="{ open: false }" class="relative">
            <button @click="open = !open" class="flex items-center focus:outline-none">
                <div class="relative">
                    <img class="w-8 h-8 rounded-full object-cover" src="{{ Auth::user()->profile_picture ? Storage::url(Auth::user()->profile_picture) : 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name) }}" alt="User">
                    <span class="absolute bottom-0 right-0 block h-2 w-2 rounded-full ring-2 ring-white bg-green-400"></span>
                </div>
                <span class="ml-2 text-sm font-medium hidden md:inline">{{ Auth::user()->name }}</span>
            </button>

            <div x-show="open"
                 @click.outside="open = false"
                 x-transition:enter="transition ease-out duration-100"
                 x-transition:enter-start="transform opacity-0 scale-95"
                 x-transition:enter-end="transform opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-75"
                 x-transition:leave-start="transform opacity-100 scale-100"
                 x-transition:leave-end="transform opacity-0 scale-95"
                 class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50 ring-1 ring-black ring-opacity-5"
                 x-cloak>
                <div class="px-4 py-2 text-xs text-gray-400">
                    Manage Account
                </div>
                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                    My Profile
                </a>

                <div class="border-t border-gray-100"></div>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <a href="{{ route('logout') }}"
                       onclick="event.preventDefault(); this.closest('form').submit();"
                       class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                        Log Out
                    </a>
                </form>
            </div>
        </div>
    </div>
</header>
