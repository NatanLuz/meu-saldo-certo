<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

        <x-theme-script />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-gray-100 font-sans text-gray-800 antialiased transition-colors duration-200 dark:bg-slate-950 dark:text-slate-100">
        <div class="min-h-screen bg-gray-100 transition-colors duration-200 dark:bg-slate-950">
            @include('layouts.navigation')

            <!-- Cabeçalho -->
            @isset($header)
                <header class="border-b border-gray-200 bg-white shadow-sm transition-colors duration-200 dark:border-slate-700 dark:bg-slate-900">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Conteúdo -->
            <main>
                {{ $slot }}
            </main>
        </div>
    </body>
</html>
