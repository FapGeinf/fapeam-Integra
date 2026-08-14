@extends('layouts.app')
@section('title') {{ 'Criar Diretoria' }} @endsection
@section('content')

<link rel="stylesheet" href="{{ asset('css/main.css') }}">
<link rel="stylesheet" href="{{ asset('css/buttons.css') }}">
<link rel="stylesheet" href="{{ asset('css/edit.css') }}">
<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>

<x-alert-toast/>
<div class="container pt-5" style="max-width: 680px;">
  <div class="col-12 border box-shadow">
    <h5 class="text-center">Criar Diretoria</h5>

    <div class="tipWarning mb-3">
      <span class="text-danger">*</span>
      Campos obrigatórios
    </div>

    <form action="{{ route('diretorias.store') }}" method="POST" id="formStoreDiretoria">
      @csrf

      <div class="row g-3">
        <div class="col-12">
          <label for="diretoriaSigla">
            <span class="text-danger">*</span>
            Sigla da Diretoria:
          </label>
          <input type="text" class="form-control input-enabled" id="diretoriaSigla" name="diretoriaSigla" required>
        </div>

        <div class="col-12">
          <label for="diretoriaNome">
            <span class="text-danger">*</span>
            Nome da Diretoria:
          </label>
          <input type="text" class="form-control input-enabled" id="diretoriaNome" name="diretoriaNome" required>
        </div>

        <div class="col-12">
          <label for="diretor">
            Diretor Responsável:
          </label>
          <input type="text" class="form-control input-enabled" id="diretor" name="diretor">
        </div>
      </div>

      <div class="d-flex justify-content-end mt-4">
        <button type="button" onclick="showConfirmationModal()" class="highlighted-btn-sm highlight-success me-0">
          <i class="bi bi-save2 me-1"></i>
          Salvar Diretoria
        </button>
      </div>
    </form>
  </div>
</div>

<div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" style="max-width: 680px;">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="confirmationModalLabel">Confirmação de Inserção</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
        <div id="modalContent"></div>
      </div>

      <div class="modal-footer">
        <button type="button" class="highlighted-btn-sm highlight-grey" data-bs-dismiss="modal">
          <i class="bi bi-x-lg"></i>
          Voltar e corrigir
        </button>

        <button type="button" onclick="formSubmit()" class="highlighted-btn-sm highlight-success" id="submitConfirmationBtn">
          <i class="bi bi-save2 me-1"></i>
          Confirmar inserção
        </button>
      </div>
    </div>
  </div>
</div>

<script src="{{ asset('js/modais/storeDiretoria.js') }}"></script>
<x-back-button/>
@endsection