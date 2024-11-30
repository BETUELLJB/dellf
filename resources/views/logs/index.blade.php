@extends('layouts.app')

@section('title', 'Logs de Rastreamento')

@section('content')
    <h1>Logs de Rastreamento</h1>
<br>
    <!-- Tabela com DataTable -->
    <table id="logsTable" class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Modelo</th>
                <th>ID do Modelo</th>
                <th>Ação</th>
                <th>Alterações</th>
                <th>Data</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($logs as $log)
                <tr>
                    <td>{{ $log->id }}</td>
                    <td>{{ $log->model }}</td>
                    <td>{{ $log->model_id }}</td>
                    <td>{{ $log->action }}</td>
                    <td>
                        <pre>{{ json_encode($log->changes, JSON_PRETTY_PRINT) }}</pre>
                    </td>
                    <td>{{ $log->created_at }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">Nenhum log encontrado.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection

@section('styles')
    <!-- Inclui o CSS do DataTables -->
    <link href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">
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
            $('#logsTable').DataTable(); // Inicializa o DataTable na tabela com id "logsTable"
        });
    </script>
@endsection
