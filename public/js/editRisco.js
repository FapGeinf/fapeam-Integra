function showConfirmationModal() {
  let riscoAno = document.getElementById('riscoAno').value;
  let responsavelRisco = document.getElementById('responsavelRisco').value;
  let riscoEvento = CKEDITOR.instances.riscoEvento.getData();
  let riscoCausa = CKEDITOR.instances.riscoCausa.getData();
  let riscoConsequencia = CKEDITOR.instances.riscoConsequencia.getData();
  let nivel_de_risco = document.getElementById('nivel_de_risco').value;
  let unidadeId = document.querySelector('[name="unidadeId"]').options[document.querySelector(
    '[name="unidadeId"]').selectedIndex].text;

  let modalContent = `
    <div class="row g-3">
      <div class="col-12 col-sm-4">
        <div>Ano:</div>
        <div class="form-control input-disabled">${riscoAno}</div>
      </div>

      <div class="col-12 col-sm-8">
        <div>Unidade:</div>
        <div class="form-control input-disabled">${unidadeId}</div>
      </div>

      <div class="col-12">
        <div>Responsável:</div>
        <div class="form-control input-disabled">${responsavelRisco}</div>
      </div>

      <div class="col-12">
        <div>Evento de Risco:</div>
        <div class="form-control input-disabled">${riscoEvento}</div>
      </div>

      <div class="col-12">
        <div>Causa do Risco:</div>
        <div class="form-control input-disabled">${riscoCausa}</div>
      </div>        

      <div class="col-12">
        <div>Causa da consequência:</div>
        <div class="form-control input-disabled">${riscoConsequencia}</div>
      </div>
    </div>
  `;

  document.getElementById('modalContent').innerHTML = modalContent;

  let confirmationModal = new bootstrap.Modal(document.getElementById('confirmationModal'));
  confirmationModal.show();
}

function submitForm() {
  document.getElementById('formCreate').submit();
}

document.addEventListener("DOMContentLoaded", function() {
  var ckeditorConfig = {
    extraPlugins: 'wordcount',
    wordcount: {
      showCharCount: true,
      maxCharCount: 10000,
      maxCharCountMsg: 'Você atingiu o limite máximo de caracteres permitidos.',
      charCountMsg: 'Caracteres restantes: {0}'
    }
  };

  CKEDITOR.replace('riscoEvento',ckeditorConfig);
  CKEDITOR.replace('riscoCausa',ckeditorConfig);
  CKEDITOR.replace('riscoConsequencia',ckeditorConfig);
});
