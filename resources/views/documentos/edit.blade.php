@extends('layouts.app')
@section('title') {{ 'Editar Documento' }} @endsection
@section('content')

{{-- <link rel="stylesheet" href="{{ asset('css/edit.css') }}"> --}}
<link rel="stylesheet" href="{{ asset('css/show.css') }}">
<link rel="stylesheet" href="{{ asset('css/buttons.css') }}">
<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('js/modais/updateDocumento.js') }}"></script>

<div class="container-xxl pt-5" style="max-width: 650px !important;">
    <div class="col-12 border box-shadow">
        <div class="justify-content-center">
            <h5 class="mx-auto text-center mb-1">Editar Documento</h5>

            <div class="tipWarning text-center mt-2 mb-4" style="font-size: 12px;">
                <span class="text-danger">*</span>Campos obrigatórios
            </div>
        </div>

        <form action="{{ route('documentos.update', $documento->id) }}" method="POST" enctype="multipart/form-data" id="formUpdateDocumento">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-12 mb-3">
                    <label>
                        <span class="text-danger">*</span>Tipo de Documento:
                    </label>

                    <select id="tipoDocumento" class="form-select input-enabled" name="tipo_id" required>
                        <option value="" selected disabled>Selecione uma opção</option>
                        @foreach($tiposDocumentos as $tipo)
                            <option value="{{ $tipo->id }}" {{ $documento->tipo_id == $tipo->id ? 'selected' : '' }}>
                                {{ $tipo->nome }}
                            </option>
                        @endforeach
                    </select>
                    <div class="invalid-feedback" id="errorTipo"></div>
                </div>

                <div class="col-12 mb-3">
                    <label>
                        <span class="text-danger">*</span>Ano:
                    </label>

                    <input id="anoDocumento" type="number" class="form-control" name="ano" value="{{ $documento->ano }}" required>
                    <div class="invalid-feedback" id="errorAno"></div>
                </div>

                <div class="col-12 mb-3">
                    <label>Arquivo (opcional):</label>
                    <input id="arquivoDocumento" type="file" class="form-control" name="path">
                    <div class="invalid-feedback" id="errorAnexo"></div>

                    <div class="mt-2">
                        <small>Arquivo atual:
                            <a href="{{ asset('storage/' . $documento->path) }}" target="_blank" class="text-link text-decoration-none">
                                {{ basename($documento->path) }}
                            </a>
                        </small>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2">
                <button type="button" class="highlighted-btn-sm highlight-success me-0" id="abrirConfirmacaoBtn">
                    Atualizar Documento
                </button>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="confirmacaoModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Confirmar Alterações</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <div class="mb-3">
                    <label>Tipo de Documento:</label>
                    <input type="text" class="form-control form-control-disabled" id="confirmTipo" readonly>
                </div>

                <div class="mb-3">
                    <label>Ano:</label>
                    <input type="text" class="form-control form-control-disabled" id="confirmAno" readonly>
                </div>

                <div class="mb-3">
                    <label>Arquivo:</label>
                    <input type="text" class="form-control form-control-disabled" id="confirmAnexo" readonly>
                </div>

                <div class="mb-3">
                    <label>Pré-visualização:</label>
                    <div id="previewContainer" class="border p-2 text-center"
                    style="
                        background-color: #f0f0f0;
                        border: 1px solid #ccc !important;
                        min-height: 100px;">
                        <p>Nenhum arquivo selecionado</p>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="footer-btn footer-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="footer-btn footer-success" id="confirmarEnvioBtn">Atualizar</button>
            </div>
        </div>
    </div>
</div>

<x-back-button />
@endsection