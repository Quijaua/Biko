<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Throwable;

class GoogleLoginController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback(Request $request)
    {
        // O Google volta sem "code" quando a pessoa cancela a tela de permissão
        // (error=access_denied), ou quando alguém abre o endereço de retorno direto.
        // Antes isso virava erro 500 ("Missing required parameter: code").
        if ($request->filled('error') || ! $request->filled('code')) {
            return redirect()->route('login')->with('error', $request->input('error') === 'access_denied'
                ? 'O login com o Google foi cancelado.'
                : 'Não foi possível entrar com o Google. Tente novamente.');
        }

        try {
            // Sem stateless(): o Socialite confere o "state" guardado na sessão em redirectToGoogle(),
            // garantindo que o login foi iniciado neste navegador (evita login forjado via CSRF).
            $googleUser = Socialite::driver('google')->user();
        } catch (Throwable $e) {
            // "state" divergente ou sessão perdida, código expirado ou já usado
            // (página recarregada, botão "voltar"), Google fora do ar etc.
            Log::warning('Falha no retorno do login com Google', ['erro' => $e->getMessage()]);

            return redirect()->route('login')->with('error', 'Não foi possível entrar com o Google. Tente novamente.');
        }

        $email = Str::lower(trim((string) $googleUser->getEmail()));
        $user = $email !== '' ? User::where('email', $email)->first() : null;

        if (! $user) {
            return view('auth.not-found')->with('error', 'Conta não encontrada.');
        }

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('dashboard');
    }
}
