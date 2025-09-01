@extends('layouts.app')

@section('title') {{ 'Criar Versionamento' }} @endsection

@section('content')

<link rel="stylesheet" href="{{ asset('css/edit.css') }}">
<link rel="stylesheet" href="{{ asset('css/buttons.css') }}">
<script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('js/versionamentos/editorVersionamento.js') }}"></script>
<script src="{{ asset('js/modais/storeVersionamento.js') }}"></script>
<style>
    .form-label {
        margin-bottom: 0 !important;
    }

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
        <h3 style="text-align: center; margin-bottom: 5px;">
            Criar Versionamento
        </h3>

        <div class="tipWarning mb-3">
            <span class="asteriscoTop">*</span>
            Campos obrigatórios
        </div>

        <form action="{{ route('versionamentos.store') }}" method="POST" id="formStoreVersionamento">
            @csrf
            <div class="row">
                <div class="col-12">
                    <label for="titulo" class="form-label"><span class="asteriscoTop">*</span>Título:</label>
                    <input type="text" class="form-control" id="titulo" name="titulo" required>
                </div>

                <div class="col-12 mb-3">
                    <label for="descricao" class="form-label"><span class="asteriscoTop">*</span>Descrição:</label>
                    <textarea class="form-control" id="descricao" name="descricao" rows="3" required></textarea>
                </div>
            </div>

            <hr>

            <div class="d-flex justify-content-end mt-3">
                <button type="button" onclick="showConfirmationModal()"
                    class="highlighted-btn-sm highlight-success me-0">
                    Salvar Versionamento
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
                <button type="button" class="highlighted-btn-sm highlight-grey" data-bs-dismiss="modal">Voltar e
                    corrigir</button>
                <button type="button" onclick="formSubmit()" class="highlighted-btn-sm highlight-success"  id="submitConfirmationBtn">Confirmar
                    Inserção</button>
            </div>
        </div>
    </div>
</div>
<x-back-button />
@endsection
