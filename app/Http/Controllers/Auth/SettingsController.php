<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index()
    {
        return view('auth.settings');
    }

    public function toggleTwoFactor(Request $request)
    {
        $user = $request->user();

        $user->two_factor_enabled = !$user->two_factor_enabled;
        $user->two_factor_code = null;
        $user->two_factor_expires_at = null;
        $user->save();

        $status = $user->two_factor_enabled ? 'ativada' : 'desativada';
        return redirect()->route('settings.index')->with('status', "Autenticação em dois fatores foi {$status}.");
    }
}

