@extends('layouts.app')
@section('title') {{ 'Editar Formulário de Risco' }} @endsection
@section('content')

<link rel="stylesheet" href="{{ asset('css/edit.css') }}">
<link rel="stylesheet" href="{{ asset('css/buttons.css') }}">
<link rel="stylesheet" href="{{ asset('css/main.css') }}">

<x-alert-toast/>

<script src="{{ asset('ckeditor/ckeditor.js') }}"></script>

<div class="container pt-5" style="max-width: 800px;">
  <div class="col-12 border box-shadow">
    <h5 class="text-center mb-4">Editar Formulário de Risco</h5>

    <form action="{{ route('riscos.update', ['id' => $risco->id]) }}" method="post" id="formCreate">
      @csrf
      @method('PUT')

      <input type="hidden" name="risco_id" value="{{ $risco->id }}">

      <div class="row g-3 mb-4">
        <div class="col-12 col-sm-4 col-md-4">
          <label for="name">Insira o Ano:</label>
          <input type="text" id="riscoAno" name="riscoAno" class="form-control input-enabled dataValue" value="{{ $risco->riscoAno }}" minlength="4" maxlength="4">
        </div>

        <div class="col-12 col-sm-8 col-md-8">
          <label for="name">Responsável do Risco:</label>
          <input type="text" id="responsavelRisco" name="responsavelRisco" class="form-control input-enabled dataValue" value="{{ $risco->responsavelRisco ?? old('responsavelRisco') }}" maxlength="100">
        </div>
      </div>

      <div class="col-12 mb-4">
        <label id="first" for="riscoEvento">Evento:</label>
        <textarea name="riscoEvento" class="textInput" required>{{ $risco->riscoEvento ?? old('riscoEvento') }}</textarea>
      </div>
        
      <div class="col-12 mb-4">
        <label for="riscoCausa">Causa:</label>
        <textarea name="riscoCausa" class="textInput" required>{{ $risco->riscoCausa ?? old('riscoCausa') }}</textarea>
      </div>
        
      <div class="col-12 mb-4">
        <label for="riscoConsequencia">Consequência:</label>
        <textarea name="riscoConsequencia" class="textInput" required>{{ $risco->riscoConsequencia ?? old('riscoConsequencia') }}</textarea>
      </div>
        
      <div class="row g-3">
        <div class="col-12 col-sm-4 col-md-4">
          <label for="probabilidade">
            Probabilidade:
          </label>

          <input type="number" name="probabilidade" id="probabilidade" class="form-control input-enabled" min="1" max="5" required value="{{ old('probabilidade', $risco->probabilidade) }}">
        </div>

        <div class="col-12 col-sm-4 col-md-4">
          <label for="impacto">
            Impacto:
          </label>

          <input type="number" name="impacto" id="impacto" class="form-control input-enabled" min="1" max="5" required value="{{ old('impacto', $risco->impacto) }}">
        </div>

        <div class="col-12 col-sm-4 col-md-4">
          <label for="nivel_de_risco">Nível de Risco (automático):</label>
          <div id="riscoVisual" class="form-control input-disabled">
            <span id="riscoLabel">-</span>
          </div>

          <input type="hidden" name="nivel_de_risco" id="nivel_de_risco" value="{{ old('nivel_de_risco', $risco->nivel_de_risco) }}" required>
        </div>

        <div class="col-12 col-sm-12 m-0 mt-1">
          <div class="text-muted" style="font-size: 12px;">
            <i class="bi bi-chat-dots"></i>
            Nota: Os valores de <span class="fw-semibold">probabilidade</span> e <span class="fw-semibold">impacto</span> devem estar entre <span class="fw-semibold">1 e 5</span>.
          </div>
        </div>

        <div class="col-12 col-sm-12 col-md-12">
          <label for="unidadeId">Unidade:</label>
          <select name="unidadeId" class="form-control form-select" required>
            <option selected disabled>Selecione uma unidade</option>
            @foreach ($unidades as $unidade)
              <option value="{{ $unidade->id }}" {{ isset($risco) && $risco->unidadeId == $unidade->id ? 'selected' : '' }}>
                {{ $unidade->unidadeNome }}
              </option>
            @endforeach
          </select>
        </div>
      </div>

      <div class="d-flex justify-content-end pt-4">
        <a href="{{ route('riscos.edit-monitoramentos', ['id' => $risco->id]) }}" class="highlighted-btn-sm highlight-blue text-decoration-none me-2">
          <i class="bi bi-plus-lg"></i>
          Adicionar Monitoramentos
        </a>
          
        <button type="button" onclick="showConfirmationModal()" class="highlighted-btn-sm highlight-success">
          <i class="bi bi-save2 me-1"></i>
          Salvar Edição
        </button>
      </div>

      <div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="confirmationModalLabel">Confirmação de Edição</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
              <div id="modalContent">
                <!-- Conteúdo do modal será inserido dinamicamente aqui -->
              </div>
            </div>

            <div class="modal-footer">
              <button type="button" data-bs-dismiss="modal" class="highlighted-btn-sm highlight-grey">
                <i class="bi bi-x-lg"></i>
                Cancelar
              </button>

              <button type="button" onclick="submitForm()" class="highlighted-btn-sm highlight-success">
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

<x-back-button/>

<script src="{{ asset('js/riscos/editNivelRisco.js') }}"></script>
<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('js/editRisco.js') }}"></script>
@endsection