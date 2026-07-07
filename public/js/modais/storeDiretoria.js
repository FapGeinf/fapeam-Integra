function showConfirmationModal() {
    
    let siglaDiretoria = document.getElementById('diretoriaSigla').value.trim();
    let nomeDiretoria = document.getElementById('diretoriaNome').value.trim();
    let diretorResponsavel = document.getElementById('diretor').value.trim();

    // Valida apenas os campos obrigatórios (*)
    let errors = {
        diretoriaSigla: siglaDiretoria ? "" : "A 'Sigla da Diretoria' é obrigatória.",
        diretoriaNome: nomeDiretoria ? "" : "O 'Nome da Diretoria' é obrigatório."
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
                ${createReadonlyField("Sigla da Diretoria", siglaDiretoria, errors.diretoriaSigla)}
                ${createReadonlyField("Nome da Diretoria", nomeDiretoria, errors.diretoriaNome)}
                ${createReadonlyField("Diretor Responsável", diretorResponsavel, "")}
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
    document.getElementById('formStoreDiretoria').submit();
}