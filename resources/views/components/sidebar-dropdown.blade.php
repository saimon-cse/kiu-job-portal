@props(['title', 'icon', 'active' => false])

<div x-data="{ open: @js($active) }">
    {{-- Dropdown Trigger Button --}}
    <button @click="open = !open"
            class="sidebar-item flex items-center justify-between w-full px-3 py-2.5 text-sm font-medium rounded-md
                   {{ $active ? 'active-sidebar-item text-primary-600' : 'text-gray-600 hover:text-primary-600' }}">

        <div class="flex items-center">
            <i class="{{ $icon }} mr-3 w-5 text-center"></i>
            <span>{{ $title }}</span>
        </div>

        {{-- Arrow Icon --}}
        <i class="fas fa-chevron-down transform transition-transform duration-200"
           :class="{ 'rotate-180': open }"></i>
    </button>

    {{-- Dropdown Content --}}
    <div x-show="open"
         x-transition:enter="transition-all ease-in-out duration-300"
         x-transition:enter-start="opacity-0 max-h-0"
         x-transition:enter-end="opacity-100 max-h-screen"
         x-transition:leave="transition-all ease-in-out duration-200"
         x-transition:leave-start="opacity-100 max-h-screen"
         x-transition:leave-end="opacity-0 max-h-0"
         class="mt-1 space-y-1 overflow-hidden"
         x-cloak>
        <div class="pl-5 border-l-2 border-gray-200 ml-5">
            {{ $slot }}
        </div>
    </div>
</div>
