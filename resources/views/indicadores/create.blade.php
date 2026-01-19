@extends('layouts.app')
@section('title') {{ 'Criar Indicador' }} @endsection
@section('content')

<link rel="stylesheet" href="{{ asset('css/main.css') }}">
<link rel="stylesheet" href="{{ asset('css/buttons.css') }}">
<link rel="stylesheet" href="{{ asset('css/edit.css') }}">
<link rel="stylesheet" href="{{ asset('css/buttons.css') }}">
<script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
<script src="{{ asset('js/indicadores/editorIndicador.js') }}"></script>
<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>

<style>
  .form-wrapper3 {
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 0 10px;
    padding-top: 2rem;
  }
</style>

<div class="form-wrapper3 paddingLeft">
  <div class="form_create border">
    <h5 class="text-center">
      Criar Indicador
    </h5>

    <div class="tipWarning mb-3">
      <span class="asteriscoTop">*</span>
      Campos obrigatórios
    </div>

    <form action="{{ route('indicadores.store') }}" method="POST" id="formStoreIndicador">
      @csrf

      <div class="row">
        <div class="col-12">
          <label for="eixo"><span class="asteriscoTop">*</span>Eixo:</label>

          <select class="form-select input-enabled" id="eixo_fk" name="eixo_fk" required>
            @foreach($eixos as $eixo)
              <option value="{{ $eixo->id }}">{{ $eixo->nome }}</option>
            @endforeach
          </select>
        </div>

        <div class="col-12">
          <label for="nome"><span class="asteriscoTop">*</span>Título:</label>
          <input type="text" class="form-control" id="nomeIndicador" name="nomeIndicador" required>
        </div>

        <div class="col-12 mb-3">
          <label for="descricao"><span class="asteriscoTop">*</span>Descrição:</label>
          <textarea textarea class="form-control input-enabled" id="descricaoIndicador"
            name="descricaoIndicador" rows="3" required></textarea>
        </div>
      </div>

      <div class="d-flex justify-content-end mt-3">
        <button type="button" onclick="showConfirmationModal()"
          class="highlighted-btn-sm highlight-success me-0">
          Salvar Indicador
        </button>
      </div>
    </form>
  </div>
</div>

<div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="confirmationModalLabel">Confirmação de Inserção</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
        <div id="modalContent">
          {{-- DADOS DO MODAL SERÃO GERADOS DINAMICAMENTE AQUI --}}
        </div>
      </div>

      <div class="modal-footer">
        <button type="button" class="highlighted-btn-sm highlight-grey" data-bs-dismiss="modal">
          Voltar
        </button>

        <button type="button" onclick="formSubmit()" class="highlighted-btn-sm highlight-success"  id="submitConfirmationBtn">
          Confirmar inserção
        </button>
      </div>
    </div>
  </div>
</div>

<script src="{{ asset('js/modais/storeIndicador.js') }}"></script>
<x-back-button/>
@endsection