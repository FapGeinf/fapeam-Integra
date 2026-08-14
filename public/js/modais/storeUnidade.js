function showConfirmationModal() {
    
    let nomeUnidade = document.getElementById('unidadeNome').value.trim();
    let siglaUnidade = document.getElementById('unidadeSigla').value.trim();
    let emailUnidade = document.getElementById('unidadeEmail').value.trim();

    let tipoSelect = document.getElementById('unidadeTipoFK');
    let tipoValue = tipoSelect ? tipoSelect.value : "";
    let tipoText = tipoValue && tipoValue !== "" ? tipoSelect.options[tipoSelect.selectedIndex].text.trim() : "";

    let emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    let isEmailValid = emailRegex.test(emailUnidade);

    let errors = {
        unidadeNome: nomeUnidade ? "" : "O 'Nome da Unidade' é obrigatório.",
        unidadeSigla: siglaUnidade ? "" : "A 'Sigla da Unidade' é obrigatória.",
        unidadeEmail: emailUnidade ? (isEmailValid ? "" : "Insira um endereço de e-mail válido.") : "O 'E-mail da Unidade' é obrigatório.",
        unidadeTipoFK: tipoText ? "" : "Selecione um tipo de unidade válido."
    };

    const hasErrors = Object.values(errors).some(e => e !== "");

    function createReadonlyField(label, value, errorMsg) {
        const isInvalid = errorMsg ? "text-danger border-danger" : "text-dark";
        return `
            <div class="col-12 mb-2">
                <label class="fw-bold">${label}:</label>
                <input type="text" class="form-control input-disabled ${isInvalid}" value="${value || '-'}" readonly>
                ${errorMsg ? `<div class="text-danger small mt-1">${errorMsg}</div>` : ""}
            </div>
        `;
    }

    let modalContent = `
        <form class="was-validated" novalidate>
            <div class="row g-3">
                ${createReadonlyField("Nome da Unidade", nomeUnidade, errors.unidadeNome)}
                ${createReadonlyField("Sigla da Unidade", siglaUnidade, errors.unidadeSigla)}
                ${createReadonlyField("E-mail da Unidade", emailUnidade, errors.unidadeEmail)}
                ${createReadonlyField("Tipo de Unidade", tipoText, errors.unidadeTipoFK)}
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
    document.getElementById('formStoreUnidade').submit();
}