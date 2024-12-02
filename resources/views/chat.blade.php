@extends('layouts.app')

@section('title', 'Chat')

@section('header')
<h1>Chat com Gemini</h1>
@endsection

@section('content')

<div class="container" style="padding-bottom: 80px;">
    <h2>Converse com o Chatbot</h2>

    <!-- Exibição de mensagens de sucesso -->
    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    <!-- Exibição de mensagens de erro -->
    @if (isset($geminiResponse) && strpos($geminiResponse, 'Erro') !== false)
    <div class="alert alert-danger">
        <strong>Erro:</strong> {{ $geminiResponse }}
    </div>
    @endif

    <!-- Exibição das mensagens -->
    <div id="messages" class="mb-4" style="height: 400px; overflow-y: auto;">
        <!-- Aqui vamos iterar para exibir as interações anteriores -->
        @if (isset($message) && isset($geminiResponse) && strpos($geminiResponse, 'Erro') === false)
        <div class="bg-light p-4 mt-2 rounded-lg shadow-sm">
            <h4 class="font-semibold">Última interação:</h4>
            <div class="mt-2">
                <p><strong>Você:</strong> {{ $message }}</p>
                <p><strong>Gemini:</strong> {{ $geminiResponse }}</p>
            </div>
        </div>
        @elseif (!isset($geminiResponse))
        <p class="text-muted mt-4">Nenhuma interação ainda.</p>
        @endif
    </div>

</div>

<!-- Rodapé com o formulário de envio -->
<div class="fixed-bottom bg-white p-3 shadow" style="z-index: 1050;">
    <form action="{{ route('chat.send') }}" method="POST" class="d-flex align-items-center">
        @csrf
        <!-- Campo de mensagem -->
        <div class="mr-2" style="flex-grow: 1;">
            <textarea name="message" id="message" rows="2" class="form-control" required placeholder="Digite sua mensagem..."></textarea>
        </div>
        <!-- Botão de envio -->
        <button type="submit" class="btn btn-primary">Enviar</button>
    </form>
</div>

<script>
    // Script para garantir que a área de mensagens role automaticamente para baixo
    const messagesDiv = document.getElementById('messages');
    messagesDiv.scrollTop = messagesDiv.scrollHeight;
</script>

@endsection
