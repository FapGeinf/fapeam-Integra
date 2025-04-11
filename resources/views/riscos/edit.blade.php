@extends('layouts.app')
<link rel="stylesheet" href="{{ asset('css/edit.css') }}">
<script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
<script src="{{ asset('js/auto-dismiss.js') }}"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
@section('content')

@section('title') {{ 'Editar Formulário' }} @endsection

@if (session('error'))
    <script>
        alert('{{ session(' error ') }}');
    </script>
@endif

<div class="error-message alertShow pt-4">
    @if ($errors->any())
        <div class="alert alert-danger text-center auto-dismiss">
            @foreach ($errors->all() as $error)
                <span class="text-center">Houve um erro ao editar esse risco</span>
            @endforeach
        </div>
    @endif
</div>

<div class="form-wrapper pt-4">
    <div class="form_create border">
        <h3 class="text-center mb-5">Editar Formulário de Risco</h3>

        <form action="{{ route('riscos.update', ['id' => $risco->id]) }}" method="post" id="formCreate">
            @csrf
            @method('PUT')
            <input type="hidden" name="risco_id" value="{{ $risco->id }}">

            <div class="row g-3 mb-4">
                <div class="col-12 col-sm-4 col-md-4 mQuery">
                    <label for="name">Insira o Ano:</label>
                    <input type="text" id="riscoAno" name="riscoAno" class="form-control input-enabled dataValue" value="{{ $risco->riscoAno }}" minlength="4" maxlength="4">
                </div>

                <div class="col-12 col-sm-8 col-md-8 mQuery">
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
                    <label for="probabilidade">Probabilidade:<span class="asterisco">*</span></label>
                    <input type="number" name="probabilidade" id="probabilidade" class="form-control input-enabled" min="1" max="5" required value="{{ old('probabilidade', $risco->probabilidade) }}">
                </div>

                <div class="col-12 col-sm-4 col-md-4">
                    <label for="impacto">Impacto:<span class="asterisco">*</span></label>
                    <input type="number" name="impacto" id="impacto" class="form-control input-enabled" min="1" max="5" required value="{{ old('impacto', $risco->impacto) }}">
                </div>

                <div class="col-12 col-sm-4 col-md-4">
                    <label for="nivel_de_risco">Nível de Risco (automático):</label>
                    <div id="riscoVisual" class="form-control input-disabled" style="height: 38px; font-weight: bold;">
                        <span id="riscoLabel">-</span>
                    </div>

                    <input type="hidden" name="nivel_de_risco" id="nivel_de_risco" value="{{ old('nivel_de_risco', $risco->nivel_de_risco) }}" required>
                </div>

                <div class="col-12 col-sm-12 m-0 mt-1">
                    <small class="text-muted">
                        <span class="asterisco">*</span>
                        Os valores de <strong>probabilidade</strong> e <strong>impacto</strong>devem estar entre <strong>1 e 5</strong>.
                    </small>
                </div>

                <div class="col-12 col-sm-12 col-md-12">
                    <label for="unidadeId">Unidade:</label>
                    <select name="unidadeId" class="form-select form-control" required>
                        <option selected disabled>Selecione uma unidade</option>
                        @foreach ($unidades as $unidade)
                            <option value="{{ $unidade->id }}" {{ isset($risco) && $risco->unidadeId == $unidade->id ? 'selected' : '' }}>
                                {{ $unidade->unidadeNome }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <script src="{{ asset('js/riscos/editNivelRisco.js') }}"></script>

            <hr class="mx-auto pb-3">

            <div class="d-flex justify-content-center">
                <a href="{{ route('riscos.edit-monitoramentos', ['id' => $risco->id]) }}" class="blue-btn">
                    Adicionar Monitoramentos
                </a>
                
                <button type="button" onclick="showConfirmationModal()" class="green-btn">Salvar Edição</button>
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
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="button" onclick="submitForm()" class="btn btn-primary">Salvar</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<x-back-button />
<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('js/editRisco.js') }}"></script>
@endsection