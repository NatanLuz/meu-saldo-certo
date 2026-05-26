@extends('layouts.auth-split')

@section('auth.header')
    <div class="mb-4 text-sm text-slate-600">Obrigado por se cadastrar. Antes de começar, confirme seu e-mail clicando no link que enviamos. Se não recebeu, podemos reenviar.</div>
@endsection

@section('content')
    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 text-sm font-medium text-green-600">Um novo link de verificação foi enviado para o e-mail informado no cadastro.</div>
    @endif

    <div class="mt-4 flex items-center justify-between">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf

            <div>
                <x-primary-button>Reenviar e-mail de verificação</x-primary-button>
            </div>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button type="submit" class="text-sm text-slate-600 underline hover:text-slate-900">Sair</button>
        </form>
    </div>
@endsection
