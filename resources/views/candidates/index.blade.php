
@extends('layouts.app')

@section('content')

@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

<div class="container">
    <h1>Lista de Candidatos</h1>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createCandidateModal">Adicionar Candidato</button>

    <table class="table mt-3">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Email</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($candidates as $candidate)
            <tr>
                <td>{{ $candidate->id }}</td>
                <td>{{ $candidate->name }}</td>
                <td>{{ $candidate->email }}</td>
                <td>
                    <button class="btn btn-info" data-bs-toggle="modal" data-bs-target="#viewCandidateModal" onclick="viewCandidate({{ $candidate->toJson() }})">Ver</button>
                    <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editCandidateModal" onclick="editCandidate({{ $candidate->toJson() }})">Editar</button>
                    <form action="{{ route('candidates.destroy', $candidate) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Excluir</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Modal: Criar Candidato -->
<div class="modal fade" id="createCandidateModal" tabindex="-1" aria-labelledby="createCandidateModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('candidates.store') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createCandidateModalLabel">Adicionar Candidato</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Nome</label>
                        <input type="text" class="form-control" name="name" id="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" id="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="cell1" class="form-label">Telefone</label>
                        <input type="text" class="form-control" name="cell1" id="cell1" required>
                    </div>
                    <div class="mb-3">
                        <label for="document_number" class="form-label">Número do Documento</label>
                        <input type="text" class="form-control" name="document_number" id="document_number" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Senha</label>
                        <input type="password" class="form-control" name="password" id="password" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Salvar</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Modal: Editar Candidato -->
<div class="modal fade" id="editCandidateModal" tabindex="-1" aria-labelledby="editCandidateModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="editCandidateForm" method="POST">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editCandidateModalLabel">Editar Candidato</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="editName" class="form-label">Nome</label>
                        <input type="text" class="form-control" name="name" id="editName" required>
                    </div>
                    <div class="mb-3">
                        <label for="editEmail" class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" id="editEmail" required>
                    </div>
                    <div class="mb-3">
                        <label for="editCell1" class="form-label">Telefone</label>
                        <input type="text" class="form-control" name="cell1" id="editCell1" required>
                    </div>
                    <div class="mb-3">
                        <label for="editDocumentNumber" class="form-label">Número do Documento</label>
                        <input type="text" class="form-control" name="document_number" id="editDocumentNumber" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Salvar Alterações</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Modal: Ver Candidato -->
<div class="modal fade" id="viewCandidateModal" tabindex="-1" aria-labelledby="viewCandidateModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewCandidateModalLabel">Detalhes do Candidato</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p><strong>Nome:</strong> <span id="viewName"></span></p>
                <p><strong>Email:</strong> <span id="viewEmail"></span></p>
                <p><strong>Telefone:</strong> <span id="viewCell1"></span></p>
                <p><strong>Número do Documento:</strong> <span id="viewDocumentNumber"></span></p>
            </div>
        </div>
    </div>
</div>

<script>
    function editCandidate(candidate) {
        document.getElementById('editName').value = candidate.name;
        document.getElementById('editEmail').value = candidate.email;
        document.getElementById('editCell1').value = candidate.cell1;
        document.getElementById('editDocumentNumber').value = candidate.document_number;
        document.getElementById('editCandidateForm').action = `/candidates/${candidate.id}`;
    }

    function viewCandidate(candidate) {
        document.getElementById('viewName').innerText = candidate.name;
        document.getElementById('viewEmail').innerText = candidate.email;
        document.getElementById('viewCell1').innerText = candidate.cell1;
        document.getElementById('viewDocumentNumber').innerText = candidate.document_number;
    }
</script>
@endsection
