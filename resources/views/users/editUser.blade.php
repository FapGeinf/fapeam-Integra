@extends('layouts.app')
@section('title') {{ 'Editar Usuário' }} @endsection
@section('content')

<script src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>
<script src="{{ asset('js/mascaras/jquery.mask.min.js') }}"></script>
<script src="{{ asset('ckeditor/ckeditor.js') }}"></script>

<script src="{{ asset('js/mascaras/cpfMascara.js') }}"></script>
<script src="{{ asset('js/users/insertUser.js') }}"></script>

<link rel="stylesheet" href="{{ asset('css/main.css') }}">
<link rel="stylesheet" href="{{ asset('css/edit.css') }}">
<link rel="stylesheet" href="{{ asset('css/buttons.css') }}">
<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>

<x-alert-toast/>

<div class="container pt-5" style="width: 500px;">
  <div class="col-12 border box-shadow">
    <h5 class="text-center mb-1">Editar Usuário</h5>

    <form action="{{ route('user.update', $user->id) }}" method="post" enctype="multipart/form-data" id="formInsertUser">
      @csrf
      @method('PUT')

      <div class="row g-3">
        <div class="col-12">
          <label for="name">Nome:</label>
          <input type="text" class="form-control input-enabled" name="name" value="{{ old('name', $user->name) }}" required>

          @error('name')
            <p class="alert alert-danger">{{ $message }}</p>
          @enderror
        </div>

        <div class="col-12">
          <label for="email">Email:</label>
          <input type="email" class="form-control input-enabled" name="email" value="{{ old('email', $user->email) }}" required>

          @error('email')
            <p class="alert alert-danger">{{ $message }}</p>
          @enderror
        </div>

        <div class="col-12">
          <label for="cpf">CPF:</label>
          <input type="text" class="form-control input-enabled cpf" name="cpf" value="{{ old('cpf', $user->cpf) }}" required>

          @error('cpf')
            <p class="alert alert-danger">{{ $message }}</p>
          @enderror
        </div>

        <div class="col-12">
          <label for="unidadeIdFK">Unidade:</label>
          <select class="form-select input-enabled pointer" name="unidadeIdFK" required>
            <option value="" disabled>Selecione uma unidade</option>
            @foreach ($unidades as $unidade)
              <option value="{{ $unidade->id }}" {{ old('unidadeIdFK', $user->unidadeIdFK) == $unidade->id ? 'selected' : '' }}>
                {{ $unidade->unidadeNome }} - {{ $unidade->unidadeSigla }}
              </option>
            @endforeach
          </select>

          @error('unidadeIdFK')
            <p class="alert alert-danger">{{ $message }}</p>
          @enderror
        </div>

        <div class="col-12">
          <label for="password">Senha: <small>(deixe em branco para não alterar)</small></label>
          <input type="password" class="form-control input-enabled" name="password" autocomplete="new-password">

          @error('password')
            <p class="alert alert-danger">{{ $message }}</p>
          @enderror
        </div>

        <div class="col-12">
          <label for="password_confirmation">Confirme a Senha:</label>
          <input type="password" class="form-control input-enabled" name="password_confirmation" autocomplete="new-password">
        </div>
      </div>

      <div class="d-flex justify-content-end pt-4">
        <a href="{{ route('usuarios.index') }}" class="highlighted-btn-sm highlight-grey text-decoration-none me-2">
          <i class="bi bi-arrow-left-short"></i>
          Voltar
        </a>

        <button type="button" onclick="showConfirmationModal()" class="highlighted-btn-sm highlight-success">
          <i class="bi bi-save2 me-1"></i>
          Salvar Alterações
        </button>
      </div>

      <div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="confirmationModalLabel">Confirmação de Edição</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
              <div id="modalContent">
                {{-- Conteúdo gerado dinamicamente via JS --}}
              </div>
            </div>

            <div class="modal-footer">
              <button type="button" class="highlighted-btn-sm highlight-grey" data-bs-dismiss="modal">
                <i class="bi bi-x-lg"></i>
                Voltar e corrigir
              </button>

              <button type="button" id="btnConfirmSubmit" class="highlighted-btn-sm highlight-success" onclick="formSubmit()">
                <i class="bi bi-save2 me-1"></i>
                Confirmar
              </button>
            </div>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>
@endsection