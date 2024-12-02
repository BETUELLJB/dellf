<?php

use App\Models\Log;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Auth\TwoFactorAuthController;
use App\Http\Controllers\Auth\SettingsController;
use App\Http\Controllers\Auth\GithubController;
use App\Http\Controllers\PacienteController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\ChatController;

Route::get('/auth/github', [GithubController::class, 'redirectToGithub'])->name('auth.github');
Route::get('/auth/github/callback', [GithubController::class, 'handleGithubCallback'])->name('auth.github.callback');

Route::get('/two-factor', [TwoFactorAuthController::class, 'show'])->name('auth.two-factor');
Route::post('/two-factor', [TwoFactorAuthController::class, 'verify']);
Route::post('/two-factor/resend', [TwoFactorAuthController::class, 'resend'])->name('auth.two-factor.resend');

Route::middleware(['restrict.ip'])->group(function () {
   
    Route::get('/', function () {
        return view('welcome');
    });
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');



#, 'check.device'
Route::middleware('auth')->group(function () {
    
    Route::middleware('check.access:admin,gerente')->group(function () {
        // Visualizar
        Route::get('pacientes/{paciente}', [PacienteController::class, 'show'])->name('pacientes.show'); // Detalhes
        Route::get('pacientes', [PacienteController::class, 'index'])->name('pacientes.index');
    });

   
    Route::get('/chat', [ChatController::class, 'chatView']);
    Route::post('/chat', [ChatController::class, 'sendMessage'])->name('chat.send');

    // Acesso exclusivo para administradores
    Route::middleware('check.access:admin')->group(function () {
        Route::post('pacientes', [PacienteController::class, 'store'])->name('pacientes.store'); // Criar
        Route::put('pacientes/{paciente}', [PacienteController::class, 'update'])->name('pacientes.update');        // Atualizar
        Route::delete('pacientes/{paciente}', [PacienteController::class, 'destroy'])->name('pacientes.destroy'); // Apagar
        Route::get('/logs', [LogController::class, 'index'])->name('logs.index');
        Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
        Route::post('/settings/two-factor', [SettingsController::class, 'toggleTwoFactor'])->name('settings.toggleTwoFactor');

            // Página inicial de dispositivos
        Route::get('/devices', [DeviceController::class, 'index'])->name('devices.index');

        // Rota para criar novo dispositivo
        Route::post('/devices', [DeviceController::class, 'store'])->name('devices.store');

        // Rota para editar dispositivo
        Route::put('/devices/{device}', [DeviceController::class, 'update'])->name('devices.update');

        // Rota para deletar dispositivo
        Route::delete('/devices/{device}', [DeviceController::class, 'destroy'])->name('devices.destroy');
    });
   
});

require __DIR__.'/auth.php';
