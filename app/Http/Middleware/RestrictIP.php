<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RestrictIP
{
    /**
     * Lista de IPs autorizados.
     */
    private $allowedIPs = [
        '127.0.0.1', // Localhost
        '192.168.1.100', // Exemplo de IP estático autorizado
    ];

    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $userIP = $request->ip(); // Obtém o IP do cliente

        if (!in_array($userIP, $this->allowedIPs)) {
            // Registra tentativa de acesso
            \Log::warning("Acesso negado para IP não autorizado: $userIP");

            // Bloqueia o acesso com mensagem
            return response()->json(['error' => 'Acesso negado: IP não autorizado'], 403);
        }

        return $next($request); // Permite o acesso se o IP for autorizado
    }
}