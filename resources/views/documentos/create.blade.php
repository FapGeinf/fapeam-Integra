@extends('layouts.app')

@section('title') {{ 'Criar Documento' }} @endsection

@section('content')

<link rel="stylesheet" href="{{ asset('css/edit.css') }}">
<link rel="stylesheet" href="{{ asset('css/buttons.css') }}">
<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>

<div class="form-wrapper3 paddingLeft d-flex justify-content-center align-items-center mt-5">
    <div class="form_create border">
        <h3 style="text-align: center; margin-bottom: 5px;">Criar Documento</h3>

        <div class="tipWarning mb-3">
            <span class="asteriscoTop">*</span> Campos obrigatórios
        </div>

        <form action="{{ route('documentos.store') }}" method="POST" enctype="multipart/form-data" id="formStoreDocumento">
            @csrf

            <div class="row">
                <div class="col-12">
                    <label><span class="asteriscoTop">*</span>Tipo de Documento:</label>
                    <select class="form-select input-enabled" name="tipo_id" required>
                        <option value="">Selecione</option>
                        @foreach($tiposDocumentos as $tipo)
                            <option value="{{ $tipo->id }}">{{ $tipo->nome }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-12">
                    <label class="form-label"><span class="asteriscoTop">*</span>Ano:</label>
                    <input type="number" class="form-control" name="ano" required>
                </div>

                <div class="col-12 mb-3">
                    <label class="form-label"><span class="asteriscoTop">*</span>Arquivo:</label>
                    <input type="file" class="form-control" name="path" required>
                </div>
            </div>

            <hr>

            <div class="d-flex justify-content-end mt-3">
                <button type="submit" class="highlighted-btn-sm highlight-success me-0">
                    Salvar Documento
                </button>
            </div>
        </form>
    </div>
</div>

<x-back-button />

@endsection
