@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center border-b-2 border-green-500 px-1 pt-1 text-sm font-semibold leading-5 transition duration-150 ease-in-out focus:outline-none focus:border-green-600'
            : 'inline-flex items-center border-b-2 border-transparent px-1 pt-1 text-sm font-semibold leading-5 transition duration-150 ease-in-out hover:border-gray-300 focus:border-gray-300 focus:outline-none';
@endphp

<a {{ $attributes->merge(['class' => $classes, 'style' => 'color:#000 !important;']) }}>
    {{ $slot }}
</a>
