 document.addEventListener("DOMContentLoaded", function () {
  let ckeditorConfig = {
    extraPlugins: 'wordcount',
    wordcount: {
    showCharCount: true,
    maxCharCount: 10000,
    charCountMsg: 'Caracteres restantes: {0}',
    maxCharCountMsg: 'Você atingiu o limite máximo de caracteres permitidos.'
    }
  };

  let ckeditorConfig2 = {
    extraPlugins: 'wordcount',
    wordcount: {
    showCharCount: true,
    maxCharCount: 255,
    charCountMsg: 'Caracteres restantes: {0}',
    maxCharCountMsg: 'Você atingiu o limite máximo de caracteres permitidos.'
    }
  };

  if (document.getElementById('atividade_descricao')) {
    CKEDITOR.replace('atividade_descricao', ckeditorConfig);
  }
  if (document.getElementById('objetivo')) {
    CKEDITOR.replace('objetivo', ckeditorConfig);
  }
  if (document.getElementById('publico_alvo')) {
    CKEDITOR.replace('publico_alvo', ckeditorConfig2);
  }
  if (document.getElementById('canal_divulgacao')) {
    CKEDITOR.replace('canal_divulgacao', ckeditorConfig2);
  }
  if (document.getElementById('justificativa')) {
    CKEDITOR.replace('justificativa', ckeditorConfig);
  }

  flatpickr("#data_prevista", {
    dateFormat: "Y-m-d",
    altInput: true,
    altFormat: "d/m/Y",
  });

  flatpickr("#data_realizada", {
    dateFormat: "Y-m-d",
    altInput: true,
    altFormat: "d/m/Y",
  });


});

  function mostrarUnidade() {
  var meta = document.getElementById('meta').value;
  var realizado = document.getElementById('realizado').value;
  var unidadeContainer = document.getElementById('unidade-container');

  if (meta > 0 || realizado > 0) {
    unidadeContainer.style.display = 'block';
  } else {
    unidadeContainer.style.display = 'none';
  }
  }

  document.addEventListener('DOMContentLoaded', function () {
  const publicoSelect = document.getElementById('publico_id');
  const outrosInputContainer = document.getElementById('outros-input-container');
  const novoPublicoInput = document.getElementById('novo_publico');

  publicoSelect.addEventListener('change', function () {
    if (this.value === 'outros') {
    outrosInputContainer.style.display = 'block';
    novoPublicoInput.required = true;

    } else {
    outrosInputContainer.style.display = 'none';
    novoPublicoInput.required = false;
    }
  });
});