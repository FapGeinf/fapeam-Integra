document.addEventListener("DOMContentLoaded", function () {
    const abrirConfirmacaoBtn = document.getElementById("abrirConfirmacaoBtn");
    const confirmarEnvioBtn = document.getElementById("confirmarEnvioBtn");
    const form = document.getElementById("formUpdateDocumento");

    const selectTipo = document.querySelector('[name="tipo_id"]');
    const inputAno = document.querySelector('[name="ano"]');
    const inputAnexo = document.querySelector('[name="path"]');

    const confirmTipo = document.getElementById("confirmTipo");
    const confirmAno = document.getElementById("confirmAno");
    const confirmAnexo = document.getElementById("confirmAnexo");
    const previewContainer = document.getElementById("previewContainer");

    const confirmacaoModalEl = document.getElementById('confirmacaoModal');
    const confirmacaoModal = new bootstrap.Modal(confirmacaoModalEl);

    abrirConfirmacaoBtn.addEventListener("click", function () {
        confirmTipo.value = selectTipo.options[selectTipo.selectedIndex].text || 'Não preenchido';
        confirmAno.value = inputAno.value || 'Não preenchido';

        if (inputAnexo.files.length > 0) {
            confirmAnexo.value = inputAnexo.files[0].name;
        } else {
            confirmAnexo.value = 'Mantendo arquivo atual';
        }

        // Gerar pré-visualização
        const file = inputAnexo.files[0];

        if (file) {
            const reader = new FileReader();
            const fileType = file.type;

            reader.onload = function (e) {
                if (fileType.startsWith("image/")) {
                    previewContainer.innerHTML = `<img src="${e.target.result}" alt="Pré-visualização" style="max-width: 100%; height: auto;">`;
                } else if (fileType === "application/pdf") {
                    previewContainer.innerHTML = `<embed src="${e.target.result}" type="application/pdf" width="100%" height="400px">`;
                } else {
                    previewContainer.innerHTML = `<p>Arquivo selecionado: ${file.name}</p>`;
                }
            };

            reader.readAsDataURL(file);
        } else {
            previewContainer.innerHTML = `<p>Mantendo arquivo atual</p>`;
        }

        confirmacaoModal.show();
    });

    confirmarEnvioBtn.addEventListener("click", function () {
        form.submit();
    });
});
