document.addEventListener("DOMContentLoaded", function () {
    let ckeditorConfig = {
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
    novoEventoTitulo.textContent = 'Novo Controle Sugerido';
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
    label.textContent = `O Controle Sugerido N° ${cont + 1}`;

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
    deleteWrapper.onclick = function () {
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
    controleSugerido.placeholder = 'Controle Sugerido';
    controleSugerido.classList = 'form-control textInput';
    controleSugerido.id = `monitoramentoControleSugerido${cont}`;
    divControleSugerido.appendChild(controleSugerido);

    let divStatusMonitoramento = document.createElement('div');
    divStatusMonitoramento.classList = 'form-group';
    novoMonitoramento.appendChild(divStatusMonitoramento);

    let statusMonitoramento = document.createElement('input');
    statusMonitoramento.type = 'hidden';
    statusMonitoramento.name = `monitoramentos[${cont}][statusMonitoramento]`;
    statusMonitoramento.value = "NÃO IMPLEMENTADA";

    divStatusMonitoramento.appendChild(statusMonitoramento);

    let divIsContinuo = document.createElement('div');
    divIsContinuo.classList.add('form-group');
    novoMonitoramento.appendChild(divIsContinuo);

    let labelIsContinuo = document.createElement('label');
    labelIsContinuo.textContent = 'Controle Sugerido:';
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
    labelInicioMonitoramento.textContent = 'Início:';
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
    labelFimMonitoramento.textContent = 'Fim:';
    divFimMonitoramento.appendChild(labelFimMonitoramento);

    let inputFimMonitoramento = document.createElement('input');
    inputFimMonitoramento.type = 'date';
    inputFimMonitoramento.name = `monitoramentos[${cont}][fimMonitoramento]`;
    inputFimMonitoramento.classList = 'form-control textInput dateInput';
    divFimMonitoramento.appendChild(inputFimMonitoramento);

    inputFimMonitoramento.addEventListener('change', function () {
        let isContinuoValue = (this.value !== '') ? 'false' : 'true';
        document.getElementById(`isContinuo${cont}`).value = isContinuoValue;
    });

    selectIsContinuo.addEventListener('change', function () {
        if (this.value == 1) {
            inputFimMonitoramento.value = '';
            inputFimMonitoramento.hidden = true;
            labelFimMonitoramento.hidden = true;
        } else if (this.value == 0) {
            labelFimMonitoramento.hidden = false;
            inputFimMonitoramento.hidden = false;
        }
    });


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

            <h4 class="text-center mt-4">Controles Sugeridos</h4>
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
        let inicioMonitoramento = container.querySelector('input[name$="[inicioMonitoramento]"]').value;
        let fimMonitoramento = container.querySelector('input[name$="[fimMonitoramento]"]').value;

        if (!monitoramentoControleSugerido) erros.push(
            `O campo "Controle Sugerido" N° ${i + 1} é obrigatório.`);
        if (!inicioMonitoramento) erros.push(
            `O campo "Início" do Controle Sugerido N° ${i + 1} é obrigatório.`);
        let isContinuo = container.querySelector('select[name$="[isContinuo]"]').value;
        if (isContinuo == 0 && !fimMonitoramento) {
            erros.push(`O campo "Fim" do Controle Sugerido N° ${i + 1} é obrigatório.`);
        }

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

    if (erros.length > 0) {
        let errosHtml =
            `<div class='error-box' style='background-color: #f8d7da; color: #721c24; padding: 15px; border-radius: 5px;'>`;
        erros.forEach(function (erro) {
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


document.getElementById('formCreate').addEventListener('submit', function (event) {
    let monitoramentosDiv = document.getElementById('monitoramentosDiv');
    if (monitoramentosDiv.children.length === 0) {
        event.preventDefault();
        let alertModal = new bootstrap.Modal(document.getElementById('alertModal'));
        alertModal.show();
    }
});