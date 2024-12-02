@extends('layouts.app')

@section('title', 'Página Exemplo')

@section('header')
<h1>Bem-vindo à Página de Exemplo</h1>
@endsection

@section('content')
<div class="container">
    <h1>Utilizadores</h1>
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createModal">Adicionar Usuário</button>

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
                <th>Email</th>
                <th>Nível de Acesso</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->nivel_acesso ?? 'Não definido' }}</td>
                <td>
                    <a href="{{ route('users.index', ['edit' => $user->id]) }}" class="btn btn-primary btn-sm">Editar</a>


                    <!-- Botão para excluir -->
                    <form action="{{ route('users.delete', $user->id) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm" type="submit"
                            onclick="return confirm('Tem certeza que deseja excluir este utilizador?')">
                            Apagar
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5">Nenhum utilizador encontrado.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Modal Criar Utilizador -->
<div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('users.store') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createModalLabel">Adicionar Utilizador</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Nome</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Senha</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Confirmar Senha</label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                    </div>
                    <div class="mb-3">
                        <label for="nivel_acesso" class="form-label">Nível de Acesso</label>
                        <select class="form-control" id="nivel_acesso" name="nivel_acesso" required>
                            <option value="">Selecionar</option>
                            <option value="admin">Administrador</option>
                            <option value="gerente">Gerente</option>
                            <option value="operador">Operador</option>
                        </select>
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
<!-- Modal Editar Utilizador -->
<div class="modal fade @if($editUser) show @endif" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" 
     @if($editUser) style="display: block;" @else aria-hidden="true" @endif>
    <div class="modal-dialog">
        <form action="{{ route('users.update', $editUser ? $editUser->id : '') }}" method="POST">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Editar Utilizador</h5>
                    <a href="{{ route('users.index') }}" class="btn-close" aria-label="Close"></a>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_name" class="form-label">Nome</label>
                        <input type="text" class="form-control" id="edit_name" name="name" 
                               value="{{ $editUser ? $editUser->name : '' }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="edit_email" name="email" 
                               value="{{ $editUser ? $editUser->email : '' }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_nivel_acesso" class="form-label">Nível de Acesso</label>
                        <select class="form-control" id="edit_nivel_acesso" name="nivel_acesso" required>
                            <option value="admin" {{ $editUser && $editUser->nivel_acesso == 'admin' ? 'selected' : '' }}>Administrador</option>
                            <option value="gerente" {{ $editUser && $editUser->nivel_acesso == 'gerente' ? 'selected' : '' }}>Gerente</option>
                            <option value="operador" {{ $editUser && $editUser->nivel_acesso == 'operador' ? 'selected' : '' }}>Operador</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="edit_password" class="form-label">Nova Senha (Opcional)</label>
                        <input type="password" class="form-control" id="edit_password" name="password">
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="{{ route('users.index') }}" class="btn btn-secondary">Cancelar</a>
                    <button type="submit" class="btn btn-primary">Salvar</button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection


