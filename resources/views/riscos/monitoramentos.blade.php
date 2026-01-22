@extends('layouts.app')
@section('title', 'Editar Formulário de Monitoramentos')
@section('content')

<script src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>
<link rel="stylesheet" href="{{ asset('css/edit.css') }}">
<link rel="stylesheet" href="{{ asset('css/main.css') }}">
<link rel="stylesheet" href="{{ asset('css/buttons.css') }}">
<script src="{{ asset('ckeditor/ckeditor.js') }}"></script>

<x-alert-toast/>

<div class="container pt-5" style="max-width: 800px;">
  <div class="col-12 border box-shadow">
    <h5 class="text-center">Editar Formulário de Monitoramentos</h5>

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

      <hr class="mx-auto pb-3">

      <div class="d-flex justify-content-center">
        <div class="buttons">
          <button type="button" class="highlighted-btn-sm highlight-blue me-2" onclick="addMonitoramento()">
            <i class="bi bi-plus-lg"></i>
            Adicionar Monitoramento
          </button>

          <button type="button" class="highlighted-btn-sm highlight-danger me-2" onclick="fecharFormulario()">
            <i class="bi bi-trash"></i>
            Remover
          </button>
        </div>

        <span class="my-auto me-2 text-secondary">|</span>

        <div>
          <button type="button" onclick="showConfirmationModal()" class="highlighted-btn-sm highlight-success" data-bs-toggle="modal" data-bs-target="#confirmationModal">
            <i class="bi bi-save2 me-1"></i>
            Salvar
          </button>
        </div>
      </div>

      <div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width: 800px;">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Confirmação de Edição</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
              
            <div class="modal-body" id="modalContent"></div>

            <div class="modal-footer">
              <button type="button" class="highlighted-btn-sm highlight-grey" data-bs-dismiss="modal">
                <i class="bi bi-x-lg"></i>
                Cancelar
              </button>

              <button type="button" onclick="submitForm()" class="highlighted-btn-sm highlight-success" id="btnEdit">
                <i class="bi bi-save2 me-1"></i>
                Confirmar Edição
              </button>
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