@extends('layouts.app')

@section('content')

@section('title', 'Adicionar Controles Sugeridos')

<head>
    <link rel="stylesheet" href="{{ asset('css/edit.css') }}">
    <script src="/ckeditor/ckeditor.js"></script>
</head>

<div class="form-wrapper pt-4 paddingLeft">
    <div class="form_create">
        <h3 style="text-align: center; margin-bottom: 10px;">Formulário de Controles Sugeridos</h3>

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
                <span>Controles Sugeridos adicionados: </span>
                <span id="monitoramentoCounter">0</span>
            </div>

            <hr>

            <div id="monitoramentosDiv" class="monitoramento">
                <!-- Monitoramentos serão adicionados aqui dinamicamente -->
            </div>

            <div class="buttons">
                <button type="button" class="add-btn" onclick="addMonitoramento()">Adicionar Controle Sugerido</button>
                <button type="button" class="close-btn" onclick="fecharFormulario()">Remover</button>
            </div>

            <hr id="hr3">

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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    let cont = 0;
    let monitoramentoCounter = document.getElementById('monitoramentoCounter');

    function updateCounter() {
        monitoramentoCounter.textContent = cont;
    }

    function addMonitoramento() {
        let monitoramentosDiv = document.getElementById('monitoramentosDiv');
        let monitoramentoDiv = document.createElement('div');
        monitoramentoDiv.classList.add('monitoramento', 'mb-4');

        let numeration = document.createElement('span');
        numeration.classList.add('numeration');
        numeration.textContent = `Controle Sugerido Nº ${cont + 1}`;
        monitoramentoDiv.appendChild(numeration);

        let controleSugerido = document.createElement('textarea');
        controleSugerido.name = `monitoramentos[${cont}][monitoramentoControleSugerido]`;
        controleSugerido.placeholder = 'Controle Sugerido';
        controleSugerido.classList.add('textInput');
        controleSugerido.id = `monitoramentoControleSugerido${cont}`;

        let statusMonitoramentoLabel = document.createElement('label');
        statusMonitoramentoLabel.textContent = 'Status :';
        let statusMonitoramento = document.createElement('select');
        statusMonitoramento.name = `monitoramentos[${cont}][statusMonitoramento]`;
        statusMonitoramento.classList.add('form-select');
        statusMonitoramento.id = `statusMonitoramento${cont}`;

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
            option.text = optionData.text;
            statusMonitoramento.appendChild(option);
        });

        // Monitoramento Contínuo
        let divIsContinuo = document.createElement('div');
        divIsContinuo.classList.add('form-group');
        let labelIsContinuo = document.createElement('label');
        labelIsContinuo.textContent = 'É Contínuo:';
        divIsContinuo.appendChild(labelIsContinuo);

        let selectIsContinuo = document.createElement('select');
        selectIsContinuo.name = `monitoramentos[${cont}][isContinuo]`;
        selectIsContinuo.classList.add('form-select');
        selectIsContinuo.id = `isContinuo${cont}`;

        let optionNao = document.createElement('option');
        optionNao.value = 0;
        optionNao.textContent = 'Não';
        selectIsContinuo.appendChild(optionNao);

        let optionSim = document.createElement('option');
        optionSim.value = 1;
        optionSim.textContent = 'Sim';
        selectIsContinuo.appendChild(optionSim);

        divIsContinuo.appendChild(selectIsContinuo);

        let rowDiv = document.createElement('div');
        rowDiv.classList.add('row', 'g-3');

        let colDiv1 = document.createElement('div');
        colDiv1.classList.add('col-sm-12', 'col-md-6');
        let inicioMonitoramentoLabel = document.createElement('label');
        inicioMonitoramentoLabel.textContent = 'Início:';
        let inicioMonitoramento = document.createElement('input');
        inicioMonitoramento.type = 'date';
        inicioMonitoramento.name = `monitoramentos[${cont}][inicioMonitoramento]`;
        inicioMonitoramento.classList.add('form-control');
        inicioMonitoramento.required = true;
        colDiv1.appendChild(inicioMonitoramentoLabel);
        colDiv1.appendChild(inicioMonitoramento);

        let colDiv2 = document.createElement('div');
        colDiv2.classList.add('col-sm-12', 'col-md-6');
        let fimMonitoramentoLabel = document.createElement('label');
        fimMonitoramentoLabel.textContent = 'Fim:';
        let fimMonitoramento = document.createElement('input');
        fimMonitoramento.type = 'date';
        fimMonitoramento.name = `monitoramentos[${cont}][fimMonitoramento]`;
        fimMonitoramento.classList.add('form-control');
        colDiv2.appendChild(fimMonitoramentoLabel);
        colDiv2.appendChild(fimMonitoramento);

        selectIsContinuo.addEventListener('change', function() {
            if (this.value == 1) {
                fimMonitoramento.value = '';
                colDiv2.style.display = 'none';
            } else {
                colDiv2.style.display = 'block';
            }
        });

        // Anexo
        let divAnexo = document.createElement('div');
        divAnexo.classList.add('form-group', 'mb-4');
        let divAnexoLabel = document.createElement('label');
        divAnexoLabel.textContent = 'Anexo:';
        divAnexo.appendChild(divAnexoLabel);

        let inputAnexo = document.createElement('input');
        inputAnexo.type = 'file';
        inputAnexo.name = `monitoramentos[${cont}][anexoMonitoramento]`;
        inputAnexo.classList.add('form-control');
        divAnexo.appendChild(inputAnexo);

        // Append all elements
        rowDiv.appendChild(colDiv1);
        rowDiv.appendChild(colDiv2);
        monitoramentoDiv.appendChild(controleSugerido);
        monitoramentoDiv.appendChild(statusMonitoramentoLabel);
        monitoramentoDiv.appendChild(statusMonitoramento);
        monitoramentoDiv.appendChild(divIsContinuo);
        monitoramentoDiv.appendChild(rowDiv);
        monitoramentoDiv.appendChild(divAnexo);
        monitoramentosDiv.appendChild(monitoramentoDiv);

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
        updateCounter();



    }

    function fecharFormulario() {
        document.getElementById('monitoramentosDiv').innerHTML = '';
        cont = 0;
        updateCounter();
    }

    function showConfirmationModal() {
        let erros = [];
        let modalContent = '';

        let monitoramentosDiv = document.getElementById('monitoramentosDiv');
        if (!monitoramentosDiv) {
            console.error('Elemento monitoramentosDiv não encontrado');
            return;
        }

        let monitoramentoContainers = monitoramentosDiv.getElementsByClassName('monitoramento');

        if (monitoramentoContainers.length === 0) {
            erros.push('É necessário inserir pelo menos um monitoramento.');
        }

        for (let i = 0; i < monitoramentoContainers.length; i++) {
            let container = monitoramentoContainers[i];

            let monitoramentoControleSugerido = CKEDITOR.instances[`monitoramentoControleSugerido${i}`]?.getData() ||
            '';
            let statusMonitoramento = container.querySelector(
                `select[name="monitoramentos[${i}][statusMonitoramento]"]`)?.value;
            let inicioMonitoramento = container.querySelector(`input[name="monitoramentos[${i}][inicioMonitoramento]"]`)
                ?.value;
            let fimMonitoramento = container.querySelector(`input[name="monitoramentos[${i}][fimMonitoramento]"]`)
                ?.value;
            let isContinuo = container.querySelector(`select[name="monitoramentos[${i}][isContinuo]"]`)?.value;

            if (!monitoramentoControleSugerido) erros.push(
                `O campo "Controle Sugerido" N° ${i + 1} é obrigatório.`);
            if (!statusMonitoramento) erros.push(
                `O campo "Status" do Controle Sugerido N° ${i + 1} é obrigatório.`);
            if (!inicioMonitoramento) erros.push(
                `O campo "Início" do Controle Sugerido N° ${i + 1} é obrigatório.`);
            if (isContinuo == 0 && !fimMonitoramento) erros.push(
                `O campo "Fim" do Controle Sugerido N° ${i + 1} é obrigatório.`);

            let inicioMonitoramentoDisplay = inicioMonitoramento ? formatarDataParaBrasileiro(inicioMonitoramento) :
                "Data não definida";
            let fimMonitoramentoDisplay = fimMonitoramento ? formatarDataParaBrasileiro(fimMonitoramento) :
                "Data não definida";

            modalContent += `
        <div class="text-center mb-3">
            <div style="padding-right: 5px; font-weight: bold;">Controle Sugerido N° ${i + 1}</div>
        </div>
        <div class="row g-3 mb-3">
            <div class="col-sm-12">
                <div style="padding-right: 5px;">Controle Sugerido:</div>
                <div style="background:#f0f0f0;" class="form-control">${monitoramentoControleSugerido || '<span class="text-danger">Campo obrigatório</span>'}</div>
            </div>
        </div>
        <div class="row g-3 mb-3">
            <div class="col-sm-6">
                <div style="padding-right: 5px;">Status:</div>
                <div style="background:#f0f0f0;" class="form-control">${statusMonitoramento || '<span class="text-danger">Campo obrigatório</span>'}</div>
            </div>
            <div class="col-sm-6">
                <div style="padding-right: 5px;">Início:</div>
                <div style="background:#f0f0f0;" class="form-control">${inicioMonitoramentoDisplay || '<span class="text-danger">Campo obrigatório</span>'}</div>
            </div>
        </div>
        <div class="row g-3 mb-3">
            <div class="col-sm-6">
                <div style="padding-right: 5px;">Fim:</div>
                <div style="background:#f0f0f0;" class="form-control">${fimMonitoramentoDisplay || '<span class="text-danger">Campo obrigatório</span>'}</div>
            </div>
        </div>
    `;
        }

        let modalContentDiv = document.getElementById('modalContent');
        if (modalContentDiv) {
            modalContentDiv.innerHTML = modalContent;
        }

        let btnEdit = document.getElementById('btnEdit');
        if (erros.length > 0) {
            let errosHtml =
                `<div class='error-box' style='background-color: #f8d7da; color: #721c24; padding: 15px; border-radius: 5px;'>`;
            erros.forEach(function(erro) {
                errosHtml += `<p>${erro}</p>`;
            });
            errosHtml += `</div>`;
            modalContentDiv.innerHTML = errosHtml + modalContent;
            if (btnEdit) btnEdit.style.display = 'none';
            $('#confirmationModal').modal('show');
        } else {
            if (btnEdit) btnEdit.style.display = 'block';
            $('#confirmationModal').modal('show');
        }
    }



    function formatarDataParaBrasileiro(data) {
        let partes = data.split('-');
        return `${partes[2]}/${partes[1]}/${partes[0]}`;
    }


    function submitForm() {
        document.getElementById('formCreate').submit();
    }

    document.addEventListener('DOMContentLoaded', function() {
        CKEDITOR.replaceAll(function(textarea, config) {
            return textarea.classList.contains('ckeditor');
        });
    });
</script>

@endsection
