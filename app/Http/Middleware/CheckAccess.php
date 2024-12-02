<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\LogService; // Importação do LogService

class CheckAccess
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // Verificar se o usuário está autenticado
        if (!Auth::check()) {
            // Registrar tentativa de acesso não autenticado
            LogService::record([
                'user_id' => null, // Usuário não autenticado
                'user_name' => 'Visitante',
                'model' => 'Middleware',
                'action' => 'unauthorized_access',
                'status' => 'error',
                'message' => 'Tentativa de acesso não autenticada.',
                'ip_address' => $request->ip(),
            ]);

            return redirect()->route('login')->with('error', 'Usuarios não autenticado');
        }

        // Obter o nível de acesso do usuário autenticado
        $userRole = Auth::user()->nivel_acesso;

        // Verificar se o nível de acesso está permitido
        if (!in_array($userRole, $roles)) {
            // Registrar tentativa de acesso negado
            LogService::record([
                'user_id' => Auth::id(),
                'user_name' => Auth::user()->name ?? 'Usuário Desconhecido',
                'model' => 'Middleware',
                'action' => 'access_denied',
                'status' => 'error',
                'message' => "Tentativa de acesso negado para a rota: {$request->path()}.",
                'ip_address' => $request->ip(),
            ]);

            return redirect()->route('dashboard')->with('error', 'Acesso não autorizado!');
        }

        // Passar para o próximo middleware ou controlador
        return $next($request);
    }
}
