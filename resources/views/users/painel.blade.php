@extends('layouts.app')
@section('title') {{ 'Painel de Usuários' }} @endsection
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="{{ asset('css/dropdown.css') }}">
<link rel="stylesheet" href="{{ asset('css/buttons.css') }}">
<script src="{{ asset('js/auto-dismiss.js') }}"></script>

<link rel="stylesheet" href="{{ asset('css/show.css') }}">

<style>
    .mt-1px {
        margin-top: 4px !important;
    }

  .li-navbar2 {
        margin-top: 5px !important;
    }

    .dataTables_info,
    .dataTables_wrapper .dataTables_paginate .paginate_button {
        font-size: 13px;
    }
</style>

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

<style>
    table {
        border-collapse: collapse !important;
    }

    .input-enabled {
        background-color: #f8fafc !important;
    }

    .input-disabled {
        background-color: #f0f0f0 !important;
    }

    .border-grey {
        border: 1px solid #ccc !important;
    }

    .modal-content {
        background-color: #fff !important;
    }
</style>

@section('content')

<div class="container pt-5">

    @if ($errors->any())
    <div class="alert alert-danger text-center auto-dismiss">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    @if (session('success'))
        <div class="alert alert-success text-center auto-dismiss">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger text-center auto-dismiss">
            {{ session('error') }}
        </div>
    @endif

    <div class="col-12 border box-shadow">
        <h5 class="text-center mb-1">Painel de Usuários</h5>

        <div class="justify-content-center align-items-center d-flex dropdown mt-2">
            <button 
                class="justify-content-center align-items-center d-flex text-decoration-none highlighted-btn-sm highlight-blue" 
                type="button" 
                data-bs-toggle="modal" 
                data-bs-target="#createUserModal"
                style="width: 170px;">
                <i class="bi bi-person-add me-1"></i>
                Adicionar usuário
            </button>

        </div>

        

        <div class="mt-3">
            <table id="painel-table" class="table table-bordered table-striped">
                <thead>
                    <tr class="text13">
                        <th class="text-center text-light">Nome</th>
                        <th class="text-center text-light">Email</th>
                        <th class="text-center text-light">CPF</th>
                        <th class="text-center text-light">Unidade</th>
                        <th class="text-center text-light">Ações</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($users as $user)
                        <tr class="text13">
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

                            <td class="text-center">
                                <div class="custom-actions-wrapper" id="actionsWrapper{{ $user->id }}">
                                    <button type="button" onclick="toggleActionsMenu({{ $user->id }})" class="custom-actions-btn">
                                        <i class="bi bi-three-dots-vertical"></i>
                                    </button>
                            
                                    <div class="custom-actions-menu">
                                        <ul>
                                            <li>
                                                <a href="#" data-bs-toggle="modal" data-bs-target="#editUserModal-{{ $user->id }}">
                                                    <i class="bi bi-pencil me-2"></i>Editar
                                                </a>
                                            </li>

                                            <li>
                                                <a href="#" class="text-danger" data-bs-toggle="modal" data-bs-target="#deleteUserModal-{{ $user->id }}">
                                                    <i class="bi bi-trash me-2"></i>Excluir
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </td>
                            
                        </tr>

                        <!-- Modal Editar Usuário -->
                        <div class="modal fade" id="editUserModal-{{ $user->id }}" tabindex="-1"
                            aria-labelledby="editUserModalLabel-{{ $user->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editUserModalLabel-{{ $user->id }}">Editar Usuário</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>

                                    <div class="modal-body pt-0">
                                        <form action="{{ route('user.update', $user->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')

                                            <div class="mb-3">
                                                <label for="name">Nome:</label>
                                                <input type="text" class="form-control input-enabled" id="name" name="name" value="{{ old('name', $user->name) }}">
                                            </div>

                                            <div class="mb-3">
                                                <label for="email">Email:</label>
                                                <input type="email" class="form-control input-enabled" id="email" name="email" value="{{ old('email', $user->email) }}">
                                            </div>

                                            <div class="mb-3">
                                                <label for="cpf">CPF:</label>
                                                <input type="text" class="form-control input-enabled" id="cpf" name="cpf" value="{{ old('cpf', $user->cpf) }}">
                                            </div>

                                            <div class="mb-3">
                                                <label for="unidadeIdFK">Unidade:</label>
                                                <select class="form-select input-enabled" id="unidadeIdFK" name="unidadeIdFK">

                                                    <option value="" disabled>Selecione uma unidade</option>
                                                    @foreach ($unidades as $unidade)
                                                        <option value="{{ $unidade->id }}"
                                                            {{ $user->unidadeIdFK == $unidade->id ? 'selected' : '' }}>
                                                            {{ $unidade->unidadeNome }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="mb-3">
                                                <label for="password">Nova senha:</label>
                                                <input type="password" class="form-control input-enabled" id="password" name="password">
                                            </div>

                                            <div class="mb-3">
                                                <label for="password_confirmation">Confirme a senha:</label>
                                                <input type="password" class="form-control input-enabled" id="password_confirmation" name="password_confirmation">
                                            </div>

                                            <div class="modal-footer p-0 pt-2">
                                                <button type="button" class="highlighted-btn-lg highlight-grey" data-bs-dismiss="modal">Cancelar</button>
                                                <button type="submit" class="highlighted-btn-lg highlight-success">Salvar</button>
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

                                    <div class="modal-body pt-0">
                                        <form action="{{ route('users.store') }}" method="POST">
                                            @csrf
                                            <div class="mb-3">
                                                <label for="name">Nome:</label>
                                                <input type="text" class="form-control input-enabled" id="name" name="name" required>
                                            </div>

                                            <div class="mb-3">
                                                <label for="email">Email:</label>
                                                <input type="email" class="form-control input-enabled" id="email" name="email" required>
                                            </div>

                                            <div class="mb-3">
                                                <label for="cpf">CPF:</label>
                                                <input type="text" class="form-control input-enabled" id="cpf" name="cpf" required>
                                            </div>

                                            <div class="mb-3">
                                                <label for="unidadeIdFK">Unidade:</label>
                                                <select class="form-select input-enabled" id="unidadeIdFK" name="unidadeIdFK">
                                                    <option value="" disabled>Selecione uma unidade</option>
                                                    @foreach ($unidades as $unidade)
                                                        <option value="{{ $unidade->id }}">{{ $unidade->unidadeNome }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="mb-3">
                                                <label for="password">Senha:</label>
                                                <input type="password" class="form-control input-enabled" id="password" name="password" required>
                                            </div>

                                            <div class="mb-3">
                                                <label for="password_confirmation">Confirme a Senha:</label>
                                                <input type="password" class="form-control input-enabled" id="password_confirmation" name="password_confirmation" required>
                                            </div>

                                            <div class="modal-footer p-0 pt-2">
                                                <button type="button" class="highlighted-btn-lg highlight-grey" data-bs-dismiss="modal">Cancelar</button>
                                                <button type="submit" class="highlighted-btn-lg highlight-success">Cadastrar</button>
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
                                        <h5 class="modal-title" id="deleteUserModalLabel-{{ $user->id }}">Excluir Usuário</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>

                                    <div class="modal-body">
                                        Tem certeza que deseja excluir o usuário {{ $user->name }}?
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="highlighted-btn-lg highlight-grey" data-bs-dismiss="modal">Cancelar</button>
                                        <form action="{{ route('user.destroy', $user->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="highlighted-btn-lg highlight-danger">Excluir</button>
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

<!-- jQuery (necessário para DataTables) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<script>
	$(document).ready(function () {
		$('#painel-table').DataTable({
			language: {
				url: "//cdn.datatables.net/plug-ins/1.13.6/i18n/pt-BR.json"
			}
		});
	});
</script>

<script>
	function toggleActionsMenu(id) {
		const wrapper = document.getElementById(`actionsWrapper${id}`);

		// Alterna o menu atual
		wrapper.classList.toggle('open');

		// Fecha os outros menus abertos
		document.querySelectorAll('.custom-actions-wrapper').forEach((el) => {
			if (el.id !== `actionsWrapper${id}`) {
				el.classList.remove('open');
			}
		});
	}

	// Fecha o dropdown ao clicar fora
	window.addEventListener('click', function (e) {
		document.querySelectorAll('.custom-actions-wrapper').forEach(wrapper => {
			if (!wrapper.contains(e.target)) {
				wrapper.classList.remove('open');
			}
		});
	});
</script>


<x-back-button/>
@endsection
