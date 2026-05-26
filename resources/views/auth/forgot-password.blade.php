@extends('layouts.auth-split')

@section('auth.header')
    <div class="mb-4 text-sm text-slate-600">
        Esqueceu sua senha? Sem problema. Informe seu e-mail e enviaremos um link para redefinição de senha.
    </div>
@endsection

@section('content')
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
        @csrf

        <div>
            <x-input-label for="email" :value="'E-mail'" />
            <x-text-input id="email" class="block mt-1 w-full rounded-xl" type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>Enviar link de redefinição</x-primary-button>
        </div>
    </form>
@endsection
