@extends('layouts.auth-split')

@section('auth.header')
    <div class="mb-4 text-sm text-slate-600">Esta é uma área segura da aplicação. Confirme sua senha para continuar.</div>
@endsection

@section('content')
    <form method="POST" action="{{ route('password.confirm') }}" class="space-y-4">
        @csrf

        <div>
            <x-input-label for="password" :value="'Senha'" />
            <x-text-input id="password" class="block mt-1 w-full rounded-xl" type="password" name="password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex justify-end mt-4">
            <x-primary-button>Confirmar</x-primary-button>
        </div>
    </form>
@endsection
