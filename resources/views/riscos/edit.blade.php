@extends('layouts.app')
<link rel="stylesheet" href="{{ asset('css/edit.css') }}">
<script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
@section('content')
@section('title')
    {{ 'Editar Formulário' }}
@endsection

    @if (session('error'))
        <script>
            alert('{{ session(' error ') }}');
        </script>
    @endif

    <div class="error-message alertShow pt-4">
        @if ($errors->any())
            <div class="alert alert-danger d-flex justify-content-center">
                @foreach ($errors->all() as $error)
                    <span class="text-center">Houve um erro ao editar esse risco</span>
                @endforeach
            </div>
        @endif
    </div>

    <div class="form-wrapper pt-4">
        <div class="form_create border">
            <h3 style="text-align: center; margin-bottom: 20px;">
                Editar Formulário de Risco
            </h3>
            <hr>

            <form action="{{ route('riscos.update', ['id' => $risco->id]) }}" method="post" id="formCreate">
                @csrf
                @method('PUT')
                <input type="hidden" name="risco_id" value="{{ $risco->id }}">

                <div class="row g-3 mb-3">
                    <div class="col-sm-4 col-md-4 mQuery">
                        <label for="name">Insira o Ano:</label>
                        <input type="text" id="riscoAno" name="riscoAno" class="form-control dataValue"
                            value="{{ $risco->riscoAno }}" minlength="4" maxlength="4">
                    </div>

                    <div class="col-sm-8 col-md-8 mQuery">
                        <label for="name">Responsável do Risco:</label>
                        <input type="text" id="responsavelRisco" name="responsavelRisco"
                            class="form-control dataValue"
                            value="{{ $risco->responsavelRisco ?? old('responsavelRisco') }}" maxlength="100">
                    </div>
                </div>

                <label id="first" for="riscoEvento">Evento:</label>
                <textarea name="riscoEvento" class="textInput" required>{{ $risco->riscoEvento ?? old('riscoEvento') }}</textarea>

                <label for="riscoCausa">Causa:</label>
                <textarea name="riscoCausa" class="textInput" required>{{ $risco->riscoCausa ?? old('riscoCausa') }}</textarea>

                <label for="riscoConsequencia">Consequência:</label>
                <textarea name="riscoConsequencia" class="textInput" required>{{ $risco->riscoConsequencia ?? old('riscoConsequencia') }}</textarea>


                <div class="row g-3">

                    <div class="col-sm-3 col-md-3">
                        <label style="white-space: nowrap;" for="nivel_de_risco">Nível de Risco:</label>
                        <select name="nivel_de_risco" id="nivel_de_risco" class="form-select form-control" required>
                            <option value="1" @selected(old('nivel_de_risco', $risco->nivel_de_risco) == 1)>Baixo</option>
                            <option value="2" @selected(old('nivel_de_risco', $risco->nivel_de_risco) == 2)>Médio</option>
                            <option value="3" @selected(old('nivel_de_risco', $risco->nivel_de_risco) == 3)>Alto</option>
                        </select>
                    </div>

                    <div class="col-sm-9 col-md-9">
                        <label for="unidadeId">Unidade:</label>
                        <select name="unidadeId" class="form-select form-control" required>
                            <option selected disabled>Selecione uma unidade</option>
                            @foreach ($unidades as $unidade)
                                <option value="{{ $unidade->id }}"
                                    {{ isset($risco) && $risco->unidadeId == $unidade->id ? 'selected' : '' }}>
                                    {{ $unidade->unidadeNome }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>



                <hr id="hr5">

                {{-- <span id="tip">
                                <i class="bi bi-exclamation-circle-fill"></i>
                                Dica: Revise sua edição antes de salvar
                            </span> --}}


                <div class="d-flex justify-content-center">
                    {{-- <div class="me-1"> --}}
                        <a href="{{ route('riscos.edit-monitoramentos', ['id' => $risco->id]) }}"
                            class="blue-btn">Adicionar Monitoramentos</a>
                    {{-- </div> --}}

                    {{-- <div> --}}
                        <button type="button" onclick="showConfirmationModal()" class="green-btn">Salvar
                            Edição</button>
                    {{-- </div> --}}
                </div>


                <div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="confirmationModalLabel">Confirmação de Edição</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div id="modalContent">
                                    <!-- Conteúdo do modal será inserido dinamicamente aqui -->
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary"
                                    data-bs-dismiss="modal">Cancelar</button>
                                <button type="button" onclick="submitForm()" class="btn btn-primary">Salvar</button>
                            </div>
                        </div>
                    </div>
                </div>


            </form>
        </div>
    </div>
    <x-back-button/>
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/editRisco.js') }}"></script>
@endsection
