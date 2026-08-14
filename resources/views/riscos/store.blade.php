@extends('layouts.app')
@section('title') {{ 'Novo Risco Inerente' }} @endsection
@section('content')

<script src="/ckeditor/ckeditor.js"></script>
<link rel="stylesheet" href="{{ asset('css/edit.css') }}">
<link rel="stylesheet" href="{{ asset('css/show.css') }}">
<link rel="stylesheet" href="{{ asset('css/buttons.css') }}">
<script src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>
<script src="{{ asset('js/mascaras/jquery.mask.min.js') }}"></script>
<script src="{{ asset('ckeditor/ckeditor.js') }}"></script>

<div class="container pt-5" style="max-width: 800px;">
  <div class="col-12 border box-shadow">
    <h5 class="text-center">Novo Evento de Risco Inerente</h5>

    <div class="text-center text-muted mb-3">
      <span class="text-danger">*</span>
      <span class="text-secondary text13">Campos obrigatórios</span>
    </div>

    <form action="{{ route('riscos.store') }}" method="post" id="formCreate" enctype="multipart/form-data">
      @csrf

      <div class="row g-3">
        <div class="col-12 col-sm-4 col-md-3">
          <label for="riscoAno">
            <span class="text-danger">*</span>
            Insira o Ano:
          </label>

          <input 
            type="text"
            id="riscoAno" 
            name="riscoAno" 
            class="form-control input-enabled"
            placeholder="0000" 
            minlength="4" maxlength="4" required
          >
        </div>

        <div class="col-12 col-sm-4 col-md-9 selectUnidade">
          <label for="unidadeId">
            <span class="text-danger">*</span>
            Unidade:
          </label>

          <select name="unidadeId" class="form-control form-select pointer" required>
            <option selected disabled>Escolha uma unidade</option>
            @foreach ($unidades as $unidade)
              <option value="{{ $unidade->id }}">{{ $unidade->unidadeNome }}</option>
            @endforeach
          </select>
        </div>

        <div class="col-12">
          <label for="responsavel">
            <span class="text-danger">*</span>
            Responsável:
          </label>

          <input 
            type="text" 
            name="responsavelRisco" 
            id="responsavel" 
            class="form-control input-enabled"
            placeholder="Ex: Fulano da Silva Pompeo" maxlength="100" required
          >
        </div>       
        
        <div class="col-12">
          <label for="riscoEvento">
            <span class="text-danger">*</span>
            Evento de risco inerente:
          </label>

          <textarea id="riscoEvento" name="riscoEvento" required></textarea>          
        </div>

        <div class="col-12">
          <label for="riscoCausa">
            <span class="text-danger">*</span>
            Causa do Risco:
          </label>

          <textarea id="riscoCausa" name="riscoCausa" required></textarea>
        </div>

        <div class="col-12">
          <label for="riscoConsequencia">
            <span class="text-danger">*</span>
            Consequência do Risco:
          </label>
          
          <textarea id="riscoConsequencia" name="riscoConsequencia" required></textarea>          
        </div>

        <div class="col-12 col-sm-4">
          <label for="probabilidade">
            <span class="text-danger">*</span>
            Probabilidade:
          </label>

          <input 
            type="number" 
            name="probabilidade" 
            id="probabilidade" 
            class="form-control input-enabled" min="1"
            max="5" required
            placeholder="0" value="{{ old('probabilidade') }}"
          >

          <small class="text-muted">
            <span class="text-danger">*</span>
            Os valores de <span class="fw-semibold">probabilidade</span> 
            e <span class="fw-semibold">impacto</span> 
            devem estar entre <span class="fw-semibold">1 a 5</span>.
          </small>
        </div>      
        
        <div class="col-12 col-sm-4">
          <label for="impacto">
            <span class="text-danger">*</span>
            Impacto:
          </label>

          <input 
            type="number" 
            name="impacto" 
            id="impacto" 
            class="form-control input-enabled" 
            min="1" max="5" 
            required placeholder="0" 
            value="{{ old('impacto') }}">
        </div>

        <div class="col-12 col-sm-4">
          <label>Nível de Risco (automático):</label>
          <div id="riscoVisual" class="form-control input-disabled">
            <span id="riscoLabel">-</span>
          </div>
        </div>

        <input type="hidden" name="nivel_de_risco" id="nivel_de_risco" required>        
      </div>

      <div id="monitoramentosDiv" class="monitoramento"></div>

      <div class="mt-3 text-end">
        <input type="button" class="highlighted-btn-sm highlight-blue me-1" 
          value="Adicionar controle sugerido" onclick="addMonitoramentos()">

        <button type="button" class="highlighted-btn-sm highlight-success" 
          data-bs-toggle="modal" data-bs-target="#confirmationModal" onclick="showConfirmationModal()">
          <i class="bi bi-save2 me-1"></i>
          Salvar
        </button>
      </div>

      <div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="confirmationModalLabel">Confirmação de envio de relatório</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
              <div id="modalContent"></div>
            </div>

            <div class="modal-footer">
              <button type="button" class="highlighted-btn-sm highlight-grey" data-bs-dismiss="modal">
                <i class="bi bi-x-lg"></i>
                Voltar e editar
              </button>

              <button type="submit" class="highlighted-btn-sm highlight-success" id="saveModal">
                <i class="bi bi-save2 me-1"></i>
                Salvar
              </button>
            </div>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>

<div class="modal fade" id="alertModal" tabindex="-1" aria-labelledby="alertModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="alertModalLabel">Aviso</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
        Adicione pelo menos um monitoramento antes de enviar o formulário.
      </div>

      <div class="modal-footer">
        <button type="button" class="highlighted-btn-sm highlight-grey" data-bs-dismiss="modal">
          <i class="bi bi-x-lg"></i>
          Fechar
        </button>
      </div>
    </div>
  </div>
</div>

<x-back-button/>   

<script src="{{ asset('js/riscos/nivelRisco.js') }}"></script>
<script src="{{ asset('js/storeRisco.js') }}"></script>
@endsection