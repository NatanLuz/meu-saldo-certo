<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class PasswordResetLinkController extends Controller
{
    /**
    * Exibe a tela de solicitacao de link para redefinicao de senha.
     */
    public function create(): View
    {
        return view('auth.forgot-password');
    }

    /**
        * Processa uma requisicao de link de redefinicao de senha recebida.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        // Envia o link de redefinicao de senha para este usuario. Depois da
        // tentativa de envio, analisa a resposta para definir a mensagem
        // que deve ser exibida e retorna a resposta adequada.
        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status == Password::RESET_LINK_SENT
                    ? back()->with('status', __($status))
                    : back()->withInput($request->only('email'))
                        ->withErrors(['email' => __($status)]);
    }
}
