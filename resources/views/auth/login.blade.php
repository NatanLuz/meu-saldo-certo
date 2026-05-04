@extends('layouts.auth-split')

@section('auth.header')
    <div class="mb-8 space-y-3">
        <h2 class="text-2xl font-semibold tracking-tight text-slate-900">Entrar na sua conta</h2>
        <p class="text-sm text-slate-600">Acesse seu painel e acompanhe seu fluxo financeiro.</p>
    </div>
@endsection

@section('content')
    <form method="POST" action="{{ route('login') }}" class="space-y-6" x-data="{ isLoading: false }" @submit="isLoading = true">
        @csrf

        {{-- Banner de Erro de Credenciais em vermelho/branco --}}
        @if ($errors->any() && !$errors->has('throttle'))
            <div class="flex gap-3 rounded-xl border border-red-200 bg-red-50 p-4">
                <svg class="h-5 w-5 text-red-600 flex-shrink-0 mt-0.5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"></circle>
                    <line x1="12" y1="8" x2="12" y2="12"></line>
                    <line x1="12" y1="16" x2="12.01" y2="16"></line>
                </svg>
                <div class="flex-1">
                    <h3 class="text-sm font-semibold text-red-900">Erro ao fazer login</h3>
                    <p class="mt-1 text-sm text-red-800">E-mail ou senha incorretos. Verifique suas credenciais e tente novamente.</p>
                </div>
            </div>
        @elseif ($errors->has('throttle'))
            <div class="flex gap-3 rounded-xl border border-orange-200 bg-orange-50 p-4">
                <svg class="h-5 w-5 text-orange-600 flex-shrink-0 mt-0.5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3.05h16.94a2 2 0 0 0 1.71-3.05L13.71 3.86a2 2 0 0 0-3.42 0z"></path>
                    <line x1="12" y1="9" x2="12" y2="13"></line>
                    <line x1="12" y1="17" x2="12.01" y2="17"></line>
                </svg>
                <div class="flex-1">
                    <h3 class="text-sm font-semibold text-orange-900">Muitas tentativas</h3>
                    <p class="mt-1 text-sm text-orange-800">{{ $errors->first('throttle') }}</p>
                </div>
            </div>
        @endif

        <div class="space-y-6">
            <div>
                <x-input-label for="email" :value="'E-mail'" />
                <div class="relative mt-1">
                    <input
                        id="email"
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        autofocus
                        autocomplete="username"
                        class="block w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-slate-900 shadow-sm transition-all duration-200 placeholder:text-slate-400 focus:border-green-600 focus:ring-2 focus:ring-green-500/30 focus:shadow-md {{ $errors->has('email') ? 'border-red-500 bg-red-50 focus:border-red-600 focus:ring-red-500/30' : '' }}"
                        placeholder="voce@exemplo.com"
                    >
                    @if ($errors->has('email'))
                        <svg class="absolute right-3 top-1/2 -translate-y-1/2 h-5 w-5 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="10"></circle>
                            <line x1="15" y1="9" x2="9" y2="15"></line>
                            <line x1="9" y1="9" x2="15" y2="15"></line>
                        </svg>
                    @endif
                </div>
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="password" :value="'Senha'" />

                <div class="relative mt-1">
                    <input
                        id="password"
                        x-bind:type="showPassword ? 'text' : 'password'"
                        name="password"
                        required
                        autocomplete="current-password"
                        class="block w-full rounded-xl border border-slate-300 bg-white px-4 py-3 pr-12 text-slate-900 shadow-sm transition-all duration-200 placeholder:text-slate-400 focus:border-green-600 focus:ring-2 focus:ring-green-500/30 focus:shadow-md {{ $errors->has('password') ? 'border-red-500 bg-red-50 focus:border-red-600 focus:ring-red-500/30' : '' }}"
                        placeholder="Digite sua senha"
                    >
                    <button
                        type="button"
                        class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 transition hover:text-slate-600 focus:outline-none disabled:opacity-60 disabled:cursor-not-allowed"
                        x-on:click="showPassword = !showPassword"
                        :disabled="isLoading"
                        x-bind:aria-label="showPassword ? 'Ocultar senha' : 'Mostrar senha'"
                        x-bind:aria-pressed="showPassword.toString()"
                        @if ($errors->has('password')) style="right: 40px;" @endif
                    >
                        <!-- Ícone de olho aberto -->
                        <svg x-show="!showPassword" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        <!-- Ícone de olho fechado quando coloca a senha -->
                        <svg x-show="showPassword" x-cloak class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-4.803m5.596-3.856a3.375 3.375 0 11-4.753 4.753m7.371-1.368A9.01 9.01 0 0123 12c-1.274-4.057-5.064-7-9.543-7-4.477 0-8.268 2.943-9.542 7M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </button>
                    @if ($errors->has('password'))
                        <svg class="absolute right-3 top-1/2 -translate-y-1/2 h-5 w-5 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="10"></circle>
                            <line x1="15" y1="9" x2="9" y2="15"></line>
                            <line x1="9" y1="9" x2="15" y2="15"></line>
                        </svg>
                    @endif
                </div>

                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <label for="remember_me" class="inline-flex items-center gap-3 text-sm text-slate-600">
                <input id="remember_me" type="checkbox" class="rounded border-slate-300 text-green-600 shadow-sm focus:ring-green-500" name="remember">
                <span>Lembrar de mim</span>
            </label>

            <button
                type="submit"
                :disabled="isLoading"
                class="inline-flex w-full items-center justify-center gap-2 rounded-xl bg-green-600 py-4 text-base font-semibold tracking-wide text-white shadow-lg shadow-green-600/30 transition duration-200 hover:bg-green-700 hover:shadow-xl hover:shadow-green-600/40 active:scale-95 focus:ring-2 focus:ring-green-500 focus:ring-offset-2 focus:ring-offset-white disabled:cursor-not-allowed disabled:opacity-70"
            >
                <span x-show="!isLoading">Entrar</span>
                <span x-show="isLoading" class="flex items-center gap-2">
                    <svg class="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Entrando...
                </span>
            </button>

            <div class="flex items-center gap-4 py-1">
                <div class="h-px flex-1 bg-slate-200"></div>
                <span class="text-xs font-semibold uppercase tracking-[0.3em] text-slate-400">ou</span>
                <div class="h-px flex-1 bg-slate-200"></div>
            </div>

            @if (Route::has('password.request'))
                <div class="text-center">
                    <a class="text-sm font-medium text-slate-600 transition hover:text-slate-900 hover:underline focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2" href="{{ route('password.request') }}">
                        Esqueceu sua senha?
                    </a>
                </div>
            @endif

            <div class="text-center text-sm text-slate-600">
                Não tem uma conta?
                <a href="{{ route('register') }}" class="font-semibold text-green-700 transition hover:text-green-800 hover:underline">
                    Criar conta
                </a>
            </div>
        </div>
    </form>
@endsection

