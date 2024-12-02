@extends('layouts.app')

@section('title', 'Gestão de Dispositivos')

@section('header')
<h1>Gestão de Dispositivos</h1>
@endsection

@section('content')

<div class="container">
    <h1>Dispositivos</h1>
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createModal">Adicionar Dispositivo</button>

    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Identificador</th>
                <th>IP</th>
                <th>MAC</th>
                <th>Localização</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($devices as $device)
            <tr>
                <td>{{ $device->id }}</td>
                <td>{{ $device->device_identifier }}</td>
                <td>{{ $device->ip_address }}</td>
                <td>{{ $device->mac_address }}</td>
                <td>{{ $device->location ?? 'Não definido' }}</td>
                <td>
                    <button class="btn btn-warning btn-sm"
                        data-bs-toggle="modal"
                        data-bs-target="#editModal"
                        data-id="{{ $device->id }}"
                        data-device_identifier="{{ $device->device_identifier }}"
                        data-ip_address="{{ $device->ip_address }}"
                        data-mac_address="{{ $device->mac_address }}"
                        data-location="{{ $device->location }}">
                        Editar
                    </button>
                    <button class="btn btn-danger btn-sm"
                        data-bs-toggle="modal"
                        data-bs-target="#deleteModal"
                        data-id="{{ $device->id }}">
                        Apagar
                    </button>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6">Nenhum dispositivo encontrado.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Modal Criar Dispositivo -->
<div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('devices.store') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createModalLabel">Adicionar Dispositivo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="device_identifier" class="form-label">Identificador do Dispositivo</label>
                        <input type="text" class="form-control" id="device_identifier" name="device_identifier" required>
                    </div>
                    <div class="mb-3">
                        <label for="ip_address" class="form-label">Endereço IP</label>
                        <input type="text" class="form-control" id="ip_address" name="ip_address" required>
                    </div>
                    <div class="mb-3">
                        <label for="mac_address" class="form-label">Endereço MAC</label>
                        <input type="text" class="form-control" id="mac_address" name="mac_address" required>
                    </div>
                    <div class="mb-3">
                        <label for="location" class="form-label">Localização (Opcional)</label>
                        <input type="text" class="form-control" id="location" name="location">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Salvar</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Modal Editar Dispositivo -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="" method="POST" id="editForm">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Editar Dispositivo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_device_identifier" class="form-label">Identificador do Dispositivo</label>
                        <input type="text" class="form-control" id="edit_device_identifier" name="device_identifier" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_ip_address" class="form-label">Endereço IP</label>
                        <input type="text" class="form-control" id="edit_ip_address" name="ip_address" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_mac_address" class="form-label">Endereço MAC</label>
                        <input type="text" class="form-control" id="edit_mac_address" name="mac_address" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_location" class="form-label">Localização (Opcional)</label>
                        <input type="text" class="form-control" id="edit_location" name="location">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Salvar</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Modal Apagar Dispositivo -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="" method="POST" id="deleteForm">
            @csrf
            @method('DELETE')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Confirmar Exclusão</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Tem certeza que deseja apagar este dispositivo?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-danger">Apagar</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    // Editar dispositivo
    const editModal = document.getElementById('editModal');
    editModal.addEventListener('show.bs.modal', function(event) {
        const button = event.relatedTarget;
        document.getElementById('edit_device_identifier').value = button.getAttribute('data-device_identifier');
        document.getElementById('edit_ip_address').value = button.getAttribute('data-ip_address');
        document.getElementById('edit_mac_address').value = button.getAttribute('data-mac_address');
        document.getElementById('edit_location').value = button.getAttribute('data-location');
        document.getElementById('editForm').action = `/devices/${button.getAttribute('data-id')}`;
    });

    // Apagar dispositivo
    const deleteModal = document.getElementById('deleteModal');
    deleteModal.addEventListener('show.bs.modal', function(event) {
        const button = event.relatedTarget;
        document.getElementById('deleteForm').action = `/devices/${button.getAttribute('data-id')}`;
    });
</script>

@endsection
