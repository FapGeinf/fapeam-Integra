function showConfirmationModal() {
    
    let eixoSelect = document.querySelector('[name="eixo_fk"]');
    let eixoValue = eixoSelect ? eixoSelect.value : "";
    let eixo = eixoValue && eixoValue !== "0" ? eixoSelect.options[eixoSelect.selectedIndex].text.trim() : "";

    let nomeIndicador = document.getElementById('nomeIndicador').value.trim();
    let descricaoIndicador = CKEDITOR.instances['descricaoIndicador'].getData().trim();

    let errors = {
        eixo: eixo ? "" : "Selecione um eixo válido.",
        nomeIndicador: nomeIndicador ? "" : "O campo 'Nome do Indicador' é obrigatório.",
        descricaoIndicador: descricaoIndicador ? "" : "A 'Descrição do Indicador' não pode estar vazia."
    };

    const hasErrors = Object.values(errors).some(e => e !== "");

    function createReadonlyField(label, value, errorMsg) {
        const isInvalid = errorMsg ? "text-danger border-danger" : "text-dark";
        return `
            <div class="col-12 mb-3">
                <label class="form-label fw-semibold">${label}</label>
                <input type="text" class="form-control input-disabled bg-light ${isInvalid}" value="${value || '-'}" readonly>
                ${errorMsg ? `<div class="text-danger small mt-1">${errorMsg}</div>` : ""}
            </div>
        `;
    }

    function createReadonlyDiv(label, htmlContent, errorMsg) {
        const isInvalid = errorMsg ? "border border-danger" : "border";
        return `
            <div class="col-12 mb-3">
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
            <div class="row g-3">
                ${createReadonlyField("Eixo", eixo, errors.eixo)}
                ${createReadonlyField("Nome do Indicador", nomeIndicador, errors.nomeIndicador)}
                ${createReadonlyDiv("Descrição do Indicador", descricaoIndicador, errors.descricaoIndicador)}
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
    document.getElementById('formStoreIndicador').submit();
}