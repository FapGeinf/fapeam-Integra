@extends('layouts.app')
@section('title') {{ 'Criar Unidade' }} @endsection
@section('content')

<link rel="stylesheet" href="{{ asset('css/main.css') }}">
<link rel="stylesheet" href="{{ asset('css/buttons.css') }}">
<link rel="stylesheet" href="{{ asset('css/edit.css') }}">
<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>

<x-alert-toast/>
<div class="container pt-5" style="max-width: 680px;">
  <div class="col-12 border box-shadow">
    <h5 class="text-center">Criar Unidade</h5>

    <div class="tipWarning mb-3">
      <span class="text-danger">*</span>
      Campos obrigatórios
    </div>

    <form action="{{ route('unidades.store') }}" method="POST" id="formStoreUnidade">
      @csrf

      <div class="row g-3">
        <div class="col-12">
          <label for="unidadeNome">
            <span class="text-danger">*</span>
            Nome da Unidade:
          </label>
          <input type="text" class="form-control input-enabled" id="unidadeNome" name="unidadeNome" required>
        </div>

        <div class="col-12">
          <label for="unidadeSigla">
            <span class="text-danger">*</span>
            Sigla da Unidade:
          </label>
          <input type="text" class="form-control input-enabled" id="unidadeSigla" name="unidadeSigla" required>
        </div>

        <div class="col-12">
          <label for="unidadeEmail">
            <span class="text-danger">*</span>
            E-mail da Unidade:
          </label>
          <input type="email" class="form-control input-enabled" id="unidadeEmail" name="unidadeEmail" required>
        </div>

        <div class="col-12">
          <label for="unidadeTipoFK">
            <span class="text-danger">*</span>
            Tipo de Unidade:
          </label>
          <select class="form-select input-enabled border-grey pointer" id="unidadeTipoFK" name="unidadeTipoFK" required>
            <option value="">Selecione um tipo...</option>
            @foreach($unidadeTipos as $tipo)
              <option value="{{ $tipo->id }}">{{ $tipo->unidadeTipoNome }}</option>
            @endforeach
          </select>
        </div>
      </div>

      <div class="d-flex justify-content-end mt-4">
        <button type="button" onclick="showConfirmationModal()" class="highlighted-btn-sm highlight-success me-0">
          <i class="bi bi-save2 me-1"></i>
          Salvar Unidade
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

<script src="{{ asset('js/modais/storeUnidade.js') }}"></script>
<x-back-button/>
@endsection