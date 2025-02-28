@extends('layouts.app')
<link rel="stylesheet" href="{{ asset('css/edit.css') }}">
<script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
@section('content')
    @section('title')
        {{ 'Editar Controle Sugerido' }}
    @endsection

    @if (session('error'))
        <script>
            alert('{{ session('error') }}');
        </script>
    @endif

    <div class="error-message alertShow pt-4">
        @if ($errors->any())
            <div class="alert alert-danger d-flex justify-content-center">
                @foreach ($errors->all() as $error)
                    <span class="text-center">Houve um erro ao editar esse controle sugerido</span>
                @endforeach
            </div>
        @endif
    </div>

    <div class="form-wrapper1">
        <div class="form_create border">
            <h3 style="text-align: center; margin-bottom: 20px;">
                Editar Controle Sugerido
            </h3>
            <hr>

            <form action="{{ route('riscos.monitoramento', ['id' => $monitoramento->id]) }}" method="post"
                id="formEditMonitoramento" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" name="monitoramento_id" value="{{ $monitoramento->id }}">

                <div class="row g-3">
                    <div class="col-sm-12">
                        <label for="monitoramentoControleSugerido-{{ $monitoramento->id }}" class="form-label">Controle
                            Sugerido:</label>
                        <textarea class="form-control" id="monitoramentoControleSugerido-{{ $monitoramento->id }}"
                            name="monitoramentoControleSugerido"
                            required>{{ old('monitoramentoControleSugerido', $monitoramento->monitoramentoControleSugerido) }}</textarea>
                    </div>
                </div>

                <div class="row g-3">
                    <div class="col-sm-6">
                        <label for="statusMonitoramento-{{ $monitoramento->id }}" class="form-label">Status:</label>
                        <select class="form-select" id="statusMonitoramento-{{ $monitoramento->id }}"
                            name="statusMonitoramento" required @if(auth()->user()->unidade->unidadeTipoFK != 1) disabled
                            @endif>
                            <option value="NÃO IMPLEMENTADA" {{ old('statusMonitoramento', $monitoramento->statusMonitoramento) == 'NÃO IMPLEMENTADA' ? 'selected' : '' }}>
                                NÃO IMPLEMENTADA</option>
                            <option value="EM IMPLEMENTAÇÃO" {{ old('statusMonitoramento', $monitoramento->statusMonitoramento) == 'EM IMPLEMENTAÇÃO' ? 'selected' : '' }}>
                                EM IMPLEMENTAÇÃO</option>
                            <option value="IMPLEMENTADA PARCIALMENTE" {{ old('statusMonitoramento', $monitoramento->statusMonitoramento) == 'IMPLEMENTADA PARCIALMENTE' ? 'selected' : '' }}>
                                IMPLEMENTADA PARCIALMENTE</option>
                            <option value="IMPLEMENTADA" {{ old('statusMonitoramento', $monitoramento->statusMonitoramento) == 'IMPLEMENTADA' ? 'selected' : '' }}>
                                IMPLEMENTADA</option>
                        </select>
                        @if(auth()->user()->unidade->unidadeTipoFK != 1)
                            <input type="hidden" name="statusMonitoramento"
                                value="{{ old('statusMonitoramento', $monitoramento->statusMonitoramento) }}">
                        @endif
                    </div>

                    <div class="col-sm-6">
                        <label for="isContinuo-{{ $monitoramento->id }}" class="form-label">É Contínuo?</label>
                        <select class="form-select" id="isContinuo-{{ $monitoramento->id }}" name="isContinuo" required>
                            <option value="0" {{ old('isContinuo', $monitoramento->isContinuo) == 0 ? 'selected' : '' }}>
                                Não</option>
                            <option value="1" {{ old('isContinuo', $monitoramento->isContinuo) == 1 ? 'selected' : '' }}>
                                Sim</option>
                        </select>
                    </div>
                </div>

                <div class="row g-3">
                    <div class="col-sm-6">
                        <label for="inicioMonitoramento-{{ $monitoramento->id }}" class="form-label">Início:</label>
                        <input type="date" class="form-control" id="inicioMonitoramento-{{ $monitoramento->id }}"
                            name="inicioMonitoramento"
                            value="{{ old('inicioMonitoramento', $monitoramento->inicioMonitoramento instanceof \Carbon\Carbon ? $monitoramento->inicioMonitoramento->format('Y-m-d') : $monitoramento->inicioMonitoramento) }}"
                            required>
                    </div>

                    <div class="col-sm-6" id="fimMonitoramentoContainer">
                        <label for="fimMonitoramento-{{ $monitoramento->id }}" class="form-label">Fim:</label>
                        <input type="date" class="form-control" id="fimMonitoramento-{{ $monitoramento->id }}"
                            name="fimMonitoramento"
                            value="{{ old('fimMonitoramento', $monitoramento->fimMonitoramento instanceof \Carbon\Carbon ? $monitoramento->fimMonitoramento->format('Y-m-d') : $monitoramento->fimMonitoramento) }}">
                    </div>
                </div>

                <div class="row g-3">
                    <div class="col-sm-12">
                        <label for="anexoMonitoramento-{{ $monitoramento->id }}" class="form-label">Anexo:</label>
                        <input type="file" class="form-control" id="anexoMonitoramento-{{ $monitoramento->id }}"
                            name="anexoMonitoramento">
                    </div>
                </div>

                <hr class="mt-4">

                <div class="d-flex justify-content-center pt-2">
                    <div class="blue-btn1">
                        <a href="{{ route('riscos.index') }}" style="text-decoration: none; color: #fff;">Voltar</a>
                    </div>

                    <div>
                        <button type="button" onclick="showConfirmationModal()" class="green-btn">Salvar Edição</button>
                    </div>
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

    <script>
        function showConfirmationModal() {
            let monitoramentoControleSugerido = CKEDITOR.instances[
                'monitoramentoControleSugerido-{{ $monitoramento->id }}'].getData();
            let statusMonitoramento = document.getElementById('statusMonitoramento-{{ $monitoramento->id }}').value;
            let isContinuo = document.getElementById('isContinuo-{{ $monitoramento->id }}').value;
            let inicioMonitoramento = document.getElementById('inicioMonitoramento-{{ $monitoramento->id }}').value;
            let fimMonitoramento = document.getElementById('fimMonitoramento-{{ $monitoramento->id }}').value;


            function formatDate(dateString) {
                if (!dateString) return 'N/A';
                const [year, month, day] = dateString.split('-');
                return `${day}/${month}/${year}`;
            }


            let formattedInicioMonitoramento = formatDate(inicioMonitoramento);
            let formattedFimMonitoramento = formatDate(fimMonitoramento);


            let modalContent = `

                    <div class="row g-3">
                        <div class="col-sm-12">
                            <span>Controle Sugerido:</span>
                            <textarea id="modalControleSugerido" class="form-control" rows="4">${monitoramentoControleSugerido}</textarea>
                        </div>
                    </div>

                    <div class="row g-3 mt-1">
                        <div class="col-sm-6">
                            <span>Situação:</span>
                            <input type="text" class="form-control" value="${statusMonitoramento}" readonly>
                        </div>

                        <div class="col-sm-6">
                            <span>É continuo?</span>
                            <input type="text" class="form-control" value="${isContinuo === '1' ? 'Sim' : 'Não'}" readonly>
                        </div>
                    </div>

                    <div class="row g-3 mt-1 mb-2">
                        <div class="col-sm-6">
                            <span>Início:</span>
                            <input type="text" class="form-control" value="${formattedInicioMonitoramento}" readonly>
                        </div>
                        <div class="col-sm-6">
                            <span>Fim:</span>
                            <input type="text" class="form-control" value="${formattedFimMonitoramento}" readonly>
                        </div>
                    </div>
                `;


            document.getElementById('modalContent').innerHTML = modalContent;

            CKEDITOR.replace('modalControleSugerido', {
                extraPlugins: 'wordcount',
                wordcount: {
                    showCharCount: true,
                    maxCharCount: 10000,
                    maxCharCountMsg: 'Você atingiu o limite máximo de caracteres permitidos.',
                    charCountMsg: 'Caracteres restantes: {0}'
                }
            });


            let confirmationModal = new bootstrap.Modal(document.getElementById('confirmationModal'));
            confirmationModal.show();
        }


        function toggleFimMonitoramento() {
            const isContinuo = document.getElementById('isContinuo-{{ $monitoramento->id }}').value;
            const fimMonitoramentoContainer = document.getElementById('fimMonitoramentoContainer');
            const fimMonitoramentoInput = document.getElementById('fimMonitoramento-{{ $monitoramento->id }}');

            if (isContinuo === '1') {
                fimMonitoramentoContainer.style.display = 'none';
                fimMonitoramentoInput.value = '';
            } else {

                fimMonitoramentoContainer.style.display = 'block';
            }
        }


        document.addEventListener('DOMContentLoaded', function () {
            toggleFimMonitoramento();
        });


        document.getElementById('isContinuo-{{ $monitoramento->id }}').addEventListener('change', toggleFimMonitoramento);

        CKEDITOR.replace('monitoramentoControleSugerido-{{ $monitoramento->id }}', {
            extraPlugins: 'wordcount',
            wordcount: {
                showCharCount: true,
                maxCharCount: 10000,
                maxCharCountMsg: 'Você atingiu o limite máximo de caracteres permitidos.',
                charCountMsg: 'Caracteres restantes: {0}'
            }
        });

        function submitForm() {
            document.getElementById('formEditMonitoramento').submit();
        }

    </script>

    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>

@endsection