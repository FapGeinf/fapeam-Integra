@extends('layouts.app')

@section('content')

@section('title')
    {{ 'Novo Risco Inerente' }}
@endsection

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="/ckeditor/ckeditor.js"></script>
    <link rel="stylesheet" href="{{ asset('css/edit.css') }}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
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
</head>

<body>
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

    <div class="form-wrapper pt-4">
        <div class="form_create">
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
                    <div class="col-sm-4 col-md-3">
                        <label for="riscoAno">Insira o Ano:<span class="asterisco">*</span></label>
                        <input type="text" id="riscoAno" name="riscoAno" class="form-control dataValue"
                            placeholder="0000" minlength="4" maxlength="4" required>
                    </div>

                    <div class="col-sm-4 col-md-9 selectUnidade">
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

                <label for="riscoCausa">Causa do Risco:<span class="asterisco">*</span></label>
                <textarea id="riscoCausa" name="riscoCausa" class="textInput" required></textarea>

                <label for="riscoConsequencia">Consequência do Risco:<span class="asterisco">*</span></label>
                <textarea id="riscoConsequencia" name="riscoConsequencia" class="textInput" required></textarea>

                <div class="row g-3">
                    <div class="col-sm-6 col-md-6">
                        <label for="nivel_de_risco">Nivel de Risco:<span class="asterisco">*</span></label>
                        <select name="nivel_de_risco" id="nivel_de_risco" class="form-select" required>
                            <option value="1">Baixo</option>
                            <option value="2">Médio</option>
                            <option value="3">Alto</option>
                        </select>
                    </div>
                </div>



                <div id="monitoramentosDiv" class="monitoramento"></div>

                <hr>

                <div class="mt-3 text-end">
                    <input type="button" onclick="addMonitoramentos()" value="Adicionar Monitoramento"
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
                                <button type="submit" class="green-btn green-btn-store"
                                    id="saveModal">Salvar</button>
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
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var ckeditorConfig = {
                extraPlugins: 'wordcount',
                wordcount: {
                    showCharCount: true,
                    maxCharCount: 10000,
                    maxCharCountMsg: 'Você atingiu o limite máximo de caracteres permitidos.',
                    charCountMsg: 'Caracteres restantes: {0}'
                }
            };

            CKEDITOR.replace('riscoEvento', ckeditorConfig);
            CKEDITOR.replace('riscoCausa', ckeditorConfig);
            CKEDITOR.replace('riscoConsequencia', ckeditorConfig);
        });

        let cont = 0;

        function addMonitoramentos() {
            let monitoramentosDiv = document.getElementById('monitoramentosDiv');

            let monitoramentoContainer = document.createElement('div');
            monitoramentoContainer.classList.add('monitoramento-container');

            let novoEventoTitulo = document.createElement('h4');
            novoEventoTitulo.style.textAlign = 'center';
            novoEventoTitulo.style.marginTop = '1rem';
            novoEventoTitulo.textContent = 'Novo Monitoramento';
            monitoramentoContainer.appendChild(novoEventoTitulo);

            let hrMonitoramento = document.createElement('hr');
            monitoramentoContainer.appendChild(hrMonitoramento);

            let novoMonitoramento = document.createElement('div');
            let monitoramentoId = `monitoramento${cont}`;
            novoMonitoramento.id = monitoramentoId;
            novoMonitoramento.classList.add('monitoramento');
            monitoramentoContainer.appendChild(novoMonitoramento);

            let divLabelDel = document.createElement('div');
            divLabelDel.classList.add('labelDel');

            let label = document.createElement('label');
            label.textContent = `Monitoramento N° ${cont + 1}`;

            let deleteWrapper = document.createElement('div');
            deleteWrapper.style.display = 'flex';
            deleteWrapper.style.alignItems = 'center';
            deleteWrapper.style.gap = '2px';
            deleteWrapper.style.cursor = 'pointer';

            let deleteIcon = document.createElement('i');
            deleteIcon.classList.add('bi', 'bi-trash3-fill', 'text-danger');
            deleteIcon.title = 'Excluir';

            let deleteText = document.createElement('span');
            deleteText.textContent = 'Excluir';
            deleteText.classList.add('text-danger');

            deleteWrapper.appendChild(deleteIcon);
            deleteWrapper.appendChild(deleteText);
            deleteWrapper.onclick = function() {
                monitoramentosDiv.removeChild(monitoramentoContainer);
                cont--;
            };

            divLabelDel.appendChild(label);
            divLabelDel.appendChild(deleteWrapper);
            novoMonitoramento.appendChild(divLabelDel);

            let divControleSugerido = document.createElement('div');
            divControleSugerido.classList = 'form-group';
            novoMonitoramento.appendChild(divControleSugerido);

            let controleSugerido = document.createElement('textarea');
            controleSugerido.name = `monitoramentos[${cont}][monitoramentoControleSugerido]`;
            controleSugerido.placeholder = 'Monitoramento';
            controleSugerido.classList = 'form-control textInput';
            controleSugerido.id = `monitoramentoControleSugerido${cont}`;
            divControleSugerido.appendChild(controleSugerido);


            let divStatusMonitoramento = document.createElement('div');
            divStatusMonitoramento.classList = 'form-group';
            novoMonitoramento.appendChild(divStatusMonitoramento);

            let labelStatusMonitoramento = document.createElement('label');
            labelStatusMonitoramento.textContent = 'Status do Monitoramento:';
            divStatusMonitoramento.appendChild(labelStatusMonitoramento);

            let statusMonitoramento = document.createElement('select');
            statusMonitoramento.name = `monitoramentos[${cont}][statusMonitoramento]`;
            statusMonitoramento.classList = 'form-select';

            let options = [{
                    value: "NÃO IMPLEMENTADA",
                    text: "NÃO IMPLEMENTADA"
                },
                {
                    value: "EM IMPLEMENTAÇÃO",
                    text: "EM IMPLEMENTAÇÃO"
                },
                {
                    value: "IMPLEMENTADA PARCIALMENTE",
                    text: "IMPLEMENTADA PARCIALMENTE"
                },
                {
                    value: "IMPLEMENTADA",
                    text: "IMPLEMENTADA"
                }
            ];

            options.forEach(function(optionData) {
                let option = document.createElement('option');
                option.value = optionData.value;
                option.textContent = optionData.text;
                statusMonitoramento.appendChild(option);
            });

            divStatusMonitoramento.appendChild(statusMonitoramento);

            let divIsContinuo = document.createElement('div');
            divIsContinuo.classList.add('form-group');
            novoMonitoramento.appendChild(divIsContinuo);

            let labelIsContinuo = document.createElement('label');
            labelIsContinuo.textContent = 'Monitoramento Contínuo:';
            divIsContinuo.appendChild(labelIsContinuo);

            let selectIsContinuo = document.createElement('select');
            selectIsContinuo.name = `monitoramentos[${cont}][isContinuo]`;
            selectIsContinuo.classList.add('form-select');

            let optionNao = document.createElement('option');
            optionNao.value = 0;
            optionNao.textContent = 'Não';
            selectIsContinuo.appendChild(optionNao);

            let optionSim = document.createElement('option');
            optionSim.value = 1;
            optionSim.textContent = 'Sim';
            selectIsContinuo.appendChild(optionSim);

            divIsContinuo.appendChild(selectIsContinuo);

            let divRow = document.createElement('div');
            divRow.classList = 'row g-3';
            novoMonitoramento.appendChild(divRow);

            let divInicioMonitoramento = document.createElement('div');
            divInicioMonitoramento.classList = 'col-sm-6 col-md-6';
            divRow.appendChild(divInicioMonitoramento);

            let labelInicioMonitoramento = document.createElement('label');
            labelInicioMonitoramento.textContent = 'Início do Monitoramento:';
            divInicioMonitoramento.appendChild(labelInicioMonitoramento);

            let inputInicioMonitoramento = document.createElement('input');
            inputInicioMonitoramento.type = 'date';
            inputInicioMonitoramento.name = `monitoramentos[${cont}][inicioMonitoramento]`;
            inputInicioMonitoramento.classList = 'form-control textInput dateInput';
            inputInicioMonitoramento.required = true;
            divInicioMonitoramento.appendChild(inputInicioMonitoramento);

            let divFimMonitoramento = document.createElement('div');
            divFimMonitoramento.classList = 'col-sm-6 col-md-6';
            divRow.appendChild(divFimMonitoramento);

            let labelFimMonitoramento = document.createElement('label');
            labelFimMonitoramento.textContent = 'Fim do Monitoramento:';
            divFimMonitoramento.appendChild(labelFimMonitoramento);

            let inputFimMonitoramento = document.createElement('input');
            inputFimMonitoramento.type = 'date';
            inputFimMonitoramento.name = `monitoramentos[${cont}][fimMonitoramento]`;
            inputFimMonitoramento.classList = 'form-control textInput dateInput';
            divFimMonitoramento.appendChild(inputFimMonitoramento);

            inputFimMonitoramento.addEventListener('change', function() {
                let isContinuoValue = (this.value !== '') ? 'false' : 'true';
                document.getElementById(`isContinuo${cont}`).value = isContinuoValue;
            });

            selectIsContinuo.addEventListener('change', function() {
                if (this.value == 1) {
                    inputFimMonitoramento.value = '';
                    inputFimMonitoramento.hidden = true;
                    labelFimMonitoramento.hidden = true;
                } else if (this.value == 0) {
                    labelFimMonitoramento.hidden = false;
                    inputFimMonitoramento.hidden = false;
                }
            });


            let divAnexo = document.createElement('div');
            divAnexo.classList.add('form-group');
            let labelAnexo = document.createElement('label');
            labelAnexo.textContent = 'Anexo (se houver):';
            divAnexo.appendChild(labelAnexo);

            let anexo = document.createElement('input');
            anexo.name = `monitoramentos[${cont}][anexoMonitoramento]`;
            anexo.type = 'file';
            anexo.classList.add('form-control');
            divAnexo.appendChild(anexo);

            novoMonitoramento.appendChild(divAnexo);

            monitoramentosDiv.appendChild(monitoramentoContainer);

            CKEDITOR.replace(`monitoramentoControleSugerido${cont}`, {
                extraPlugins: 'wordcount',
                wordcount: {
                    showCharCount: true,
                    maxCharCount: 10000,
                    maxCharCountMsg: 'Você atingiu o limite máximo de caracteres permitidos.',
                    charCountMsg: 'Caracteres restantes: {0}'
                }
            });


            cont++;
        }

        function formatarDataParaBrasileiro(data) {
            // Recebe uma data no formato ISO (aaaa-mm-dd) e retorna no formato brasileiro (dd/mm/aaaa)
            const partes = data.split('-');
            return `${partes[2]}/${partes[1]}/${partes[0]}`;
        }

        function showConfirmationModal() {
            let erros = [];

            let riscoAno = document.getElementById('riscoAno').value;
            let unidadeId = document.querySelector('[name="unidadeId"]').options[document.querySelector(
                '[name="unidadeId"]').selectedIndex].text;
            let responsavelRisco = document.getElementById('responsavel').value;
            let riscoEvento = CKEDITOR.instances.riscoEvento.getData();
            let riscoCausa = CKEDITOR.instances.riscoCausa.getData();
            let riscoConsequencia = CKEDITOR.instances.riscoConsequencia.getData();
            let nivel_de_risco = document.getElementById('nivel_de_risco').value;

            // Verificar campos obrigatórios
            if (!riscoAno) erros.push('O campo "Ano" é obrigatório.');
            if (!unidadeId) erros.push('O campo "Unidade" é obrigatório.');
            if (!responsavelRisco) erros.push('O campo "Responsável" é obrigatório.');
            if (!riscoEvento) erros.push('O campo "Evento de Risco" é obrigatório.');
            if (!riscoCausa) erros.push('O campo "Causa do Risco" é obrigatório.');
            if (!riscoConsequencia) erros.push('O campo "Causa da Consequência" é obrigatório.');
            if (!nivel_de_risco) erros.push('O campo "Nível de Risco" é obrigatório.');

            let modalContent = '';


            // Adicionar conteúdo dos campos do formulário
            modalContent += `
                <h4 class="text-center">Novo Risco</h4>
                <hr>
                <div class="row g-3 mb-3">
                    <div class="col-sm-6">
                        <div style="padding-right: 5px;">Ano:</div>
                        <div style="background:#f0f0f0;" class="form-control">${riscoAno || '<span class="text-danger">Campo obrigatório</span>'}</div>
                    </div>
                    <div class="col-sm-6">
                        <div style="padding-right: 5px;">Unidade:</div>
                        <div style="background:#f0f0f0;" class="form-control">${unidadeId || '<span class="text-danger">Campo obrigatório</span>'}</div>
                    </div>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-sm-12">
                        <div style="padding-right: 5px;">Responsável:</div>
                        <div style="background:#f0f0f0;" class="form-control">${responsavelRisco || '<span class="text-danger">Campo obrigatório</span>'}</div>
                    </div>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-sm-12">
                        <div style="padding-right: 5px;">Evento de Risco:</div>
                        <div style="background:#f0f0f0;" class="form-control">${riscoEvento || '<span class="text-danger">Campo obrigatório</span>'}</div>
                    </div>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-sm-12">
                        <div style="padding-right: 5px;">Causa do Risco:</div>
                        <div style="background:#f0f0f0;" class="form-control">${riscoCausa || '<span class="text-danger">Campo obrigatório</span>'}</div>
                    </div>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-sm-12">
                        <div style="padding-right: 5px;">Causa da Consequência:</div>
                        <div style="background:#f0f0f0;" class="form-control">${riscoConsequencia || '<span class="text-danger">Campo obrigatório</span>'}</div>
                    </div>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-sm-5">
                        <div style="padding-right: 5px;">Nível de Risco:</div>
                        <div style="background:#f0f0f0;" class="form-control">${nivel_de_risco || '<span class="text-danger">Campo obrigatório</span>'}</div>
                    </div>
                </div>

                <h4 class="text-center mt-4">Monitoramentos</h4>
                <hr>
            `;

            let monitoramentosDiv = document.getElementById('monitoramentosDiv');
            let monitoramentoContainers = monitoramentosDiv.getElementsByClassName('monitoramento-container');

            if (monitoramentoContainers.length === 0) {
                erros.push('É necessário inserir pelo menos um monitoramento.');
            }

            for (let i = 0; i < monitoramentoContainers.length; i++) {
                let container = monitoramentoContainers[i];
                let monitoramentoControleSugerido = CKEDITOR.instances[`monitoramentoControleSugerido${i}`].getData();
                let statusMonitoramento = container.querySelector('select[name$="[statusMonitoramento]"]').value;
                let inicioMonitoramento = container.querySelector('input[name$="[inicioMonitoramento]"]').value;
                let fimMonitoramento = container.querySelector('input[name$="[fimMonitoramento]"]').value;

                // Verifica se os campos estão vazios
                if (!monitoramentoControleSugerido) erros.push(
                    `O campo "Controle Sugerido" do Monitoramento N° ${i + 1} é obrigatório.`);
                if (!statusMonitoramento) erros.push(
                    `O campo "Status do Monitoramento" do Monitoramento N° ${i + 1} é obrigatório.`);
                if (!inicioMonitoramento) erros.push(
                    `O campo "Início do Monitoramento" do Monitoramento N° ${i + 1} é obrigatório.`);
                let isContinuo = container.querySelector('select[name$="[isContinuo]"]').value;
                if (isContinuo == 0 && !fimMonitoramento) {
                    erros.push(`O campo "Fim do Monitoramento" do Monitoramento N° ${i + 1} é obrigatório.`);
                }

                let inicioMonitoramentoDisplay = inicioMonitoramento ? formatarDataParaBrasileiro(inicioMonitoramento) :
                    "Data não definida";
                let fimMonitoramentoDisplay = fimMonitoramento ? formatarDataParaBrasileiro(fimMonitoramento) :
                    "Data não definida";

                modalContent += `

                    <div class="text-center mb-3">
                        <div style="padding-right: 5px; font-weight: bold;">Monitoramento N° ${i + 1}</div>
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-sm-12">
                            <div style="padding-right: 5px;">Controle Sugerido:</div>
                            <div style="background:#f0f0f0;" class="form-control">${monitoramentoControleSugerido || '<span class="text-danger">Campo obrigatório</span>'}</div>
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-sm-6">
                            <div style="padding-right: 5px;">Status do Monitoramento:</div>
                            <div style="background:#f0f0f0;" class="form-control">${statusMonitoramento || '<span class="text-danger">Campo obrigatório</span>'}</div>
                        </div>

                        <div class="col-sm-6">
                            <div style="padding-right: 5px;">Início do Monitoramento:</div>
                            <div style="background:#f0f0f0;" class="form-control">${inicioMonitoramentoDisplay || '<span class="text-danger">Campo obrigatório</span>'}</div>
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-sm-6">
                            <div style="padding-right: 5px;">Fim do Monitoramento:</div>
                            <div style="background:#f0f0f0;" class="form-control">${fimMonitoramentoDisplay || '<span class="text-danger">Campo obrigatório</span>'}</div>
                        </div>
                    </div>
                `;
            }

            if (erros.length > 0) {
                let errosHtml =
                    `<div class='error-box' style='background-color: #f8d7da; color: #721c24; padding: 15px; border-radius: 5px;'>`;
                erros.forEach(function(erro) {
                    errosHtml += `<p>${erro}</p>`;
                });
                errosHtml += `</div>`;
                modalContent += errosHtml;
                document.querySelector('#saveModal').style.display = 'none';
            } else {
                document.querySelector('#saveModal').style.display = 'block';
            }

            document.getElementById('modalContent').innerHTML = modalContent;
        }


        document.getElementById('formCreate').addEventListener('submit', function(event) {
            let monitoramentosDiv = document.getElementById('monitoramentosDiv');
            if (monitoramentosDiv.children.length === 0) {
                event.preventDefault();
                let alertModal = new bootstrap.Modal(document.getElementById('alertModal'));
                alertModal.show();
            }
        });
    </script>









</body>

</html>
@endsection
