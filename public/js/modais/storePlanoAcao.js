function showConfirmationModal() {
    
    function getMultipleSelectInfo(selectId) {
        let selectElement = document.getElementById(selectId);
        if (!selectElement) return { values: [], texts: "" };

        let values = [];
        let texts = [];

       
        for (let option of selectElement.options) {
            if (option.selected && option.value) {
                values.push(option.value);
                texts.push(option.text.trim());
            }
        }

       
        if (values.length === 0 && window.ChoicesInstances && window.ChoicesInstances[selectId]) {
            let choiceInstance = window.ChoicesInstances[selectId];
            let activeChoices = choiceInstance.getValue(true); // Retorna array de valores
            if (activeChoices && activeChoices.length > 0) {
                values = activeChoices;
                // Busca os textos correspondentes nas opções do select
                for (let val of values) {
                    let opt = Array.from(selectElement.options).find(o => o.value == val);
                    if (opt) {
                        texts.push(opt.text.trim());
                    }
                }
            }
        }

        return { 
            values: values, 
            text: texts.length > 0 ? texts.join(', ') : "" 
        };
    }

    function getSelectInfo(selectId) {
        let selectElement = document.getElementById(selectId);
        if (!selectElement) return { value: "", text: "" };

        let value = selectElement.value;
        let text = "";

        if (selectElement.selectedIndex !== -1 && selectElement.options[selectElement.selectedIndex]) {
            text = selectElement.options[selectElement.selectedIndex].text.trim();
        }

        if (!value && window.ChoicesInstances && window.ChoicesInstances[selectId]) {
            let choiceInstance = window.ChoicesInstances[selectId];
            let activeChoice = choiceInstance.getValue(true);
            if (activeChoice) {
                value = activeChoice;
            }
        }

        return { value: value, text: (value ? text : "") };
    }

    function getFieldValue(fieldId) {
        let element = document.getElementById(fieldId);
        if (!element) return "";

        if (typeof CKEDITOR !== 'undefined' && CKEDITOR.instances && CKEDITOR.instances[fieldId]) {
            return CKEDITOR.instances[fieldId].getData().trim();
        }

        return element.value ? element.value.trim() : "";
    }

   
    function formatDateToBr(dateString) {
        if (!dateString) return "";
        let parts = dateString.split('-');
        if (parts.length === 3) {
            return `${parts[2]}/${parts[1]}/${parts[0]}`;
        }
        return dateString;
    }

   
    let eixos = getMultipleSelectInfo('eixos');
    let indicador = getSelectInfo('indicador_id');
    let responsavel = getSelectInfo('responsavel_id');

    let objetivo = getFieldValue('objetivo');
    let descricaoAcao = getFieldValue('descricao_acao');
    let procedimentos = getFieldValue('procedimentos');

    let meta = document.getElementById('meta').value.trim();
    let bienio = document.getElementById('bienio').value.trim();
    let metricas = document.getElementById('metricas').value.trim();
    
    let prazoExecucaoRaw = document.getElementById('prazo_execucao').value.trim();
    let prazoExecucaoBr = formatDateToBr(prazoExecucaoRaw);


    let errors = {
        eixos: eixos.values.length > 0 ? "" : "Selecione pelo menos um eixo válido.",
        objetivo: objetivo ? "" : "O campo 'Objetivo' é obrigatório.",
        descricao_acao: descricaoAcao ? "" : "O campo 'Descrição da Ação' é obrigatório.",
        meta: meta ? "" : "O campo 'Meta' é obrigatório.",
        bienio: bienio ? "" : "O campo 'Biênio' é obrigatório.",
        responsavel_id: responsavel.value ? "" : "Selecione um responsável válido."
    };

    const hasErrors = Object.values(errors).some(e => e !== "");

    function createReadonlyField(label, value, errorMsg, isRequired = false, isTextarea = false) {
        const isInvalid = errorMsg ? "text-danger border-danger" : "text-dark";
        const asterisk = isRequired ? '<span class="text-danger">*</span> ' : '';
        const displayValue = value || '-';

        let cleanDisplayValue = displayValue;
        if (isTextarea && typeof value === 'string') {
            let tempDiv = document.createElement("div");
            tempDiv.innerHTML = value;
            cleanDisplayValue = tempDiv.textContent || tempDiv.innerText || "-";
        }

        let controlHtml = isTextarea 
            ? `<textarea class="form-control input-disabled ${isInvalid}" rows="3" readonly>${cleanDisplayValue}</textarea>`
            : `<input type="text" class="form-control input-disabled ${isInvalid}" value="${cleanDisplayValue}" readonly>`;

        return `
            <div class="col-12 mb-2">
                <label class="fw-bold">${asterisk}${label}:</label>
                ${controlHtml}
                ${errorMsg ? `<div class="text-danger small mt-1">${errorMsg}</div>` : ""}
            </div>
        `;
    }

    let modalContent = `
        <form class="was-validated" novalidate>
            <div class="row g-3">
                ${createReadonlyField("Eixos Estratégicos", eixos.text, errors.eixos, true)}
                ${createReadonlyField("Objetivo", objetivo, errors.objetivo, true, true)}
                ${createReadonlyField("Descrição da Ação", descricaoAcao, errors.descricao_acao, true, true)}
                ${createReadonlyField("Meta", meta, errors.meta, true)}
                ${createReadonlyField("Biênio", bienio, errors.bienio, true)}
                ${createReadonlyField("Indicador", indicador.value ? indicador.text : "Nenhum / Opcional", "")}
                ${createReadonlyField("Procedimentos", procedimentos, "", false, true)}
                ${createReadonlyField("Métricas", metricas, "")}
                ${createReadonlyField("Prazo de Execução", prazoExecucaoBr, "")}
                ${createReadonlyField("Responsável", responsavel.text, errors.responsavel_id, true)}
            </div>
        </form>
    `;

    document.getElementById('modalContent').innerHTML = modalContent;
    
    let confirmationModal = new bootstrap.Modal(document.getElementById('confirmationModal'));
    confirmationModal.show();

    const submitBtn = document.getElementById('submitConfirmationBtn');
    if (submitBtn) {
        submitBtn.style.display = hasErrors ? 'none' : 'inline-block';
    }

    return !hasErrors;
}

function formSubmit() {
    if (typeof CKEDITOR !== 'undefined' && CKEDITOR.instances) {
        for (let instance in CKEDITOR.instances) {
            CKEDITOR.instances[instance].updateElement();
        }
    }
    
    let form = document.getElementById('formStorePlanoAcao') || document.getElementById('formUpdatePlanoAcao');
    if (form) {
        form.submit();
    }
}