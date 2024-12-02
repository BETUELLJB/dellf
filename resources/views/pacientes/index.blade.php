@extends('layouts.app')

@section('title', 'Página Exemplo')

@section('header')
<h1>Bem-vindo à Página de Exemplo</h1>
@endsection

@section('content')
<div class="container">
    <h1>Pacientes</h1>
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createModal">Adicionar Paciente</button>

    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Idade</th>
                <th>Sexo</th>
                <th>Contacto</th>
                <th>Estado Médico</th>
                <th>Diagnóstico</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($pacientes as $paciente)
            <tr>
                <td>{{ $paciente->id }}</td>
                <td>{{ $paciente->nome }}</td>
                <td>{{ $paciente->idade }}</td>
                <td>{{ $paciente->sexo }}</td>
                <td>{{ $paciente->contacto }}</td>
                <td>{{ $paciente->estado_medico }}</td>
                <td>{{ $paciente->diagnostico }}</td>
                <td>
                    <button class="btn btn-warning btn-sm"
                        data-bs-toggle="modal"
                        data-bs-target="#editModal"
                        data-id="{{ $paciente->id }}"
                        data-nome="{{ $paciente->nome }}"
                        data-contacto="{{ $paciente->contacto }}"
                        data-idade="{{ $paciente->idade }}"
                        data-sexo="{{ $paciente->sexo }}"
                        data-estado_medico="{{ $paciente->estado_medico }}"
                        data-diagnostico="{{ $paciente->diagnostico }}"
                        data-medicamentos="{{ $paciente->medicamentos }}">
                        Editar
                    </button>

                    <button class="btn btn-danger btn-sm"
                        data-bs-toggle="modal"
                        data-bs-target="#deleteModal"
                        data-id="{{ $paciente->id }}">
                        Apagar
                    </button>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8">Nenhum paciente encontrado.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>


<!-- Modal Criar Paciente -->
<div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('pacientes.store') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createModalLabel">Adicionar Paciente</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nome" class="form-label">Nome</label>
                        <input type="text" class="form-control" id="nome" name="nome" required>
                    </div>
                    <div class="mb-3">
                        <label for="contacto" class="form-label">Contacto</label>
                        <input type="text" class="form-control" id="contacto" name="contacto" required>
                    </div>
                    <div class="mb-3">
                        <label for="idade" class="form-label">Idade</label>
                        <input type="number" class="form-control" id="idade" name="idade" required>
                    </div>
                    <div class="mb-3">
                        <label for="sexo" class="form-label">Sexo</label>
                        <select class="form-control" id="sexo" name="sexo" required>
                            <option value="">Selecionar</option>
                            <option value="Masculino">Masculino</option>
                            <option value="Feminino">Feminino</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="estado_medico" class="form-label">Estado Médico</label>
                        <textarea class="form-control" id="estado_medico" name="estado_medico" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="consultas" class="form-label">Consultas</label>
                        <textarea class="form-control" id="consultas" name="consultas"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="diagnostico" class="form-label">Diagnóstico</label>
                        <textarea class="form-control" id="diagnostico" name="diagnostico"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="medicamentos" class="form-label">Medicamentos</label>
                        <textarea class="form-control" id="medicamentos" name="medicamentos"></textarea>
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


<!-- Modal Editar Paciente -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="" method="POST" id="editForm">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Editar Paciente</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_nome" class="form-label">Nome</label>
                        <input type="text" class="form-control" id="edit_nome" name="nome" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_contacto" class="form-label">Contacto</label>
                        <input type="text" class="form-control" id="edit_contacto" name="contacto" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_idade" class="form-label">Idade</label>
                        <input type="number" class="form-control" id="edit_idade" name="idade" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_sexo" class="form-label">Sexo</label>
                        <select class="form-control" id="edit_sexo" name="sexo" required>
                            <option value="">Selecionar</option>
                            <option value="Masculino">Masculino</option>
                            <option value="Feminino">Feminino</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="edit_estado_medico" class="form-label">Estado Médico</label>
                        <textarea class="form-control" id="edit_estado_medico" name="estado_medico" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="edit_diagnostico" class="form-label">Diagnóstico</label>
                        <textarea class="form-control" id="edit_diagnostico" name="diagnostico"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="edit_medicamentos" class="form-label">Medicamentos</label>
                        <textarea class="form-control" id="edit_medicamentos" name="medicamentos"></textarea>
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


<!-- Modal Apagar Produto -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="" method="POST" id="deleteForm">
            @csrf
            @method('DELETE')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Confirmar</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Tem certeza que deseja apagar o Paciente?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-danger">Eliminar</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
   
    // Preencher dados no modal de edição
    const editModal = document.getElementById('editModal');
    editModal.addEventListener('show.bs.modal', function(event) {
        const button = event.relatedTarget;
        
        // Preencher os campos do formulário com os dados do paciente
        document.getElementById('edit_nome').value = button.getAttribute('data-nome');
        document.getElementById('edit_contacto').value = button.getAttribute('data-contacto');
        document.getElementById('edit_idade').value = button.getAttribute('data-idade');
        document.getElementById('edit_sexo').value = button.getAttribute('data-sexo');
        document.getElementById('edit_estado_medico').value = button.getAttribute('data-estado_medico');
        document.getElementById('edit_diagnostico').value = button.getAttribute('data-diagnostico');
        document.getElementById('edit_medicamentos').value = button.getAttribute('data-medicamentos');
        
        // Alterar a URL do formulário para a rota de atualização do paciente
        const formAction = `/pacientes/${button.getAttribute('data-id')}`;  // A URL precisa ser completa
        document.getElementById('editForm').action = formAction;
    });



     // Preencher dados no modal de exclusão
     const deleteModal = document.getElementById('deleteModal');
    deleteModal.addEventListener('show.bs.modal', function(event) {
        const button = event.relatedTarget;
        document.getElementById('deleteForm').action = `pacientes/${button.getAttribute('data-id')}`;
    });
</script>


@endsection