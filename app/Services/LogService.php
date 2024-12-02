<?php

namespace App\Services;

use App\Models\Log;
use Illuminate\Support\Facades\Auth;

class LogService
{
    public static function record(array $data)
    {
        Log::create([
            'user_id' => $data['user_id'] ?? Auth::id(),
            'user_name' => $data['user_name'] ?? Auth::user()->name ?? 'Sistema',
            'model' => $data['model'] ?? null,
            'model_id' => $data['model_id'] ?? null,
            'action' => $data['action'] ?? 'undefined',
            'changes' => $data['changes'] ?? [],
            'status' => $data['status'] ?? 'info',
            'message' => $data['message'] ?? 'Nenhuma mensagem fornecida.',
            'ip_address' => $data['ip_address'] ?? request()->ip(),
        ]);
    }
}

