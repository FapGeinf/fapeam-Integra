@extends('layouts.app')
<script src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>
<link rel="stylesheet" href="{{ asset('css/edit.css') }}">
<script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
@section('content')
@section('title', 'Editar Monitoramentos')
<div class="form-wrapper pt-4 paddingLeft">
    <div class="form_create">
        <h3 style="text-align: center; margin-bottom: 10px;">Formulário de Monitoramentos</h3>

        <div class="error-message">
            @if ($errors->any())
                <div class="alert alert-danger">
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

            <div class="text-center">
                <span>Monitoramentos adicionados: </span>
                <span id="monitoramentoCounter">0</span>
            </div>


            <div id="monitoramentosDiv" class="monitoramento">
                <!-- Monitoramentos serão adicionados aqui dinamicamente -->
            </div>

            <div class="buttons">
                <button type="button" class="add-btn" onclick="addMonitoramento()">Adicionar Monitoramento</button>
                <button type="button" class="close-btn" onclick="fecharFormulario()">Remover</button>
            </div>


            <span id="tip">
                <i class="bi bi-exclamation-circle-fill"></i>
                Dica: Revise sua edição antes de salvar
            </span>
            <div id="btnSave">
                <button type="button" onclick="showConfirmationModal()" class="submit-btn" data-bs-toggle="modal"
                    data-bs-target="#confirmationModal">Salvar</button>
            </div>

            <!-- Modal de Confirmação -->
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
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="button" onclick="submitForm()" class="btn btn-success"
                                id="btnEdit">Confirmar Edição</button>
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
