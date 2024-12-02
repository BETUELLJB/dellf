<?php
namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Exception;

class GeminiService
{
    protected $client;
    protected $baseUrl;
    protected $apiKey;

    public function __construct()
    {
        $this->client = new Client();
        // URL corrigida da API
        $this->baseUrl = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash-latest:generateContent';
        // A chave da API será passada como parâmetro na URL
        $this->apiKey = env('GEMINI_API_KEY');  // Carregue a chave da API do .env
    }

    /**
     * Envia uma mensagem para a API Gemini e obtém a resposta.
     *
     * @param string $message Mensagem do usuário a ser enviada para a API
     * @param array $generationConfig Configuração opcional para geração de texto
     * @return string Resposta da API ou mensagem de erro amigável
     */
    public function sendMessage(string $message, array $generationConfig = []): string
    {
        $defaultConfig = [
            'contents' => [
                [
                    'parts' => [
                        ['text' => $message], // A mensagem a ser enviada
                    ]
                ]
            ]
        ];

        try {
            // Log para depuração
            \Log::info('Requisição: ' . $this->baseUrl);

            // Fazendo a requisição POST com a chave API na URL
            $response = $this->client->post("{$this->baseUrl}?key={$this->apiKey}", [
                'headers' => [
                    'Content-Type' => 'application/json',
                ],
                'json' => $defaultConfig,
            ]);

            $body = json_decode($response->getBody(), true);

            // Verifica se a resposta contém o campo 'contents'
            if (isset($body['contents'][0]['parts'][0]['text'])) {
                return $body['contents'][0]['parts'][0]['text'];  // Retorna o texto gerado
            }

            return 'Resposta inesperada da API Gemini.';
        } catch (RequestException $e) {
            $statusCode = $e->getResponse() ? $e->getResponse()->getStatusCode() : null;
            return "Erro na API Gemini (Código {$statusCode}): " . $e->getMessage();
        } catch (Exception $e) {
            return 'Erro ao se comunicar com a API Gemini: ' . $e->getMessage();
        }
    }
}
