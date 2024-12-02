@extends('layouts.app')

@section('title', 'Rastreamento de Logs')

@section('content')
    <div class="container">
        <h1 class="my-4">Rastreamento de Logs</h1>

        <div class="table-responsive">
            <!-- Tabela com DataTable -->
            <table id="logsTable" class="table table-striped table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Usuário</th>
                        <th>IP</th>
                        <th>Modelo</th>
                        <th>ID do Modelo</th>
                        <th>Ação</th>
                        <th>Alterações</th>
                        <th>Status</th>
                        <th>Mensagem</th>
                        <th>Data</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($logs as $log)
                        <tr>
                            <td>{{ $log->id }}</td>
                            <td>{{ $log->user->name ?? 'Desconhecido' }}</td>
                            <td>{{ $log->ip_address ?? 'Não registrado' }}</td>
                            <td>{{ $log->model }}</td>
                            <td>{{ $log->model_id ?? 'N/A' }}</td>
                            <td>{{ ucfirst($log->action) }}</td>
                            <td>
                                @if($log->changes)
                                    <pre>{{ json_encode($log->changes, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                                @else
                                    <span class="text-muted">Sem alterações</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-{{ $log->status === 'success' ? 'success' : ($log->status === 'error' ? 'danger' : 'warning') }}">
                                    {{ ucfirst($log->status) }}
                                </span>
                            </td>
                            <td>{{ $log->message ?? 'Sem mensagem' }}</td>
                            <td>{{ $log->created_at->format('d/m/Y H:i:s') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="text-center">Nenhum log encontrado.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('styles')
    <!-- Inclui o CSS do DataTables -->
    <link href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <style>
        pre {
            white-space: pre-wrap;
            word-wrap: break-word;
        }
    </style>
@endsection

@section('scripts')
    <!-- Inclui o jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Inclui o script do DataTables -->
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    
    <!-- Inicializa o DataTables -->
    <script>
        $(document).ready(function() {
            $('#logsTable').DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/Portuguese-Brasil.json'
                },
                order: [[0, 'desc']], // Ordenar por ID (mais recentes primeiro)
                pageLength: 10,
                lengthMenu: [10, 25, 50, 100]
            });
        });
    </script>
@endsection
