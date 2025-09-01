function showConfirmationModal() {
    
    let titulo = document.getElementById('titulo').value;
    let descricao = CKEDITOR.instances['descricao'].getData();

    let errors = {
       titulo: titulo ? "" : "O campo titulo é obrigatório",
       descricao: descricao ? "" : "O campo descrição é obrigatório"
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

    function stripHtml(html) {
        let tmp = document.createElement("DIV");
        tmp.innerHTML = html;
        return tmp.textContent || tmp.innerText || "";
    }

    let modalContent = `
        <form class="was-validated" novalidate>
            <div class="row g-3">
                ${createReadonlyField("Titulo", titulo, errors.titulo)}
                ${createReadonlyField("Descrição", stripHtml(descricao), errors.descricao)}
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
    document.getElementById('formUpdateVersionamento').submit();
}