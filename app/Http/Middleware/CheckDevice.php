<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB;

class CheckDevice
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();

        // Recuperar identificadores do dispositivo
        $deviceIdentifier = $request->header('X-Device-Identifier'); // Hostname
        $macAddress = $request->header('X-Mac-Address'); // MAC Address

        if (!$deviceIdentifier || !$macAddress) {
            return response()->json([
                'error' => 'Informações do dispositivo incompletas.'
            ], 403);
        }

        // Verificar o dispositivo no banco de dados
        $device = DB::table('devices')->where([
            ['user_id', '=', $user->id],
            ['device_identifier', '=', $deviceIdentifier],
            ['mac_address', '=', $macAddress]
        ])->first();

        if (!$device) {
            return response()->json([
                'error' => 'Dispositivo não autorizado.'
            ], 403);
        }

        return $next($request);
    }
}
