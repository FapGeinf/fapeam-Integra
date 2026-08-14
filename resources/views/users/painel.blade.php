@extends('layouts.app')
@section('title') {{ 'Painel de Usuários' }} @endsection
@section('content')

<link rel="stylesheet" href="{{ asset('css/show.css') }}">
<link rel="stylesheet" href="{{ asset('css/tables.css') }}">
<link rel="stylesheet" href="{{ asset('css/buttons.css') }}">

<script src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>
<script src="{{ asset('js/mascaras/jquery.mask.min.js') }}"></script>
<script src="{{ asset('js/dataTables.min.js') }}"></script>
<script src="{{ asset('js/tables/painelTable.js') }}"></script>
<script src="{{ asset('js/mascaras/cpfMascara.js') }}"></script>
<link rel="stylesheet" href="{{ asset('css/dataTables.dataTables.min.css') }}">

<x-alert-toast/>

<div class="container pt-5">

  <div class="col-12 border box-shadow">
    <h5 class="text-center mb-1">Painel de Usuários</h5>

    <div class="d-flex justify-content-center align-items-center flex-row gap-2 mt-2">
      <a href="{{ route('users.create') }}"
        class="justify-content-center align-items-center d-flex text-decoration-none highlighted-btn-sm highlight-blue"
        style="width: 170px;">
        <i class="bi bi-person-add me-1"></i>
        Adicionar usuário
      </a>

      <a href="{{ route('users.pdf') }}"
        class="justify-content-center align-items-center d-flex text-decoration-none highlighted-btn-sm highlight-blue"
        style="width: 170px;">
        <i class="bi bi-file-earmark-pdf me-1"></i>
        Relatório (PDF)
      </a>
    </div>

    <div class="mt-3">
      <div class="d-flex mb-2">
        <div style="width: 350px; display:none;" class="d-flex align-items-center gap-2">
          <label class="text13 mb-0">Unidade:</label>
          <select id="unidadeFilter" class="form-select form-select-sm border-grey pointer">
            <option value="">Todas as Unidades</option>
            @foreach ($unidades as $unidade)
              <option value="{{ $unidade->unidadeNome }}">
                {{ $unidade->unidadeNome }} - {{ $unidade->unidadeSigla }}
              </option>
            @endforeach
          </select>
        </div>
      </div>

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
              <td class="text-center">{{ $user->name }}</td>
              <td class="text-center">{{ $user->email }}</td>
              <td class="text-center">{{ $user->cpf }}</td>

              <td class="text-center">
                @if ($user->unidade)
                  {{ $user->unidade->unidadeNome }} - {{ $user->unidade->unidadeSigla }}
                @else
                  Não Especificada
                @endif
              </td>

              <td class="text-center">
                <div class="d-flex justify-content-center align-items-center gap-2">
                  
                  <a href="{{ route('users.edit', $user->id) }}" 
                    class="highlighted-btn-sm highlight-warning text-decoration-none d-flex align-items-center">
                    <i class="bi bi-pencil"></i>
                    {{-- <span class="ms-1 d-none d-md-inline">Editar</span> --}}
                  </a>

                  <button type="button" 
                    class="highlighted-btn-sm highlight-danger d-flex align-items-center"
                    data-bs-toggle="modal" 
                    data-bs-target="#deleteUserModal-{{ $user->id }}"
                    title="Excluir">
                    <i class="bi bi-trash"></i>
                    {{-- <span class="ms-1 d-none d-md-inline">Excluir</span> --}}
                  </button>

                </div>
              </td>
            </tr>

            <div class="modal fade" id="deleteUserModal-{{ $user->id }}" tabindex="-1"
              aria-labelledby="deleteUserModalLabel-{{ $user->id }}" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="deleteUserModalLabel-{{ $user->id }}">Excluir Usuário</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>

                  <div class="modal-body">
                    Tem certeza que deseja excluir o usuário
                    <br>
                    <span class="fw-medium">{{ $user->name }}</span>?
                  </div>

                  <div class="modal-footer">
                    <button type="button" class="highlighted-btn-sm highlight-grey" data-bs-dismiss="modal">
                      <i class="bi bi-x-lg"></i>
                      Cancelar
                    </button>

                    <form action="{{ route('user.destroy', $user->id) }}" method="POST">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="highlighted-btn-sm highlight-danger">
                        <i class="bi bi-trash"></i>
                        Excluir
                      </button>
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

<x-back-button/>
@endsection