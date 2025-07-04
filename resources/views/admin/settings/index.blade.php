<x-app-layout>
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Site Settings</h1>
        <p class="text-gray-500">Manage your application's general settings from one place.</p>
    </div>

    {{-- Success & Error Messages --}}
    @if (session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
            <p class="font-bold">Success</p>
            <p>{{ session('success') }}</p>
        </div>
    @endif
    @if ($errors->any())
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
             <p class="font-bold">Please fix the following errors:</p>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>- {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{--
        Main container for the settings page, powered by Alpine.js.
        It holds the 'activeTab' state, which determines which settings group is visible.
        The initial active tab is set to the first group key from your settings collection.
    --}}
    <div x-data="{ activeTab: '{{ $settingsByGroup->keys()->first() ?? '' }}' }">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">

            {{-- 1. Settings Navigation Sidebar (Left Column) --}}
            <div class="md:col-span-1">
                <div class="bg-white p-4 rounded-xl shadow-soft">
                    <h3 class="text-lg font-semibold text-gray-700 mb-4">Setting Groups</h3>
                    <nav class="space-y-1">
                        @foreach ($settingsByGroup as $group => $settings)
                            <button type="button"
                                    @click="activeTab = '{{ $group }}'"
                                    :class="{
                                        'active-sidebar-item text-primary-600 font-semibold': activeTab === '{{ $group }}',
                                        'text-gray-600 hover:text-primary-600': activeTab !== '{{ $group }}'
                                    }"
                                    class="w-full text-left sidebar-item flex items-center px-3 py-2.5 text-sm font-medium rounded-md">

                                {{-- Dynamically add an icon based on group name for a nice touch --}}
                                @php
                                    $icon = 'fa-cog'; // Default icon
                                    if ($group === 'Site') $icon = 'fa-desktop';
                                    if ($group === 'Contact') $icon = 'fa-address-book';
                                    if ($group === 'Social') $icon = 'fa-share-alt';
                                    if ($group === 'Job Board') $icon = 'fa-briefcase';
                                    if ($group === 'SEO') $icon = 'fa-chart-line';
                                @endphp
                                <i class="fas {{ $icon }} mr-3 w-5 text-center"></i>
                                <span>{{ $group }}</span>
                            </button>
                        @endforeach
                    </nav>
                </div>
            </div>

            {{-- 2. Settings Content (Right Column) --}}
            <div class="md:col-span-3">
                <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    {{-- Loop through each group and create a content panel for it --}}
                    @foreach ($settingsByGroup as $group => $settings)
                        <div x-show="activeTab === '{{ $group }}'"
                             x-transition:enter="transition-all ease-out duration-300"
                             x-transition:enter-start="opacity-0 transform -translate-y-4"
                             x-transition:enter-end="opacity-100 transform translate-y-0"
                             x-cloak>
                            <div class="bg-white p-6 rounded-xl shadow-soft">
                                <div class="space-y-6">
                                    @foreach ($settings as $setting)
                                        <div>
                                            <label for="{{ $setting->key }}" class="block text-sm font-medium text-gray-700">{{ $setting->display_name }}</label>
                                            <div class="mt-1">
                                                @switch($setting->type)
                                                    @case('text')
                                                    @case('number')
                                                        <input type="{{ $setting->type }}" name="{{ $setting->key }}" id="{{ $setting->key }}" value="{{ old($setting->key, $setting->value) }}" class="block w-full md:w-1/2 px-3 py-2 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-500 sm:text-sm">
                                                        @break
                                                    @case('textarea')
                                                        <textarea name="{{ $setting->key }}" id="{{ $setting->key }}" rows="4" class="block w-full md:w-2/3 px-3 py-2 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-500 sm:text-sm">{{ old($setting->key, $setting->value) }}</textarea>
                                                        @break
                                                    @case('image')
                                                        <div>
                                                            @if ($setting->value)
                                                                <img src="{{ Storage::url($setting->value) }}" alt="{{ $setting->display_name }}" class="h-16 w-auto object-contain bg-gray-100 p-2 rounded-md mb-2">
                                                            @endif
                                                            <input type="file" name="{{ $setting->key }}" id="{{ $setting->key }}" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100">
                                                        </div>
                                                        @break
                                                    @case('checkbox')
                                                        <div class="flex items-center">
                                                            <input type="hidden" name="{{ $setting->key }}" value="0">
                                                            <input type="checkbox" name="{{ $setting->key }}" id="{{ $setting->key }}" value="1" @if(old($setting->key, $setting->value) == '1') checked @endif class="h-4 w-4 text-primary-600 border-gray-300 rounded focus:ring-primary-500">
                                                            <label for="{{ $setting->key }}" class="ml-2 block text-sm text-gray-900">Enable this feature</label>
                                                        </div>
                                                        @break
                                                @endswitch
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endforeach

                    <div class="pt-8 flex justify-end">
                        <button type="submit" class="bg-primary-600 hover:bg-primary-700 text-white py-2 px-6 rounded-lg text-sm font-medium shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                            Save All Settings
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
