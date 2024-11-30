@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <!-- Cabeçalho -->
            <h2 class="mb-4">Configurações</h2>

            <!-- Status Message -->
            @if(session('status'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('status') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            <!-- Card Principal com Abas -->
            <div class="card">
                <div class="card-header">
                    <ul class="nav nav-tabs card-header-tabs" id="settingsTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="security-tab" data-bs-toggle="tab" data-bs-target="#security" type="button" role="tab" aria-selected="true">
                                <i class="fas fa-shield-alt me-2"></i>Segurança
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="notifications-tab" data-bs-toggle="tab" data-bs-target="#notifications" type="button" role="tab" aria-selected="false">
                                <i class="fas fa-bell me-2"></i>Notificações
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-selected="false">
                                <i class="fas fa-user me-2"></i>Perfil
                            </button>
                        </li>
                    </ul>
                </div>

                <div class="card-body">
                    <div class="tab-content" id="settingsTabContent">
                        <!-- Aba de Segurança -->
                        <div class="tab-pane fade show active" id="security" role="tabpanel" aria-labelledby="security-tab">
                            <div class="row justify-content-center">
                                <div class="col-md-10">
                                    <div class="text-center mb-4">
                                        <h4 class="card-title mb-3">Autenticação em Dois Fatores</h4>
                                        <div class="mb-3">
                                            @if(auth()->user()->two_factor_enabled)
                                                <span class="badge bg-success p-2" style="font-size: 1em;">
                                                    <i class="fas fa-check-circle me-2"></i>Ativada
                                                </span>
                                            @else
                                                <span class="badge bg-secondary p-2" style="font-size: 1em;">
                                                    <i class="fas fa-times-circle me-2"></i>Desativada
                                                </span>
                                            @endif
                                        </div>
                                        
                                        <form method="POST" action="{{ route('settings.toggleTwoFactor') }}" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn {{ auth()->user()->two_factor_enabled ? 'btn-danger' : 'btn-primary' }} btn-lg">
                                                @if(auth()->user()->two_factor_enabled)
                                                    <i class="fas fa-lock-open me-2"></i>Desativar
                                                @else
                                                    <i class="fas fa-lock me-2"></i>Ativar
                                                @endif
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Aba de Notificações -->
                        <div class="tab-pane fade" id="notifications" role="tabpanel" aria-labelledby="notifications-tab">
                            <div class="text-center py-5">
                                <h5 class="text-muted">Configurações de Notificações</h5>
                                <p>Configure suas preferências de notificações aqui</p>
                            </div>
                        </div>

                        <!-- Aba de Perfil -->
                        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                            <div class="text-center py-5">
                                <h5 class="text-muted">Configurações de Perfil</h5>
                                <p>Atualize suas informações de perfil aqui</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Adicione isso no seu layout se ainda não tiver -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<style>
    .nav-tabs .nav-link {
        color: #666;
        border: none;
        padding: 1rem 1.5rem;
    }
    .nav-tabs .nav-link.active {
        color: #0d6efd;
        border-bottom: 2px solid #0d6efd;
        background: none;
    }
    .badge {
        font-weight: normal;
    }
    .btn-lg {
        padding: 0.75rem 2.5rem;
    }
</style>
@endsection