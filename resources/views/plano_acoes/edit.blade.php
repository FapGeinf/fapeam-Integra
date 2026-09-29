@extends('layouts.app')
@section('title') {{ 'Editar Plano de Ação' }} @endsection
@section('content')

    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('css/buttons.css') }}">
    <link rel="stylesheet" href="{{ asset('css/edit.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/pt.js"></script>

    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('js/choices/plano-acao.js') }}"></script>
    <script src="{{ asset('js/dates/plano-acao-datas.js') }}"></script>

    <x-alert-toast />

    <div class="container py-5" style="max-width: 780px;">
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">

            <div class="card-header bg-white border-bottom py-3 px-4">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h5 class="fw-bold text-dark mb-0"><i class="bi bi-pencil-square text-primary me-2"></i> Editar
                            Plano de Ação</h5>
                        <small class="text-muted">Atualize as informações do plano de ação estratégico abaixo.</small>
                    </div>
                    <span class="badge bg-light text-secondary border px-2 py-1"><span class="text-danger">*</span>
                        Obrigatório</span>
                </div>
            </div>


            <div class="card-body p-4 bg-light bg-opacity-10">
                <form action="{{ route('plano-acoes.update', $planoAcao->id) }}" method="POST" id="formUpdatePlanoAcao">
                    @csrf
                    @method('PUT')

                    <div class="row g-4">
                        <!-- Eixo -->
                        <div class="col-12">
                            <label for="eixos" class="form-label fw-semibold text-secondary small">
                                <span class="text-danger">*</span> EIXOS ESTRATÉGICOS (Selecione um ou mais)
                            </label>
                            <select class="form-select input-enabled border-grey pointer js-choice" id="eixos"
                                name="eixos[]" multiple required>
                                <option value="">Selecione os eixos...</option>
                                @foreach($eixos as $eixo)
                                    <option value="{{ $eixo->id }}" {{ (is_array(old('eixos')) ? in_array($eixo->id, old('eixos')) : $planoAcao->eixos->contains($eixo->id)) ? 'selected' : '' }}>
                                        {{ $eixo->nome }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-12">
                            <label for="objetivo" class="form-label fw-semibold text-secondary small">
                                <span class="text-danger">*</span> OBJETIVO
                            </label>
                            <textarea class="form-control input-enabled" id="objetivo" name="objetivo" rows="3"
                                placeholder="Descreva o objetivo principal..."
                                required>{{ old('objetivo', $planoAcao->objetivo) }}</textarea>
                        </div>


                        <div class="col-12">
                            <label for="descricao_acao" class="form-label fw-semibold text-secondary small">
                                <span class="text-danger">*</span> DESCRIÇÃO DA AÇÃO
                            </label>
                            <textarea class="form-control input-enabled" id="descricao_acao" name="descricao_acao" rows="3"
                                placeholder="Detalhe a ação que será executada..."
                                required>{{ old('descricao_acao', $planoAcao->descricao_acao) }}</textarea>
                        </div>


                        <div class="col-md-6">
                            <label for="meta" class="form-label fw-semibold text-secondary small">
                                <span class="text-danger">*</span> META
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-white text-muted"><i class="bi bi-bullseye"></i></span>
                                <input type="text" class="form-control input-enabled" id="meta" name="meta"
                                    value="{{ old('meta', $planoAcao->meta) }}" placeholder="Ex: 95% de conclusão" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="bienio" class="form-label fw-semibold text-secondary small">
                                <span class="text-danger">*</span> BIÊNIO
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-white text-muted"><i
                                        class="bi bi-calendar-range"></i></span>
                                <input type="text" class="form-control input-enabled" id="bienio" name="bienio"
                                    value="{{ old('bienio', $planoAcao->bienio) }}" placeholder="Ex: 2024-2025" required>
                            </div>
                        </div>


                        <div class="col-12">
                            <label for="indicador_id" class="form-label fw-semibold text-secondary small">
                                INDICADOR <span class="text-muted fw-normal">(Opcional)</span>
                            </label>
                            <select class="form-select input-enabled border-grey pointer js-choice" id="indicador_id"
                                name="indicador_id">
                                <option value="">Selecione um indicador...</option>
                                @foreach($indicadores as $indicador)
                                    <option value="{{ $indicador->id }}" {{ old('indicador_id', $planoAcao->indicador_id) == $indicador->id ? 'selected' : '' }}>
                                        {{ $indicador->nomeIndicador }}
                                    </option>
                                @endforeach
                            </select>
                        </div>


                        <div class="col-12">
                            <label for="procedimentos"
                                class="form-label fw-semibold text-secondary small">PROCEDIMENTOS</label>
                            <textarea class="form-control input-enabled" id="procedimentos" name="procedimentos" rows="2"
                                placeholder="Procedimentos operacionais (opcional)...">{{ old('procedimentos', $planoAcao->procedimentos) }}</textarea>
                        </div>


                        <div class="col-12">
                            <label for="metricas" class="form-label fw-semibold text-secondary small">MÉTRICAS</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white text-muted"><i class="bi bi-graph-up"></i></span>
                                <input type="text" class="form-control input-enabled" id="metricas" name="metricas"
                                    value="{{ old('metricas', $planoAcao->metricas) }}"
                                    placeholder="Forma de mensuração...">
                            </div>
                        </div>

                        <div class="col-md-12">
                            <label for="prazo_execucao" class="form-label fw-semibold text-secondary small">PRAZO DE
                                EXECUÇÃO</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white text-muted"><i
                                        class="bi bi-calendar-event"></i></span>
                                <input type="date" class="form-control input-enabled" id="prazo_execucao"
                                    name="prazo_execucao" value="{{ old('prazo_execucao', $planoAcao->prazo_execucao) }}">
                            </div>
                        </div>

                        <div class="col-md-12">
                            <label for="responsavel_id" class="form-label fw-semibold text-secondary small">
                                <span class="text-danger">*</span> RESPONSÁVEL
                            </label>
                            <select class="form-select input-enabled border-grey pointer js-choice" id="responsavel_id"
                                name="responsavel_id" required>
                                <option value="">Selecione um responsável...</option>
                                @foreach($usuarios as $usuario)
                                    <option value="{{ $usuario->id }}" {{ old('responsavel_id', $planoAcao->responsavel_id) == $usuario->id ? 'selected' : '' }}>
                                        {{ $usuario->name }} - {{ $usuario->unidade->unidadeSigla }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end align-items-center mt-4 pt-3 border-top">
                        <button type="button" onclick="showConfirmationModal()"
                            class="highlighted-btn-sm highlight-primary px-4 py-2 shadow-sm">
                            <i class="bi bi-check2-circle me-2"></i> Atualizar Plano de Ação
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal de Confirmação de Atualização -->
    <div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width: 680px;">
            <div class="modal-content border-0 shadow rounded-4">
                <div class="modal-header border-bottom px-4 py-3">
                    <h5 class="modal-title fw-bold text-dark" id="confirmationModalLabel">
                        <i class="bi bi-info-circle text-primary me-2"></i> Confirmação de Atualização
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body p-4">
                    <div id="modalContent"></div>
                </div>

                <div class="modal-footer border-top px-4 py-3 bg-light rounded-bottom-4">
                    <button type="button" class="highlighted-btn-sm highlight-grey px-3" data-bs-dismiss="modal">
                        <i class="bi bi-arrow-left me-1"></i> Voltar e corrigir
                    </button>

                    <button type="button" onclick="formSubmit()" class="highlighted-btn-sm highlight-primary px-4"
                        id="submitConfirmationBtn">
                        <i class="bi bi-check-lg me-1"></i> Confirmar atualização
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/modais/editPlanoAcao.js') }}"></script>
    <script src="{{ asset('js/editor/EditorPlanoAcao.js') }}"></script>
    <script src="{{ asset('js/choices/plano-acao.js') }}"></script>
    <script src="{{ asset('js/dates/plano-acao-datas.js') }}"></script>
    <x-back-button />
@endsection