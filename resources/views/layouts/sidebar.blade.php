<div id="sidebar"
    class="fixed inset-y-0 left-0 transform -translate-x-full md:relative md:translate-x-0 z-50 md:z-auto md:flex md:flex-shrink-0 w-64 bg-white border-r border-gray-200 transition-transform duration-300 ease-in-out">
    <div class="flex flex-col h-full">
        <!-- Logo/Brand -->
        <div class="flex items-center justify-between h-16 px-4 border-b border-gray-200">
            <a href="{{ route('dashboard') }}" class="flex items-center">
                @if (setting('site_logo'))
                    <img src="{{ Storage::url(setting('site_logo')) }}" alt="Site Logo" class="h-8 w-auto mr-2">
                @else
                    <i class="fas fa-briefcase text-primary-500 text-2xl mr-2"></i>
                @endif
                <span class="text-xl font-bold text-gray-800">{{ setting('site_title', 'JobPortal') }}</span>
            </a>
            <button id="close-sidebar" class="md:hidden p-2 text-gray-500 hover:text-gray-700">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <!-- User Profile -->
        <div class="px-4 py-3 flex items-center space-x-3 border-b border-gray-200">
            <div class="relative">
                <img class="w-10 h-10 rounded-full object-cover"
                    src="{{ Auth::user()->profile_picture ? Storage::url(Auth::user()->profile_picture) : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) }}"
                    alt="User profile">
                <span
                    class="absolute bottom-0 right-0 block h-2.5 w-2.5 rounded-full ring-2 ring-white bg-green-400"></span>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-800">{{ Auth::user()->name }}</p>
                <p class="text-xs text-gray-500">{{ Auth::user()->email }}</p>
            </div>
        </div>

        <!-- Navigation -->
        <div class="flex-1 px-3 py-4 overflow-y-auto">
            <nav class="space-y-1">
                {{-- === Main Navigation === --}}
                <x-sidebar-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                    <i class="fas fa-tachometer-alt mr-3 w-5 text-center"></i>
                    Dashboard
                </x-sidebar-link>

                {{-- Link to the Profile Management Area --}}
                <x-sidebar-link :href="route('profile.edit')" :active="request()->is('profile*') ||
                    request()->is('education*') ||
                    request()->is('experience*') ||
                    request()->is('training*') ||
                    request()->is('language*') ||
                    request()->is('referee*') ||
                    request()->is('document*')">
                    <i class="fas fa-user-edit mr-3 w-5 text-center"></i>
                    Manage My Profile
                </x-sidebar-link>


                <x-sidebar-link :href="route('profile.preview')" :active="request()->routeIs('profile.preview')">
                    <i class="fas fa-eye mr-3 w-5 text-center"></i>
                    Preview My Profile
                </x-sidebar-link>

                <x-sidebar-link :href="route('profile.settings')" :active="request()->routeIs('profile.settings')">
                    <i class="fas fa-cog mr-3 w-5 text-center"></i>
                    Account Settings
                </x-sidebar-link>

                {{-- ============================================= --}}
                {{-- START: ADMIN SECTION WITH DROPDOWNS           --}}
                {{-- ============================================= --}}

                {{-- === Admin Panel Section === --}}
                @if (auth()->user()->can('access admin panel'))
                    <div class="pt-4 mt-4 border-t border-gray-200">
                        <p class="px-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Admin Panel</p>

                        {{-- Access Control Dropdown --}}
                        @canany(['manage-users', 'manage-roles'])
                            <x-sidebar-dropdown title="Access Control" icon="fas fa-user-shield" :active="request()->routeIs('admin.users.*') || request()->routeIs('admin.roles.*')">

                                @can('manage-users')
                                    <x-sidebar-link :href="route('admin.users.index')" :active="request()->routeIs('admin.users.*')">
                                        Users
                                    </x-sidebar-link>
                                @endcan

                                @can('manage-roles')
                                    <x-sidebar-link :href="route('admin.roles.index')" :active="request()->routeIs('admin.roles.*')">
                                        Roles & Permissions
                                    </x-sidebar-link>
                                @endcan

                            </x-sidebar-dropdown>
                        @endcanany

                        {{-- Site Management Dropdown --}}
                        @canany(['manage-settings'])
                            {{-- <x-sidebar-dropdown title="Site Management" icon="fas fa-cogs" :active="request()->routeIs('admin.settings.*')"> --}}

                            @can('manage-settings')
                                <x-sidebar-link :href="route('admin.settings.index')" :active="request()->routeIs('admin.settings.*')">
                                    <i class="fas fa-cog mr-3 w-5 text-center"></i>
                                    Site Settings
                                </x-sidebar-link>
                            @endcan

                            {{-- </x-sidebar-dropdown> --}}
                        @endcanany

                    </div>
                @endif
                {{-- =========================================== --}}
                {{-- END: ADMIN SECTION                      --}}
                {{-- =========================================== --}}

                <div class="pt-4 mt-4 border-t border-gray-200">
                    <!-- Logout -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-sidebar-link :href="route('logout')"
                            onclick="event.preventDefault(); this.closest('form').submit();">
                            <i class="fas fa-sign-out-alt mr-3 w-5 text-center"></i>
                            {{ __('Log Out') }}
                        </x-sidebar-link>
                    </form>
                </div>
            </nav>
        </div>
    </div>
</div>
