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

            <!-- No theme script on guest pages (always light) -->

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-slate-900 antialiased">
        <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-slate-100 via-white to-slate-200 px-4 py-10 transition-colors duration-200">
            <div class="w-full max-w-md rounded-2xl border border-slate-200 bg-white/95 p-8 shadow-2xl shadow-slate-200/60 backdrop-blur transition-colors duration-200">
                <div class="mb-8 text-center">
                    <a href="/" class="inline-flex items-center justify-center">
                        <x-application-logo class="h-16 w-16" />
                    </a>

                    <h1 class="mt-5 text-3xl font-extrabold tracking-tight text-slate-900">
                            <span class="font-normal">Meu</span> <span class="font-semibold text-green-600">Saldo Certo</span>
                    </h1>
                    <p class="mt-2 text-sm text-slate-500">Controle financeiro</p>
                </div>

                {{ $slot }}
            </div>
        </div>
    </body>
</html>
