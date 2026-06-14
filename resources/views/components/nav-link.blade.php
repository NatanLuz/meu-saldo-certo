@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center border-b-2 border-green-500 px-1 pt-1 text-sm font-semibold leading-5 text-gray-900 transition duration-150 ease-in-out focus:border-green-600 focus:outline-none dark:text-white'
            : 'inline-flex items-center border-b-2 border-transparent px-1 pt-1 text-sm font-semibold leading-5 text-gray-600 transition duration-150 ease-in-out hover:border-gray-300 hover:text-gray-900 focus:border-gray-300 focus:text-gray-900 focus:outline-none dark:text-slate-300 dark:hover:border-slate-600 dark:hover:text-white dark:focus:border-slate-600 dark:focus:text-white';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
