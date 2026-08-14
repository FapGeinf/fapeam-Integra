@extends('layouts.app')
@section('title') {{ 'Criar Indicador' }} @endsection
@section('content')

<link rel="stylesheet" href="{{ asset('css/main.css') }}">
<link rel="stylesheet" href="{{ asset('css/buttons.css') }}">
<link rel="stylesheet" href="{{ asset('css/edit.css') }}">
<script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
<script src="{{ asset('js/indicadores/editorIndicador.js') }}"></script>
<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>

<x-alert-toast/>
<div class="container pt-5" style="max-width: 680px;">
  <div class="col-12 border box-shadow">
    <h5 class="text-center">Criar Indicador</h5>

    <div class="tipWarning mb-3">
      <span class="text-danger">*</span>
      Campos obrigatórios
    </div>

    <form action="{{ route('indicadores.store') }}" method="POST" id="formStoreIndicador">
      @csrf

      <div class="row g-3">
        <div class="col-12">
          <label for="eixo">
            <span class="text-danger">*</span>
            Eixo:
          </label>

          <select class="form-select input-enabled border-grey pointer" id="eixo_fk" name="eixo_fk" required>
            @foreach($eixos as $eixo)
              <option value="{{ $eixo->id }}">{{ $eixo->nome }}</option>
            @endforeach
          </select>
        </div>

        <div class="col-12">
          <label for="nome">
            <span class="text-danger">*</span>
            Nome do Indicador:
          </label>

          <input type="text" class="form-control input-enabled" id="nomeIndicador" name="nomeIndicador" required>
        </div>

        <div class="col-12">
          <label for="descricao">
            <span class="text-danger">*</span>
            Objetivo do Indicador:
          </label>

          <textarea textarea class="form-control input-enabled" id="descricaoIndicador"
            name="descricaoIndicador" rows="3" required></textarea>
        </div>
      </div>

      <div class="d-flex justify-content-end mt-4">
        <button type="button" onclick="showConfirmationModal()"
          class="highlighted-btn-sm highlight-success me-0">
          <i class="bi bi-save2 me-1"></i>
          Salvar Indicador
        </button>
      </div>
    </form>
  </div>
</div>

<div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel"
  aria-hidden="true">
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

<script src="{{ asset('js/modais/storeIndicador.js') }}"></script>
<x-back-button/>
@endsection