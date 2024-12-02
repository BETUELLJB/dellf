<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use App\Services\LogService; // Importação do LogService

class ChatController extends Controller
{
    public function chatView()
    {
        return view('chat');
    }

    public function sendMessage(Request $request)
    {
        $message = $request->input('message');

        // Enviar a requisição para o backend Node.js
        try {
            $response = Http::post('http://localhost:3000/generate-text', [
                'prompt' => $message,
            ]);

            if ($response->successful()) {
                // Resposta bem-sucedida
                $geminiResponse = $response->json('text');

                // Registrar log de sucesso
                LogService::record([
                    'user_id' => auth()->id(),
                    'user_name' => auth()->user()->name ?? 'Anônimo',
                    'model' => 'Chat',
                    'action' => 'sendMessage',
                    'changes' => ['message' => $message],
                    'status' => 'success',
                    'message' => 'Mensagem enviada com sucesso ao backend Gemini.',
                    'ip_address' => $request->ip(),
                ]);
            } else {
                // Resposta com erro da API
                $geminiResponse = 'Erro ao gerar resposta. Tente novamente mais tarde.';

                // Registrar log de erro
                LogService::record([
                    'user_id' => auth()->id(),
                    'user_name' => auth()->user()->name ?? 'Anônimo',
                    'model' => 'Chat',
                    'action' => 'sendMessage',
                    'changes' => ['message' => $message],
                    'status' => 'error',
                    'message' => 'Erro ao comunicar com o backend Gemini: ' . $response->body(),
                    'ip_address' => $request->ip(),
                ]);
            }
        } catch (\Exception $e) {
            // Erro de conexão ou de rede
            $geminiResponse = 'Erro de conexão com o servidor. Verifique sua internet.';

            // Registrar log de erro
            LogService::record([
                'user_id' => auth()->id(),
                'user_name' => auth()->user()->name ?? 'Anônimo',
                'model' => 'Chat',
                'action' => 'sendMessage',
                'changes' => ['message' => $message],
                'status' => 'error',
                'message' => 'Erro de conexão: ' . $e->getMessage(),
                'ip_address' => $request->ip(),
            ]);
        }

        return view('chat', compact('message', 'geminiResponse'));
    }
}
