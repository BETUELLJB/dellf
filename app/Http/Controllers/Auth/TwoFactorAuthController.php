<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Mail;


class TwoFactorAuthController extends Controller
{
    /**
     * Show the two-factor authentication view.
     */
    public function show()
    {
        return view('auth.two-factor');
    }

   


    /**
     * Verify the two-factor code.
     */
    public function verify(Request $request)
    {
        $request->validate([
            'two_factor_code' => ['required', 'numeric'],
        ]);

        $user = User::find(session('auth.id'));

        if (!$user || $user->two_factor_code !== $request->two_factor_code || now()->greaterThan($user->two_factor_expires_at)) {
            return redirect()->route('auth.two-factor')->withErrors(['two_factor_code' => 'Código inválido ou expirado.']);
        }

        // Limpa o código 2FA após o uso
        $user->update([
            'two_factor_code' => null,
            'two_factor_expires_at' => null,
        ]);

        Auth::login($user);
        session()->forget('auth.id');

        return redirect()->intended(RouteServiceProvider::HOME);
    }
    public function resend(Request $request)
    {
        $userId = session('auth.id');

        if (!$userId) {
            return redirect()->route('login')->withErrors(['email' => 'Sessão expirada. Faça login novamente.']);
        }

        $user = User::find($userId);

        if (!$user) {
            return redirect()->route('login')->withErrors(['email' => 'Usuário não encontrado.']);
        }

        // Gera um novo código
        $user->two_factor_code = rand(100000, 999999);
        $user->two_factor_expires_at = now()->addMinutes(10);
        $user->save();

        // Envia o código por e-mail
        Mail::to($user->email)->send(new \App\Mail\TwoFactorCodeMail($user->two_factor_code));

        return back()->with('status', 'Código reenviado para o seu e-mail.');
    }
    
}
