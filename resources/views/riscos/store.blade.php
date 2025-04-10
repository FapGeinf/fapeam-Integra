@extends('layouts.app')

@section('content')

@section('title')
    {{ 'Novo Risco Inerente' }}
@endsection

<script src="/ckeditor/ckeditor.js"></script>
<link rel="stylesheet" href="{{ asset('css/edit.css') }}">
<script src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>
<script src="{{ asset('js/mascaras/jquery.mask.min.js') }}"></script>
<script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
<script src="{{ asset('js/auto-dismiss.js') }}"></script>

<style>
    .error-box {
        background-color: #f8d7da;
        border: 1px solid #f5c6cb;
        border-radius: .25rem;
        padding: 1rem;
        margin-bottom: 1rem;
    }

    .error-box p {
        margin: 0;
        color: #721c24;
    }
</style>

<body>
    <div class="error-message pt-5">
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

    <div class="form-wrapper pt-4 paddingLeft">
        <div class="form_create border">
            <h3 style="text-align: center; margin-bottom:5px;">
                Novo Evento de Risco Inerente
            </h3>

            <span class="tipWarning mb-3">
                <span class="asteriscoTop">*</span>
                Campos obrigatórios
            </span>

            <form action="{{ route('riscos.store') }}" method="post" id="formCreate" enctype="multipart/form-data">
                @csrf

                <div class="row g-3">
                    <div class="col-12 col-sm-4 col-md-3">
                        <label for="riscoAno">Insira o Ano:<span class="asterisco">*</span></label>
                        <input type="text" id="riscoAno" name="riscoAno" class="form-control dataValue"
                            placeholder="0000" minlength="4" maxlength="4" required>
                    </div>

                    <div class="col-12 col-sm-4 col-md-9 selectUnidade">
                        <label for="unidadeId">Unidade:<span class="asterisco">*</span></label>
                        <select name="unidadeId" class="form-control form-select" required>
                            <option selected disabled>Escolha uma unidade</option>
                            @foreach ($unidades as $unidade)
                                <option value="{{ $unidade->id }}">{{ $unidade->unidadeNome }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <label class="dataLim" for="responsavel">Responsável:<span class="asterisco">*</span></label>
                <input type="text" name="responsavelRisco" id="responsavel" class="textInput form-control"
                    placeholder="Ex: Fulano da Silva Pompeo" maxlength="100" required>

                <label for="riscoEvento">Evento de Risco Inerente:<span class="asterisco">*</span></label>
                <textarea id="riscoEvento" name="riscoEvento" class="textInput" required></textarea>

                <label for="riscoCausa" class="mt-3">Causa do Risco:<span class="asterisco">*</span></label>
                <textarea id="riscoCausa" name="riscoCausa" class="textInput" required></textarea>

                <label for="riscoConsequencia" class="mt-3">Consequência do Risco:<span class="asterisco">*</span></label>
                <textarea id="riscoConsequencia" name="riscoConsequencia" class="textInput" required></textarea>

                <div class="row g-3 mt-3">

                    <div class="col-sm-6 col-md-6">
                        <label for="probabilidade">Probabilidade:<span class="asterisco">*</span></label>
                        <input type="number" name="probabilidade" id="probabilidade" class="form-control" min="1"
                            max="5" required value="{{ old('probabilidade') }}" style="background-color: #f0f0f0;">
                    </div>

                    <div class="col-sm-6 col-md-6">
                        <label for="impacto">Impacto:<span class="asterisco">*</span></label>
                        <input type="number" name="impacto" id="impacto" class="form-control" min="1" max="5" required value="{{ old('impacto') }}" style="background-color: #f0f0f0;">
                    </div>

                    <div class="col-sm-12">
                        <small class="text-muted">* Os valores de <strong>probabilidade</strong> e
                            <strong>impacto</strong> devem estar entre <strong>1 a 5</strong>.</small>
                    </div>

                    <div class="col-sm-6 col-md-6">
                        <label>Nível de Risco (automático):</label>
                        <div id="riscoVisual" class="form-control" style="height: 38px; font-weight: bold; background-color: #f0f0f0;">
                            <span id="riscoLabel">-</span>
                        </div>
                    </div>

                    <input type="hidden" name="nivel_de_risco" id="nivel_de_risco" required>

                </div>

                <script src="{{ asset('js/riscos/nivelRisco.js') }}"></script>

                <div id="monitoramentosDiv" class="monitoramento"></div>

                <hr>

                <div class="mt-3 text-end">
                    <input type="button" onclick="addMonitoramentos()" value="Adicionar Controle Sugerido"
                        class="blue-btn">
                    <button type="button" onclick="showConfirmationModal()" class="green-btn green-btn-store"
                        data-bs-toggle="modal" data-bs-target="#confirmationModal">Salvar</button>
                </div>

                <div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="confirmationModalLabel">Confirmação de envio de Relatório
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div id="modalContent">
                                    <!-- Conteúdo do modal será inserido dinamicamente aqui -->
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                                <button type="submit" class="green-btn green-btn-store" id="saveModal">Salvar</button>
                            </div>
                        </div>
                    </div>
                </div>

            </form>
        </div>
    </div>

    <x-back-button />

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
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/storeRisco.js') }}"></script>









</body>
@endsection