document.addEventListener("DOMContentLoaded", function () {
    const abrirConfirmacaoBtn = document.getElementById("abrirConfirmacaoBtn");
    const confirmarEnvioBtn = document.getElementById("confirmarEnvioBtn");
    const form = document.getElementById("formStoreDocumento");

    const selectTipo = document.getElementById("tipoDocumento");
    const inputAno = document.getElementById("anoDocumento");
    const inputAnexo = document.getElementById("arquivoDocumento");

    const spanTipo = document.getElementById("confirmTipo");
    const spanAno = document.getElementById("confirmAno");
    const spanAnexo = document.getElementById("confirmAnexo");

    const confirmacaoModalEl = document.getElementById('confirmacaoModal');
    const confirmacaoModal = new bootstrap.Modal(confirmacaoModalEl);

    abrirConfirmacaoBtn.addEventListener("click", function () {
        document.getElementById("confirmTipo").value = selectTipo.options[selectTipo.selectedIndex].text || 'Não preenchido';
        document.getElementById("confirmAno").value = inputAno.value || 'Não preenchido';

        if (inputAnexo.files.length > 0) {
            document.getElementById("confirmAnexo").value = inputAnexo.files[0].name;
        } else {
            document.getElementById("confirmAnexo").value = 'Nenhum arquivo selecionado';
        }

        const file = inputAnexo.files[0];
        const previewContainer = document.getElementById("previewContainer");

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
            previewContainer.innerHTML = `<p>Nenhum arquivo selecionado</p>`;
        }

        confirmacaoModal.show();
    });


    confirmarEnvioBtn.addEventListener("click", function () {
        form.submit();
    });
});