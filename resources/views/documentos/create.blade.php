@extends('layouts.app')
@section('title') {{ 'Criar Documento' }} @endsection
@section('content')

<link rel="stylesheet" href="{{ asset('css/show.css') }}">
<link rel="stylesheet" href="{{ asset('css/buttons.css') }}">
<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('js/modais/storeDocumento.js') }}"></script>

<div class="container pt-5" style="max-width: 650px;">
  <div class="col-12 border box-shadow">
    <div class="justify-content-center">
      <h5 class="text-center mb-1">Criar Documento</h5>

      <div class="text-muted text-center mt-2 mb-4">
        <span class="text-danger">*</span>
        <span class="text-secondary text13">Campos obrigatórios</span>
      </div>
    </div>

    <form action="{{ route('documentos.store') }}" method="POST" enctype="multipart/form-data" id="formStoreDocumento">
      @csrf

      <div class="row">
        <div class="col-12 mb-3">
          <label>
            <span class="text-danger">*</span>
            Tipo de Documento:
          </label>

          <select class="form-select input-enabled pointer" name="tipo_id" id="tipoDocumento" required>
              <option value="" disabled selected>Selecione uma opção</option>
            @foreach($tiposDocumentos as $tipo)
              <option value="{{ $tipo->id }}">{{ $tipo->nome }}</option>
            @endforeach
          </select>
        </div>

        <div class="col-12 mb-3">
          <label>
            <span class="text-danger">*</span>
            Ano:
          </label>
            
          <input type="number" class="form-control" name="ano" id="anoDocumento" required>
        </div>

        <div class="col-12 mb-3">
          <label>
            <span class="text-danger">*</span>
            Arquivo:
          </label>
            
          <input type="file" class="form-control" name="path" id="arquivoDocumento" required>
        </div>
      </div>

      <div class="d-flex justify-content-end mt-3">
        <button type="button" id="abrirConfirmacaoBtn" class="highlighted-btn-sm highlight-success">
          <i class="bi bi-save2 me-1"></i>
          Salvar Documento
        </button>
      </div>
    </form>
  </div>
</div>

<div class="modal fade" id="confirmacaoModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Confirmar Dados do Documento</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        <div class="row g-3">
          <div>
            <label>Tipo de Documento:</label>
            <input type="text" class="form-control input-disabled" id="confirmTipo" readonly>
            <div class="invalid-feedback" id="errorConfirmTipo"></div>
          </div>  
          
          <div>
            <label>Ano:</label>
            <input type="text" class="form-control input-disabled" id="confirmAno" readonly>
            <div class="invalid-feedback" id="errorConfirmAno"></div>
          </div>  
          
          <div>
            <label>Arquivo:</label>
            <input type="text" class="form-control input-disabled" id="confirmAnexo" readonly>
            <div class="invalid-feedback" id="errorConfirmAnexo"></div>
          </div>       
            
          <div>
            <label>Pré-visualização do arquivo:</label>
            <div id="previewContainer" class="border-select input-disabled p-1">
            </div>
          </div>          
        </div>
      </div>

      <div class="modal-footer">
        <button type="button" class="footer-btn footer-secondary" data-bs-dismiss="modal">
          <i class="bi bi-x-lg"></i>
          Voltar e corrigir
        </button>

        <button type="button" class="footer-btn footer-success" id="confirmarEnvioBtn">
          <i class="bi bi-save2 me-1"></i>
          Confirmar
        </button>
      </div>
    </div>
  </div>
</div>

<x-back-button/>
@endsection