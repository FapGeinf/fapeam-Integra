@extends('layouts.app')

@section('title') {{ 'Criar Documento' }} @endsection

@section('content')

    <link rel="stylesheet" href="{{ asset('css/edit.css') }}">
    <link rel="stylesheet" href="{{ asset('css/buttons.css') }}">
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/modais/storeDocumento.js') }}"></script>

    <div class="form-wrapper3 paddingLeft d-flex justify-content-center align-items-center mt-5">
        <div class="form_create border">
            <h3 style="text-align: center; margin-bottom: 5px;">Criar Documento</h3>

            <div class="tipWarning mb-3">
                <span class="asteriscoTop">*</span> Campos obrigatórios
            </div>

            <form action="{{ route('documentos.store') }}" method="POST" enctype="multipart/form-data" id="formStoreDocumento">
                @csrf

                <div class="row">
                    <div class="col-12 mb-3">
                        <label><span class="asteriscoTop">*</span>Tipo de Documento:</label>
                        <select class="form-select input-enabled" name="tipo_id" id="tipoDocumento" required>
                            <option value="">Selecione</option>
                            @foreach($tiposDocumentos as $tipo)
                                <option value="{{ $tipo->id }}">{{ $tipo->nome }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-12 mb-3">
                        <label class="form-label"><span class="asteriscoTop">*</span>Ano:</label>
                        <input type="number" class="form-control" name="ano" id="anoDocumento" required>
                    </div>

                    <div class="col-12 mb-3">
                        <label class="form-label"><span class="asteriscoTop">*</span>Arquivo:</label>
                        <input type="file" class="form-control" name="path" id="arquivoDocumento" required>
                    </div>
                </div>

                <hr>

                <div class="d-flex justify-content-end mt-3">
                    <button type="button" id="abrirConfirmacaoBtn" class="highlighted-btn-sm highlight-success">
                        Salvar Documento
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal de confirmação com erros -->
    <div class="modal fade" id="confirmacaoModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Confirmar Dados do Documento</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label"><strong>Tipo de Documento:</strong></label>
                        <input type="text" class="form-control" id="confirmTipo" readonly>
                        <div class="invalid-feedback" id="errorConfirmTipo"></div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label"><strong>Ano:</strong></label>
                        <input type="text" class="form-control" id="confirmAno" readonly>
                        <div class="invalid-feedback" id="errorConfirmAno"></div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label"><strong>Arquivo:</strong></label>
                        <input type="text" class="form-control" id="confirmAnexo" readonly>
                        <div class="invalid-feedback" id="errorConfirmAnexo"></div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label"><strong>Pré-visualização do Arquivo:</strong></label>
                        <div id="previewContainer" class="border p-2 text-center" style="min-height: 100px;">
                            <p>Nenhum arquivo selecionado</p>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-success btn-sm" id="confirmarEnvioBtn">Confirmar e Salvar</button>
                </div>

            </div>
        </div>
    </div>

    <x-back-button />

@endsection
