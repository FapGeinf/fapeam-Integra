@extends('layouts.app')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
<script>
    $(document).ready(function() {
        $('.cpf').mask('000.000.000-00');

        $('form').submit(function() {
            $('#cpf').each(function() {
                var cpf = $(this).val().replace(/\D/g, '');  
                $(this).val(cpf);  
            });
        });
    });
</script>
@section('content')
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card p-30">
                    <div class="row g-3 me-2 mt-4">
                    <div class="col-md-4 d-flex align-items-end justify-content-center mt-3">
                        <div class="dropdown">
                            <button class="btn btn-sm btn-success dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                Ações
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <li>
                                    <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#createUserModal">
                                        Cadastrar Novo Usuário
                                    </a>
                                </li>
                            </ul>
                        </div>
                        @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
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
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th>Email</th>
                                    <th>CPF</th>
                                    <th>Unidade</th>
                                    <th class="text-center">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->cpf }}</td>
                                        <td>
                                            @if ($user->unidade)
                                                {{ $user->unidade->unidadeNome }}
                                            @else
                                                Não Especificada
                                            @endif
                                        </td>
                                        <td class="d-flex flex-row justify-content-center">
                                            <button type="button" class="btn btn-sm btn-primary me-2"
                                                data-bs-toggle="modal" data-bs-target="#editUserModal-{{ $user->id }}">
                                                Editar
                                            </button>
                                            <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                                data-bs-target="#deleteUserModal-{{ $user->id }}">
                                                Excluir
                                            </button>
                                        </td>
                                    </tr>

                                    <!-- Modal Editar Usuário -->
                                    <div class="modal fade" id="editUserModal-{{ $user->id }}" tabindex="-1"
                                        aria-labelledby="editUserModalLabel-{{ $user->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editUserModalLabel-{{ $user->id }}">
                                                        Editar Usuário</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{ route('user.update', $user->id) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')

                                                        <div class="mb-3">
                                                            <label for="name" class="form-label">Nome</label>
                                                            <input type="text" class="form-control" id="name"
                                                                name="name" value="{{ old('name', $user->name) }}">
                                                        </div>

                                                        <div class="mb-3">
                                                            <label for="email" class="form-label">Email</label>
                                                            <input type="email" class="form-control" id="email"
                                                                name="email" value="{{ old('email', $user->email) }}">
                                                        </div>

                                                        <div class="mb-3">
                                                            <label for="cpf" class="form-label">CPF</label>
                                                            <input type="text" class="form-control cpf" id="cpf"
                                                                name="cpf" value="{{ old('cpf', $user->cpf) }}">
                                                        </div>

                                                        <div class="mb-3">
                                                            <label for="unidadeIdFK" class="form-label">Unidade</label>
                                                            <select class="form-control" id="unidadeIdFK"
                                                                name="unidadeIdFK">
                                                                <option value="">Selecione uma unidade</option>
                                                                @foreach ($unidades as $unidade)
                                                                    <option value="{{ $unidade->id }}"
                                                                        {{ $user->unidadeIdFK == $unidade->id ? 'selected' : '' }}>
                                                                        {{ $unidade->unidadeNome }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label for="password" class="form-label">Nova Senha</label>
                                                            <input type="password" class="form-control" id="password"
                                                                name="password">
                                                        </div>

                                                        <div class="mb-3">
                                                            <label for="password_confirmation" class="form-label">Confirme a
                                                                Senha</label>
                                                            <input type="password" class="form-control"
                                                                id="password_confirmation" name="password_confirmation">
                                                        </div>

                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Fechar</button>
                                                            <button type="submit" class="btn btn-primary">Salvar</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="modal fade" id="createUserModal" tabindex="-1" aria-labelledby="createUserModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="createUserModalLabel">Cadastrar Novo Usuário</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{ route('users.store') }}" method="POST">
                                                        @csrf
                                                        <div class="mb-3">
                                                            <label for="name" class="form-label">Nome</label>
                                                            <input type="text" class="form-control" id="name" name="name" required>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label for="email" class="form-label">Email</label>
                                                            <input type="email" class="form-control" id="email" name="email" required>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label for="cpf" class="form-label">CPF</label>
                                                            <input type="text" class="form-control cpf" id="cpf" name="cpf" required>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label for="unidadeIdFK" class="form-label">Unidade</label>
                                                            <select class="form-control" id="unidadeIdFK" name="unidadeIdFK">
                                                                <option value="">Selecione uma unidade</option>
                                                                @foreach ($unidades as $unidade)
                                                                    <option value="{{ $unidade->id }}">{{ $unidade->unidadeNome }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label for="password" class="form-label">Senha</label>
                                                            <input type="password" class="form-control" id="password" name="password" required>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label for="password_confirmation" class="form-label">Confirme a Senha</label>
                                                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                                                        </div>

                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                            <button type="submit" class="btn btn-primary">Cadastrar</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Modal de Exclusão -->
                                    <div class="modal fade" id="deleteUserModal-{{ $user->id }}" tabindex="-1"
                                        aria-labelledby="deleteUserModalLabel-{{ $user->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="deleteUserModalLabel-{{ $user->id }}">
                                                        Excluir Usuário</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    Tem certeza que deseja excluir o usuário {{ $user->name }}?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Cancelar</button>
                                                    <form action="{{ route('user.destroy', $user->id) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger">Excluir</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-back-button/>
@endsection
