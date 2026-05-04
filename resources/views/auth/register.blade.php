@extends('layouts.auth-split')

@section('auth.header')
    <div class="mb-8 space-y-3">
        <h2 class="text-2xl font-semibold tracking-tight text-slate-900">Criar conta</h2>
        <p class="text-sm text-slate-600">Registre-se para começar a gerenciar suas finanças.</p>
    </div>
@endsection

@section('content')
    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <div>
            <x-input-label for="name" :value="'Nome'" />
            <x-text-input id="name" class="block mt-1 w-full rounded-xl" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="email" :value="'E-mail'" />
            <x-text-input id="email" class="block mt-1 w-full rounded-xl" type="email" name="email" :value="old('email')" required />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password" :value="'Senha'" />
            <x-text-input id="password" class="block mt-1 w-full rounded-xl" type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password_confirmation" :value="'Confirmar senha'" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full rounded-xl" type="password" name="password_confirmation" required />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="mt-4 flex items-center justify-end">
            <a class="text-sm text-slate-600 underline hover:text-slate-900" href="{{ route('login') }}">Já possui conta?</a>

            <x-primary-button class="ml-4">Cadastrar</x-primary-button>
        </div>
    </form>
@endsection
