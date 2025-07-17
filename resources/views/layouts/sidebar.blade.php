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
        {{-- <div class="px-4 py-3 flex items-center space-x-3 border-b border-gray-200">
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
        </div> --}}

        <!-- Navigation -->
        <div class="flex-1 px-3 py-4 overflow-y-auto">
            <nav class="space-y-1">

                {{-- ======================== --}}
                {{--      USER MENU           --}}
                {{-- ======================== --}}
                <p class="px-3 pt-2 text-xs font-semibold text-gray-500 uppercase tracking-wider">User Menu</p>

                <x-sidebar-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                    <i class="fas fa-tachometer-alt mr-3 w-5 text-center"></i>
                    Dashboard
                </x-sidebar-link>

                  {{-- This link now correctly checks for all related profile management routes --}}
                <x-sidebar-link :href="route('profile.edit')" :active="request()->is('profile*') ||
                    request()->is('education*') ||
                    request()->is('experience*') ||
                    request()->is('training*') ||
                    request()->is('language*') ||
                    request()->is('publication*') ||
                    request()->is('award*') ||
                    request()->is('referee*') ||
                    request()->is('document*') ||
                    request()->is('images*') ||
                    request()->is('settings*')">
                    <i class="fas fa-user-edit mr-3 w-5 text-center"></i>
                    Manage Profile
                </x-sidebar-link>


                <x-sidebar-link :href="route('profile.preview')" :active="request()->routeIs('profile.preview')">
                    <i class="fas fa-eye mr-3 w-5 text-center"></i>
                    Preview Profile
                </x-sidebar-link>

                <x-sidebar-link :href="route('circulars.index')" :active="request()->routeIs('circulars.*')">
                    <i class="fas fa-search mr-3 w-5 text-center"></i>
                    Available Jobs
                </x-sidebar-link>

                <x-sidebar-link :href="route('applications.history.index')" :active="request()->routeIs('applications.history.index')">
                    <i class="fas fa-file-alt mr-3 w-5 text-center"></i>
                    Application History
                </x-sidebar-link>



                {{-- <x-sidebar-link :href="route('profile.settings')" :active="request()->routeIs('profile.settings')">
                    <i class="fas fa-cog mr-3 w-5 text-center"></i>
                    Account Settings
                </x-sidebar-link> --}}


                {{-- ======================== --}}
                {{--      ADMIN PANEL         --}}
                {{-- ======================== --}}
                @if (auth()->user()->can('access admin panel'))
                    <div class="pt-4 mt-4 border-t border-gray-200">
                        <p class="px-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Admin Panel</p>

                        {{-- Job Management Dropdown --}}
                        @canany(['manage-circulars'])
                            <x-sidebar-dropdown title="Job Management" icon="fas fa-briefcase" :active="request()->routeIs('admin.circulars.*') ||
                                request()->routeIs('admin.jobs.*') ||
                                request()->routeIs('admin.applications.*')">
                                <x-sidebar-link :href="route('admin.circulars.index')" :active="request()->routeIs('admin.circulars.*') ||
                                    request()->routeIs('admin.jobs.*') ||
                                    request()->routeIs('admin.applications.*')">
                                    Circulars & Apps
                                </x-sidebar-link>
                            </x-sidebar-dropdown>
                        @endcanany

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
                        @canany(['manage-settings', 'manage-publication-types'])
                            <x-sidebar-dropdown title="Site Management" icon="fas fa-cogs" :active="request()->routeIs('admin.settings.*') ||
                                request()->routeIs('admin.publication-types.*')">
                                @can('manage-settings')
                                    <x-sidebar-link :href="route('admin.settings.index')" :active="request()->routeIs('admin.settings.*')">
                                        Site Settings
                                    </x-sidebar-link>
                                @endcan
                                @can('manage-publication-types')
                                    <x-sidebar-link :href="route('admin.publication-types.index')" :active="request()->routeIs('admin.publication-types.*')">
                                        Publication Types
                                    </x-sidebar-link>
                                @endcan
                            </x-sidebar-dropdown>
                        @endcanany

                    </div>
                @endif

                {{-- ======================== --}}
                {{--      ACCOUNT ACTIONS     --}}
                {{-- ======================== --}}
                <div class="pt-4 mt-4 border-t border-gray-200">
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
