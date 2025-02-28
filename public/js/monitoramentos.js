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
    numeration.textContent = `Monitoramento Nº ${cont + 1}`;
    monitoramentoDiv.appendChild(numeration);

    let controleSugerido = document.createElement('textarea');
    controleSugerido.name = `monitoramentos[${cont}][monitoramentoControleSugerido]`;
    controleSugerido.placeholder = 'Monitoramento';
    controleSugerido.classList.add('textInput');
    controleSugerido.id = `monitoramentoControleSugerido${cont}`;

    let statusMonitoramentoLabel = document.createElement('label');
    statusMonitoramentoLabel.textContent = 'Status do Monitoramento:';
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
    labelIsContinuo.textContent = 'Monitoramento Contínuo:';
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
    inicioMonitoramentoLabel.textContent = 'Início do Monitoramento:';
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
    fimMonitoramentoLabel.textContent = 'Fim do Monitoramento:';
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
            `O campo "Controle Sugerido" do Monitoramento N° ${i + 1} é obrigatório.`);
        if (!statusMonitoramento) erros.push(
            `O campo "Status do Monitoramento" do Monitoramento N° ${i + 1} é obrigatório.`);
        if (!inicioMonitoramento) erros.push(
            `O campo "Início do Monitoramento" do Monitoramento N° ${i + 1} é obrigatório.`);
        if (isContinuo == 0 && !fimMonitoramento) erros.push(
            `O campo "Fim do Monitoramento" do Monitoramento N° ${i + 1} é obrigatório.`);

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