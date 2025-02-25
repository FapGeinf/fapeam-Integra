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

  document.addEventListener('DOMContentLoaded', function () {
    let elemento = document.getElementById('eixo_ids');
    if (elemento) {
      new Choices(elemento);
    }
  });

  function mostrarUnidade() {
    var meta = document.getElementById('meta').value;
    var realizado = document.getElementById('realizado').value;
    var unidadeContainer = document.getElementById('unidade-container');
    if (meta != "" && realizado != "") {
      unidadeContainer.style.display = "block";

    } else {
      unidadeContainer.style.display = "none";
    }
}