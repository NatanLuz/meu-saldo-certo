@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center border-b-2 border-green-500 px-1 pt-1 text-sm font-medium leading-5 text-gray-800 dark:text-gray-100 transition duration-150 ease-in-out focus:outline-none focus:border-green-600'
            : 'inline-flex items-center border-b-2 border-transparent px-1 pt-1 text-sm font-medium leading-5 text-gray-500 dark:text-slate-300 transition duration-150 ease-in-out hover:border-gray-300 dark:hover:border-slate-600 hover:text-gray-700 dark:hover:text-slate-100 focus:border-gray-300 dark:focus:border-slate-600 focus:text-gray-700 dark:focus:text-slate-100 focus:outline-none';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
