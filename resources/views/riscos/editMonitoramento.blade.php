@extends('layouts.app')
@section('title') {{ 'Editar Controle Sugerido' }} @endsection
@section('content')

<link rel="stylesheet" href="{{ asset('css/edit.css') }}">
<link rel="stylesheet" href="{{ asset('css/main.css') }}">
<link rel="stylesheet" href="{{ asset('css/buttons.css') }}">
<script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
<script src="{{ asset('js/monitoramentos/editMonitoramento.js') }}"></script>

<div class="container pt-5" style="max-width: 800px;">
  <div class="border box-shadow">
    <h5 class="text-center">Editar Controle Sugerido</h5>

    <form action="{{ route('riscos.monitoramento', ['id' => $monitoramento->id]) }}" method="post"
      id="formEditMonitoramento" data-id="{{ $monitoramento->id }}" enctype="multipart/form-data">
      @csrf
      @method('PUT')
      <input type="hidden" name="monitoramento_id" value="{{ $monitoramento->id }}">

      <div class="row g-3">
        <div class="col-sm-12">
          <label for="monitoramentoControleSugerido">Controle sugerido:</label>
          <textarea class="form-control" id="monitoramentoControleSugerido"
            name="monitoramentoControleSugerido"
            required>
              {{ old('monitoramentoControleSugerido', $monitoramento->monitoramentoControleSugerido) }}
          </textarea>
        </div>
      </div>

      <div class="row g-3 mt-2">
        <div class="col-12 col-sm-6">
          <label for="statusMonitoramento">Status:</label>

          <select 
            class="form-select border-select pointer" 
            id="statusMonitoramento"
            name="statusMonitoramento" 
            required 
            @if(auth()->user()->unidade->unidadeTipoFK != 1) disabled @endif>
            <option value="NÃO IMPLEMENTADA" {{ old('statusMonitoramento', $monitoramento->statusMonitoramento) == 'NÃO IMPLEMENTADA' ? 'selected' : '' }}>
              NÃO IMPLEMENTADA
            </option>

            <option value="EM IMPLEMENTAÇÃO" {{ old('statusMonitoramento', $monitoramento->statusMonitoramento) == 'EM IMPLEMENTAÇÃO' ? 'selected' : '' }}>
              EM IMPLEMENTAÇÃO
            </option>

            <option value="IMPLEMENTADA PARCIALMENTE" {{ old('statusMonitoramento', $monitoramento->statusMonitoramento) == 'IMPLEMENTADA PARCIALMENTE' ? 'selected' : '' }}>
              IMPLEMENTADA PARCIALMENTE
            </option>

            <option value="IMPLEMENTADA" {{ old('statusMonitoramento', $monitoramento->statusMonitoramento) == 'IMPLEMENTADA' ? 'selected' : '' }}>
              IMPLEMENTADA
            </option>
          </select>

          @if(auth()->user()->unidade->unidadeTipoFK != 1)
            <input type="hidden" name="statusMonitoramento" value="{{ old('statusMonitoramento', $monitoramento->statusMonitoramento) }}">
          @endif
        </div>

        <div class="col-12 col-sm-6">
          <label for="isContinuo">É Contínuo?</label>
          <select class="form-select border-select pointer" id="isContinuo" name="isContinuo" required>
            <option value="0" {{ old('isContinuo', $monitoramento->isContinuo) == 0 ? 'selected' : '' }}>Não</option>
            <option value="1" {{ old('isContinuo', $monitoramento->isContinuo) == 1 ? 'selected' : '' }}>Sim</option>
          </select>
        </div>
      </div>

      <div class="row g-3">
        <div class="col-12 col-sm-6">
          <label for="inicioMonitoramento">Início:</label>
          <input type="date" class="form-control input-enabled" id="inicioMonitoramento"
            name="inicioMonitoramento"
            value="{{ old('inicioMonitoramento', $monitoramento->inicioMonitoramento instanceof \Carbon\Carbon ? $monitoramento->inicioMonitoramento->format('Y-m-d') : $monitoramento->inicioMonitoramento) }}"
            required>
        </div>

        <div class="col-12 col-sm-6" id="fimMonitoramentoContainer">
          <label for="fimMonitoramento">Fim:</label>
          <input type="date" class="form-control input-enabled" id="fimMonitoramento"
            name="fimMonitoramento"
            value="{{ old('fimMonitoramento', $monitoramento->fimMonitoramento instanceof \Carbon\Carbon ? $monitoramento->fimMonitoramento->format('Y-m-d') : 
            $monitoramento->fimMonitoramento) }}">
        </div>
      </div>

      <div class="d-flex justify-content-end pt-5">
        <button type="button" onclick="showConfirmationModal()" class="highlighted-btn-sm highlight-success">
          <i class="bi bi-save2 me-1"></i>
          Salvar Edição
        </button>
      </div>

      <div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
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

              <button type="button" onclick="submitForm()" class="highlighted-btn-sm highlight-success">
                <i class="bi bi-save2 me-1"></i>
                Confirmar edição
              </button>
            </div>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>

<x-back-button/>
<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
@endsection