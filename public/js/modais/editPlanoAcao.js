function showConfirmationModal() {
 
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

    let eixo = getSelectInfo('eixo_id');
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

    // Validação dos campos obrigatórios
    let errors = {
        eixo_id: eixo.value ? "" : "Selecione um eixo válido.",
        objetivo: objetivo ? "" : "O campo 'Objetivo' é obrigatório.",
        descricao_acao: descricaoAcao ? "" : "O campo 'Descrição da Ação' é obrigatório.",
        meta: meta ? "" : "O campo 'Meta' é obrigatório.",
        bienio: bienio ? "" : "O campo 'Biênio' é obrigatório.",
        responsavel_id: responsavel.value ? "" : "Selecione um responsável válido."
    };

    const hasErrors = Object.values(errors).some(e => e !== "");

    function createReadonlyField(label, value, errorMsg, isRequired = false, isTextarea = false) {
        const isInvalid = errorMsg ? "is-invalid" : "bg-light text-dark";
        const asterisk = isRequired ? '<span class="text-danger">*</span> ' : '';
        const displayValue = value || '-';

        let cleanDisplayValue = displayValue;
        if (isTextarea && typeof value === 'string') {
            let tempDiv = document.createElement("div");
            tempDiv.innerHTML = value;
            cleanDisplayValue = tempDiv.textContent || tempDiv.innerText || "-";
        }

        let controlHtml = isTextarea 
            ? `<textarea class="form-control ${isInvalid}" rows="2" readonly style="resize: none;">${cleanDisplayValue}</textarea>`
            : `<input type="text" class="form-control ${isInvalid}" value="${cleanDisplayValue}" readonly>`;

        return `
            <div class="col-12">
                <label class="form-label fw-bold text-secondary small mb-1">${asterisk}${label.toUpperCase()}</label>
                ${controlHtml}
                ${errorMsg ? `<div class="invalid-feedback d-block mt-1">${errorMsg}</div>` : ""}
            </div>
        `;
    }

    let modalContent = `
        <div class="alert alert-light border mb-3 py-2 px-3 small text-muted">
            <i class="bi bi-info-circle me-1 text-primary"></i> Revise as alterações abaixo antes de confirmar a atualização.
        </div>
        <form novalidate>
            <div class="row g-3">
                ${createReadonlyField("Eixo", eixo.text, errors.eixo_id, true)}
                ${createReadonlyField("Objetivo", objetivo, errors.objetivo, true, true)}
                ${createReadonlyField("Descrição da Ação", descricaoAcao, errors.descricao_acao, true, true)}
                <div class="col-md-6">
                    ${createReadonlyField("Meta", meta, errors.meta, true)}
                </div>
                <div class="col-md-6">
                    ${createReadonlyField("Biênio", bienio, errors.bienio, true)}
                </div>
                ${createReadonlyField("Indicador", indicador.value ? indicador.text : "Nenhum / Opcional", "")}
                ${createReadonlyField("Procedimentos", procedimentos, "", false, true)}
                ${createReadonlyField("Métricas", metricas, "")}
                <div class="col-md-6">
                    ${createReadonlyField("Prazo de Execução", prazoExecucaoBr, "")}
                </div>
                <div class="col-md-6">
                    ${createReadonlyField("Responsável", responsavel.text, errors.responsavel_id, true)}
                </div>
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
    document.getElementById('formUpdatePlanoAcao').submit();
}