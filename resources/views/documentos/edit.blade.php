@extends('layouts.app')

@section('title') {{ 'Editar Documento' }} @endsection

@section('content')

    <link rel="stylesheet" href="{{ asset('css/edit.css') }}">
    <link rel="stylesheet" href="{{ asset('css/buttons.css') }}">
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/modais/updateDocumento.js') }}"></script>

    <div class="form-wrapper3 paddingLeft d-flex justify-content-center align-items-center mt-5">
        <div class="form_create border">
            <h3 style="text-align: center; margin-bottom: 5px;">Editar Documento</h3>

            <div class="tipWarning mb-3">
                <span class="asteriscoTop">*</span> Campos obrigatórios
            </div>

            <form action="{{ route('documentos.update', $documento->id) }}" method="POST" enctype="multipart/form-data"
                id="formUpdateDocumento">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-12">
                        <label><span class="asteriscoTop">*</span>Tipo de Documento:</label>
                        <select class="form-select input-enabled" name="tipo_id" required>
                            <option value="">Selecione</option>
                            @foreach($tiposDocumentos as $tipo)
                                <option value="{{ $tipo->id }}" {{ $documento->tipo_id == $tipo->id ? 'selected' : '' }}>
                                    {{ $tipo->nome }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-12">
                        <label class="form-label"><span class="asteriscoTop">*</span>Ano:</label>
                        <input type="number" class="form-control" name="ano" value="{{ $documento->ano }}" required>
                    </div>

                    <div class="col-12 mb-3">
                        <label class="form-label">Arquivo (opcional):</label>
                        <input type="file" class="form-control" name="path">
                        <div class="mt-2">
                            <small>Arquivo atual:
                                <a href="{{ asset('storage/' . $documento->path) }}" target="_blank">
                                    {{ basename($documento->path) }}
                                </a>
                            </small>
                        </div>
                    </div>
                </div>

                <hr>

                <button type="button" class="highlighted-btn-sm highlight-success me-0" id="abrirConfirmacaoBtn">
                    Atualizar Documento
                </button>
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
                        <label class="form-label">Tipo de Documento:</label>
                        <input type="text" class="form-control" id="confirmTipo" readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Ano:</label>
                        <input type="text" class="form-control" id="confirmAno" readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Arquivo:</label>
                        <input type="text" class="form-control" id="confirmAnexo" readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Pré-visualização:</label>
                        <div id="previewContainer" class="border p-2 text-center" style="min-height: 120px;">
                            <p>Nenhum arquivo selecionado</p>
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="highlighted-btn-sm highlight-danger" data-bs-dismiss="modal">
                        Cancelar
                    </button>
                    <button type="button" class="highlighted-btn-sm highlight-success" id="confirmarEnvioBtn">
                        Confirmar e Atualizar
                    </button>
                </div>

            </div>
        </div>
    </div>


    <x-back-button />

@endsection