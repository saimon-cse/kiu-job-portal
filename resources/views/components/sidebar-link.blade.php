@props(['active'])

@php
$classes = ($active ?? false)
            ? 'sidebar-item active-sidebar-item flex items-center px-3 py-2.5 text-sm font-medium rounded-md text-primary-600'
            : 'sidebar-item flex items-center px-3 py-2.5 text-sm font-medium rounded-md text-gray-600 hover:text-primary-600';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
