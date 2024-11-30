<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Código de Autenticação</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap');
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white w-full max-w-md mx-auto p-8 rounded-2xl shadow-2xl text-center">
        <div class="mb-6">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-16 h-16 text-blue-500 mx-auto mb-4">
                <path stroke-linecap="round" stroke-linejoin="round" d="M7.864 4.243A7.5 7.5 0 0119.5 10.5c0 2.92-.556 5.709-1.568 8.268M5.742 6.364A7.465 7.465 0 004.5 10.5a7.464 7.464 0 01-1.15 3.993m1.989 3.559A11.209 11.209 0 008.25 10.5a3.75 3.75 0 117.5 0c0 .527-.021 1.049-.064 1.565M12 10.5a14.94 14.94 0 01-3.6 9.75m6.633-4.596a18.666 18.666 0 01-2.485 5.33" />
            </svg>
            <h1 class="text-3xl font-bold text-gray-800">Código de Verificação</h1>
        </div>
        
        <p class="text-gray-600 mb-6">Para completar seu login, use o código abaixo:</p>
        
        <div class="bg-blue-50 border-2 border-blue-200 rounded-lg p-4 mb-6">
            <h2 class="text-4xl font-bold text-blue-600 tracking-widest">{{ $code }}</h2>
        </div>
        
        <div class="text-sm text-gray-500">
            <p>Este código é válido por <strong>10 minutos</strong>.</p>
            <p class="mt-2">Se você não solicitou este código, ignore este e-mail.</p>
        </div>

        <div class="mt-6 text-xs text-gray-400">
            <p>© {{ date('Y') }} {{ config('app.name') }}. Todos os direitos reservados.</p>
        </div>
    </div>
</body>
</html>