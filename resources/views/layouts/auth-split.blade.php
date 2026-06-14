<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Meu Saldo Certo') }}</title>

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

        <!-- No theme script on auth pages (always light) -->

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-slate-100 font-sans text-slate-900 antialiased transition-colors duration-200">
        <div class="min-h-screen lg:flex">
            <aside class="relative hidden items-center justify-center overflow-hidden bg-gradient-to-br from-green-600 via-green-500 to-green-400 px-8 py-10 text-white lg:flex lg:w-1/2 xl:px-10 xl:py-16">
                <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,rgba(255,255,255,0.15),transparent_40%),radial-gradient(circle_at_bottom_left,rgba(0,0,0,0.08),transparent_35%)]"></div>
                <div class="relative z-10 mx-auto flex w-full max-w-md flex-col items-center gap-8 text-center xl:gap-12">
                    <div class="group flex aspect-square w-full max-w-[320px] items-center justify-center rounded-full bg-white/95 p-8 shadow-2xl shadow-green-950/30 ring-1 ring-white/50 transition-all duration-300 hover:shadow-2xl hover:shadow-green-950/40 xl:max-w-[420px] xl:p-10">
                        <img src="{{ asset('img/logo.png') }}" alt="{{ config('app.name', 'Meu Saldo Certo') }}" class="h-26 w-26 object-contain drop-shadow-sm transition-transform duration-300 group-hover:scale-90" />
                    </div>

                    <div class="space-y-5 xl:space-y-8">
                        <p class="text-xl font-medium leading-relaxed text-white">
                            Gerencie suas finanças com facilidade
                        </p>
                        <p class="text-sm font-semibold uppercase tracking-widest text-white/70">
                            Simples • Rápido • Seguro
                        </p>
                    </div>

                    <div class="grid w-full gap-4 text-sm sm:grid-cols-2">
                        <div class="rounded-2xl border border-white/20 bg-white/10 px-6 py-5 backdrop-blur-sm transition duration-200 hover:bg-white/20">
                            <p class="leading-relaxed text-white/90">Controle suas entradas e saídas em um só lugar.</p>
                        </div>
                        <div class="rounded-2xl border border-white/20 bg-white/10 px-6 py-5 backdrop-blur-sm transition duration-200 hover:bg-white/20">
                            <p class="leading-relaxed text-white/90">Visual limpo, fluxos claros e foco em produtividade.</p>
                        </div>
                    </div>
                </div>
            </aside>

            <main class="flex w-full items-center justify-center bg-slate-50 px-4 py-6 transition-colors duration-200 sm:px-6 sm:py-10 lg:w-1/2 lg:px-8">
                <div class="mx-auto w-full max-w-md" x-data="{ showPassword: false }">
                    <!-- theme toggle removed from auth UI to keep auth pages always light -->

                    <div class="mb-6 text-center lg:hidden">
                        <div class="mx-auto">
                            <img src="{{ asset('img/logo.png') }}" alt="{{ config('app.name', 'Meu Saldo Certo') }}" class="h-12 w-auto object-contain" />
                        </div>
                        <p class="mt-2 text-sm text-slate-500">Gerencie suas finanças com facilidade</p>
                    </div>

                    <div class="rounded-3xl border border-slate-200/50 bg-white p-6 shadow-2xl shadow-slate-200/30 transition-colors duration-200 sm:p-8 xl:p-11">
                        {{-- header section (title/subtitle) --}}
                        @hasSection('auth.header')
                            @yield('auth.header')
                        @else
                            <div class="mb-8 space-y-3">
                                <h2 class="text-2xl font-semibold tracking-tight text-slate-900">Acessar sua conta</h2>
                                <p class="text-sm text-slate-600">Entre para acessar seu painel.</p>
                            </div>
                        @endif

                        <x-auth-session-status class="mb-4" :status="session('status')" />

                        @yield('content')
                    </div>
                </div>
            </main>
        </div>
    </body>
</html>
