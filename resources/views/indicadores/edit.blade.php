@extends('layouts.app')
@section('title') {{ 'Editar Indicador' }} @endsection
@section('content')

<link rel="stylesheet" href="{{ asset('css/edit.css') }}">
<link rel="stylesheet" href="{{ asset('css/main.css') }}">
<link rel="stylesheet" href="{{ asset('css/buttons.css') }}">
<script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
<script src="{{ asset('js/indicadores/editorIndicador.js') }}"></script>
<script src="{{ asset('js/modais/editIndicador.js') }}"></script>
<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>

<x-alert-toast/>
<div class="container-xxl pt-5" style="max-width: 700px;">
  <div class="col-12 border box-shadow">
    <h5 class="text-center">Editar Indicador</h5>

    <form action="{{ route('indicadores.update', $indicador->id) }}" method="POST" id="formEditIndicador">
      @csrf
      @method('PUT')
      <div class="row g-3">
        <div class="col-12">
          <label for="eixo_fk">Eixo:</label>
          <select class="form-select border-select input-enabled" id="eixo_fk" name="eixo_fk" required>
            @foreach($eixos as $eixo)
              <option value="{{ $eixo->id }}" {{ old('eixo_fk', $indicador->eixo_fk) == $eixo->id ? 'selected' : '' }}>
                {{ $eixo->nome }}
              </option>
            @endforeach
          </select>
        </div>

        <div class="col-12">
          <label for="nomeIndicador">Nome do Indicador:</label>
          <input 
            type="text" 
            class="form-control input-enabled" 
            id="nomeIndicador" 
            name="nomeIndicador"
            value="{{ old('nomeIndicador', $indicador->nomeIndicador) }}" 
            required
          >
        </div>

        <div class="col-12 mb-3">
          <label for="descricaoIndicador">Objetivo do Indicador:</label>
          <textarea class="form-control input-enabled" id="descricaoIndicador" name="descricaoIndicador"
            rows="3" required>{{ old('descricaoIndicador', $indicador->descricaoIndicador) }}</textarea>
        </div>
      </div>

      <div class="d-flex justify-content-end mt-4">
        <a href="{{ route('indicadores.index') }}" 
          class="highlighted-btn-sm highlight-grey text-decoration-none me-2">
          <i class="bi bi-arrow-left"></i>
          Voltar para Indicadores
        </a>

        <button type="button" onclick="showConfirmationModal()" 
          class="highlighted-btn-sm highlight-success me-0">
          <i class="bi bi-save2 me-1"></i>
          Salvar Edição
        </button>
      </div>
    </form>
  </div>
</div>

<div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" style="max-width: 700px;">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="confirmationModalLabel">Confirmação de Edição</h5>
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

        <button type="button" class="highlighted-btn-sm highlight-success" id="submitConfirmationBtn" onclick="formSubmit()">
          <i class="bi bi-save2 me-1"></i>
          Confirmar Edição
        </button>
      </div>
    </div>
  </div>
</div>

<x-back-button/>
@endsection