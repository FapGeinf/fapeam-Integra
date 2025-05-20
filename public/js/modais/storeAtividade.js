function showConfirmationModal() {
    function getSelectedTexts(selectElement) {
        return Array.from(selectElement?.selectedOptions || [])
            .map(opt => opt.text.trim())
            .filter(t => t && t.toLowerCase() !== "selecione")
            .join(', ');
    }

    let eixo = getSelectedTexts(document.querySelector('[name="eixo_ids[]"]'));
    let responsavel = document.getElementById('responsavel').value.trim();
    let atividadeDescricao = CKEDITOR.instances['atividade_descricao'].getData().trim();
    let objetivo = CKEDITOR.instances['objetivo'].getData().trim();
    let publicoSelect = document.querySelector('[name="publico_id"]');
    let publico = publicoSelect ? publicoSelect.options[publicoSelect.selectedIndex].text.trim() : "";
    let tipoEventoSelect = document.querySelector('[name="tipo_evento"]');
    let tipoEvento = tipoEventoSelect ? tipoEventoSelect.options[tipoEventoSelect.selectedIndex].text.trim() : "";
    let canal = getSelectedTexts(document.querySelector('[name="canal_id[]"]'));
    let dataPrevista = document.getElementById('data_prevista').value.trim();
    let dataRealizada = document.getElementById('data_realizada').value.trim();
    let indicador = getSelectedTexts(document.querySelector('[name="indicador_ids[]"]'));
    let meta = document.getElementById('meta').value.trim();
    let realizado = document.getElementById('realizado').value.trim();
    let medidaSelect = document.querySelector('[name="medida_id"]');
    let medida = medidaSelect ? medidaSelect.options[medidaSelect.selectedIndex].text.trim() : "";

    function formatDateBR(dateStr) {
        if (!dateStr) return '';
        const parts = dateStr.split('-');
        return parts.length === 3 ? `${parts[2]}/${parts[1]}/${parts[0]}` : dateStr;
    }

    let errors = {
        eixo: eixo ? "" : "Selecione ao menos um eixo.",
        responsavel: responsavel ? "" : "O campo 'Responsável' é obrigatório.",
        atividadeDescricao: atividadeDescricao ? "" : "A 'Descrição da Atividade' não pode estar vazia.",
        objetivo: objetivo ? "" : "O campo 'Objetivo' não pode estar vazio.",
        publico: publico && publico.toLowerCase() !== "selecione" ? "" : "Selecione um público válido.",
        tipoEvento: tipoEvento && tipoEvento.toLowerCase() !== "selecione" ? "" : "Selecione um tipo de evento válido.",
        canal: canal ? "" : "Selecione ao menos um canal.",
        dataPrevista: dataPrevista ? "" : "A 'Data Prevista' é obrigatória.",
        indicador: "", // não obrigatório
        meta: meta ? "" : "O campo 'Meta' é obrigatório.",
        realizado: realizado ? "" : "O campo 'Realizado' é obrigatório.",
        medida: medida && medida.toLowerCase() !== "selecione" ? "" : "Selecione uma unidade de medida válida."
    };

    const hasErrors = Object.values(errors).some(e => e !== "");

    function createReadonlyField(label, value, errorMsg) {
        const isInvalid = errorMsg ? "text-danger border-danger" : "text-dark";
        return `
            <div class="mb-3 col-md-6">
                <label class="form-label fw-semibold">${label}</label>
                <div class="form-control bg-light ${isInvalid}" style="min-height: 38px;">${value || '-'}</div>
                ${errorMsg ? `<div class="text-danger small mt-1">${errorMsg}</div>` : ""}
            </div>
        `;
    }

    function createReadonlyDiv(label, htmlContent, errorMsg) {
        const isInvalid = errorMsg ? "border border-danger" : "border";
        return `
            <div class="mb-4">
                <label class="form-label fw-semibold">${label}</label>
                <div class="p-3 rounded ${isInvalid} bg-light" style="white-space: pre-wrap; min-height: 100px;">
                    ${htmlContent || '-'}
                </div>
                ${errorMsg ? `<div class="text-danger small mt-1">${errorMsg}</div>` : ""}
            </div>
        `;
    }

    let modalContent = `
        <form class="was-validated" novalidate>
            <div class="row">
                ${createReadonlyField("Eixo(s)", eixo, errors.eixo)}
                ${createReadonlyField("Responsável", responsavel, errors.responsavel)}
                ${createReadonlyField("Público", publico, errors.publico)}
                ${createReadonlyField("Tipo de Evento", tipoEvento, errors.tipoEvento)}
                ${createReadonlyField("Canal(is)", canal, errors.canal)}
                ${createReadonlyField("Data Prevista", formatDateBR(dataPrevista), errors.dataPrevista)}
                ${createReadonlyField("Data Realizada", formatDateBR(dataRealizada), "")}
                ${createReadonlyField("Indicador(es)", indicador, errors.indicador)}
                ${createReadonlyField("Meta", meta, errors.meta)}
                ${createReadonlyField("Realizado", realizado, errors.realizado)}
                ${createReadonlyField("Unidade de Medida", medida, errors.medida)}
            </div>
            ${createReadonlyDiv("Descrição da Atividade", atividadeDescricao, errors.atividadeDescricao)}
            ${createReadonlyDiv("Objetivo", objetivo, errors.objetivo)}
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
    document.getElementById('formStoreAtividade').submit();
}
