function showConfirmationModal() {
  const nome = document.querySelector('input[name="name"]').value.trim();
  const email = document.querySelector('input[name="email"]').value.trim();
  const cpf = document.querySelector('input[name="cpf"]').value.trim();

  const unidadeSelect = document.querySelector('select[name="unidadeIdFK"]');
  const unidadeValue = unidadeSelect.value;
  const unidadeText = unidadeValue ? unidadeSelect.options[unidadeSelect.selectedIndex]?.text : '';

  let errors = [];

  if (!nome) {
    errors.push('O campo não pode ficar vazio');
  }

  if (!email) {
    errors.push('O campo não pode ficar vazio');
  } else {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email)) {
      errors.push('Por favor, insira um email válido.');
    }
  }

  if (!cpf) {
    errors.push('O campo não pode ficar vazio');
  }

  if (!unidadeValue) {
    errors.push('Por favor, selecione uma unidade');
  }

  let modalContent = `
    <form>
      <div class="mb-3">
        <label for="name">Nome:</label>
        <input type="text" class="form-control input-disabled" value="${nome}" readonly>
        ${!nome ? '<div class="text-danger small mt-1">O campo não pode ficar vazio</div>' : ''}
      </div>

      <div class="mb-3">
        <label for="email">Email:</label>
        <input type="text" class="form-control input-disabled" value="${email}" readonly>
        ${
          !email 
          ? '<div class="text-danger small mt-1">O campo não pode ficar vazio.</div>' 
          : !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)
          ? '<div class="text-danger small mt-1">Por favor, insira um email válido.</div>'
          : ''
        }
      </div>

      <div class="mb-3">
        <label class="cpf">CPF:</label>
        <input type="text" class="form-control input-disabled" value="${cpf}" readonly>
        ${!cpf ? '<div class="text-danger small mt-1">O campo não pode ficar vazio</div>' : ''}
      </div>

      <div class="mb-3">
        <label for="unidadeIdFK">Unidade:</label>
        <input type="text" class="form-control input-disabled" value="${unidadeText}" readonly>
        ${!unidadeValue ? '<div class="text-danger small mt-1">Por favor, selecione uma unidade</div>' : ''}
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