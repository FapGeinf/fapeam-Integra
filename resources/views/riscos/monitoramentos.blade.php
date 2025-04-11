@extends('layouts.app')
<script src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>
<link rel="stylesheet" href="{{ asset('css/edit.css') }}">
<link rel="stylesheet" href="{{ asset('css/buttons.css') }}">
<script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
<script src="{{ asset('js/auto-dismiss.js') }}"></script>
@section('content')
@section('title', 'Editar Monitoramentos')

<div class="form-wrapper pt-4 paddingLeft">
    <div class="form_create">
        <h3 style="text-align: center; margin-bottom: 10px;">Formulário de Monitoramentos</h3>

        <div class="error-message">
            @if ($errors->any())
                <div class="alert alert-danger text-center auto-dismiss">
                    <ul style="list-style-type:none;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>

        <form action="{{ route('riscos.insert-monitoramentos', ['id' => $risco->id]) }}" method="POST" id="formCreate"
            enctype="multipart/form-data">
            @csrf

            <div class="text-center mb-4">
                <span>Monitoramentos adicionados:</span>
                <span id="monitoramentoCounter">0</span>
            </div>

            <div id="monitoramentosDiv" class="monitoramento">
                <!-- Monitoramentos serão adicionados aqui dinamicamente -->
            </div>

            <hr class="mx-auto">

            <div class="d-flex justify-content-center">
                <div class="buttons">
                    <button type="button" class="highlighted-btn-lg highlight-blue" onclick="addMonitoramento()">Adicionar Monitoramento</button>
                    <button type="button" class="close-btn" onclick="fecharFormulario()">Remover</button>
                </div>

                <span class="my-auto me-2" style="color: #ccc;">|</span>

                <div>
                    <button type="button" onclick="showConfirmationModal()" class="highlighted-btn-lg highlight-success" data-bs-toggle="modal" data-bs-target="#confirmationModal">Salvar</button>
                </div>
            </div>

            <div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Confirmação de Edição</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body" id="modalContent">

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="highlighted-btn-lg highlight-grey" data-bs-dismiss="modal">Cancelar</button>
                            <button type="button" onclick="submitForm()" class="highlighted-btn-lg highlight-success" id="btnEdit">Confirmar Edição</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<x-back-button/>
<script src="{{ asset('js/monitoramentos.js') }}"></script>
@endsection
