@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block w-full border-l-4 border-green-500 bg-green-50 dark:bg-green-900/30 py-2 ps-3 pe-4 text-start text-base font-medium text-green-700 dark:text-green-300 transition duration-150 ease-in-out focus:border-green-600 focus:bg-green-100 dark:focus:bg-green-900/40 focus:text-green-800 dark:focus:text-green-200 focus:outline-none'
            : 'block w-full border-l-4 border-transparent py-2 ps-3 pe-4 text-start text-base font-medium text-gray-600 dark:text-gray-300 transition duration-150 ease-in-out hover:border-gray-300 dark:hover:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-800 hover:text-gray-800 dark:hover:text-gray-100 focus:border-gray-300 dark:focus:border-gray-700 focus:bg-gray-50 dark:focus:bg-gray-800 focus:text-gray-800 dark:focus:text-gray-100 focus:outline-none';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
