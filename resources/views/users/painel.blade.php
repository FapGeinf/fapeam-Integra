@extends('layouts.app')
<script src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>
<script src="{{ asset('js/mascaras/jquery.mask.min.js') }}"></script>
<script src="{{ asset('js/dataTables.min.js') }}"></script>
<link rel="stylesheet" href="{{ asset('css/dataTables.dataTables.min.css') }}">
<script src="{{ asset('js/usuarios/usuariosTable.js') }}"></script>
<script src="{{ asset('js/mascaras/cpfMascara.js') }}"></script>
@section('content')
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
    <div class="container mt-5 mb-5">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card p-30 mt-5 mb-5">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="dropdown">
                                <button class="btn btn-sm btn-success dropdown-toggle" type="button" id="dropdownMenuButton"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    Ações
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <li>
                                        <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                            data-bs-target="#createUserModal">
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

                        <table class="table table-striped" id="usuariosTable">
                            <thead>
                                <tr>
                                    <th class="text-center">Nome</th>
                                    <th class="text-center">Email</th>
                                    <th class="text-center">CPF</th>
                                    <th class="text-center">Unidade</th>
                                    <th class="text-center">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td class="text-center">{{ $user->name }}</td>
                                        <td class="text-center">{{ $user->email }}</td>
                                        <td class="text-center">{{ $user->cpf }}</td>
                                        <td>
                                            @if ($user->unidade)
                                                {{ $user->unidade->unidadeSigla }}
                                            @else
                                                Não Especificada
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-secondary dropdown-toggle" type="button"
                                                    id="dropdownMenuButton-{{ $user->id }}" data-bs-toggle="dropdown"
                                                    aria-expanded="false">
                                                    Ações
                                                </button>
                                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton-{{ $user->id }}">
                                                    <li>
                                                        <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                            data-bs-target="#editUserModal-{{ $user->id }}">
                                                            Editar
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                            data-bs-target="#deleteUserModal-{{ $user->id }}">
                                                            Excluir
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    <div class="modal fade" id="editUserModal-{{ $user->id }}" tabindex="-1"
                                        aria-labelledby="editUserLabel-{{ $user->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <form action="{{ route('user.update', $user->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="editUserLabel-{{ $user->id }}">Editar
                                                            Usuário</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Fechar"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <label for="name-{{ $user->id }}" class="form-label">Nome</label>
                                                            <input type="text" class="form-control" id="name-{{ $user->id }}"
                                                                name="name" value="{{ $user->name }}" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="email-{{ $user->id }}" class="form-label">Email</label>
                                                            <input type="email" class="form-control" id="email-{{ $user->id }}"
                                                                name="email" value="{{ $user->email }}" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="cpf-{{ $user->id }}" class="form-label">CPF</label>
                                                            <input type="text" class="form-control cpf" id="cpf-{{ $user->id }}"
                                                                name="cpf" value="{{ $user->cpf }}" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="unidade_id-{{ $user->id }}"
                                                                class="form-label">Unidade</label>
                                                            <select name="unidadeIdFK" id="unidade_id-{{ $user->id }}"
                                                                class="form-select">
                                                                <option value="">Selecione a Unidade</option>
                                                                @foreach ($unidades as $unidade)
                                                                    <option value="{{ $unidade->id }}"
                                                                        @if($user->unidadeIdFK == $unidade->id) selected @endif>
                                                                        {{ $unidade->unidadeSigla}}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Cancelar</button>
                                                        <button type="submit" class="btn btn-primary">Salvar Alterações</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                    <div class="modal fade" id="deleteUserModal-{{ $user->id }}" tabindex="-1"
                                        aria-labelledby="deleteUserLabel-{{ $user->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <form action="{{ route('user.destroy', $user->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="deleteUserLabel-{{ $user->id }}">Excluir
                                                            Usuário</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Fechar"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Tem certeza que deseja excluir o usuário
                                                        <strong>{{ $user->name }}</strong>?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Cancelar</button>
                                                        <button type="submit" class="btn btn-danger">Excluir</button>
                                                    </div>
                                                </div>
                                            </form>
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
    <div class="modal fade" id="createUserModal" tabindex="-1" aria-labelledby="createUserModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('users.store') }}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createUserModalLabel">Cadastrar Novo Usuário</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">Nome</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">E-mail</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="cpf" class="form-label">CPF</label>
                            <input type="text" class="form-control cpf" id="cpf" name="cpf" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Senha</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Confirmar Senha</label>
                            <input type="password" class="form-control" id="password_confirmation"
                                name="password_confirmation" required>
                        </div>
                        <div class="mb-3">
                            <label for="unidade_id" class="form-label">Unidade</label>
                            <select name="unidadeIdFK" id="unidadeIdFK" class="form-select">
                                <option value="">Selecione a Unidade</option>
                                @foreach ($unidades as $unidade)
                                    <option value="{{ $unidade->id }}">{{ $unidade->unidadeSigla }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-success">Cadastrar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <x-back-button />
@endsection