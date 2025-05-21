function showConfirmationModal() {
    const nome = document.querySelector('input[name="name"]').value.trim();
    const email = document.querySelector('input[name="email"]').value.trim();
    const cpf = document.querySelector('input[name="cpf"]').value.trim();

    const unidadeSelect = document.querySelector('select[name="unidadeIdFK"]');
    const unidadeValue = unidadeSelect.value;
    const unidadeText = unidadeValue ? unidadeSelect.options[unidadeSelect.selectedIndex]?.text : '';

    let errors = [];

    if (!nome) {
        errors.push('Por favor, preencha o campo Nome.');
    }

    if (!email) {
        errors.push('Por favor, preencha o campo Email.');
    } else {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email)) {
            errors.push('Por favor, informe um Email válido.');
        }
    }

    if (!cpf) {
        errors.push('Por favor, preencha o campo CPF.');
    }

    if (!unidadeValue) {
        errors.push('Por favor, selecione uma Unidade.');
    }

    let modalContent = `
    <h5>Dados do Novo Usuário</h5>

    <form>
        <div class="mb-3">
            <label class="form-label"><strong>Nome:</strong></label>
            <input type="text" class="form-control" value="${nome}" readonly>
            ${!nome ? '<div class="text-danger small mt-1">Por favor, preencha o campo Nome.</div>' : ''}
        </div>

        <div class="mb-3">
            <label class="form-label"><strong>Email:</strong></label>
            <input type="text" class="form-control" value="${email}" readonly>
            ${
                !email 
                ? '<div class="text-danger small mt-1">Por favor, preencha o campo Email.</div>' 
                : !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)
                ? '<div class="text-danger small mt-1">Por favor, informe um Email válido.</div>'
                : ''
            }
        </div>

        <div class="mb-3">
            <label class="form-label"><strong>CPF:</strong></label>
            <input type="text" class="form-control" value="${cpf}" readonly>
            ${!cpf ? '<div class="text-danger small mt-1">Por favor, preencha o campo CPF.</div>' : ''}
        </div>

        <div class="mb-3">
            <label class="form-label"><strong>Unidade:</strong></label>
            <input type="text" class="form-control" value="${unidadeText}" readonly>
            ${!unidadeValue ? '<div class="text-danger small mt-1">Por favor, selecione uma Unidade.</div>' : ''}
        </div>
    </form>
    `;

    document.getElementById('modalContent').innerHTML = modalContent;

    const btnConfirm = document.getElementById('btnConfirmSubmit');
    if (errors.length > 0) {
        btnConfirm.style.display = 'none';
    } else {
        btnConfirm.style.display = 'inline-block';
    }

    const confirmationModal = new bootstrap.Modal(document.getElementById('confirmationModal'));
    confirmationModal.show();
}

function formSubmit() {
    document.getElementById('formInsertUser').submit();
}
