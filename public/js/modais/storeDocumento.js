document.addEventListener("DOMContentLoaded", function () {
    const abrirConfirmacaoBtn = document.getElementById("abrirConfirmacaoBtn");
    const confirmarEnvioBtn = document.getElementById("confirmarEnvioBtn");
    const form = document.getElementById("formStoreDocumento");

    const selectTipo = document.getElementById("tipoDocumento");
    const inputAno = document.getElementById("anoDocumento");
    const inputAnexo = document.getElementById("arquivoDocumento");

    const confirmTipo = document.getElementById("confirmTipo");
    const confirmAno = document.getElementById("confirmAno");
    const confirmAnexo = document.getElementById("confirmAnexo");

    const errorConfirmTipo = document.getElementById("errorConfirmTipo");
    const errorConfirmAno = document.getElementById("errorConfirmAno");
    const errorConfirmAnexo = document.getElementById("errorConfirmAnexo");

    const previewContainer = document.getElementById("previewContainer");

    const confirmacaoModalEl = document.getElementById('confirmacaoModal');
    const confirmacaoModal = new bootstrap.Modal(confirmacaoModalEl);

    function limparErrosModal() {
        [confirmTipo, confirmAno, confirmAnexo].forEach(el => el.classList.remove("is-invalid"));
        errorConfirmTipo.innerText = "";
        errorConfirmAno.innerText = "";
        errorConfirmAnexo.innerText = "";
        confirmarEnvioBtn.classList.remove("d-none");
    }

    abrirConfirmacaoBtn.addEventListener("click", function () {
        limparErrosModal();

        // Preenche os campos do modal antes da validação
        confirmTipo.value = selectTipo.options[selectTipo.selectedIndex]?.text || 'Não preenchido';
        confirmAno.value = inputAno.value || 'Não preenchido';

        if (inputAnexo.files.length > 0) {
            confirmAnexo.value = inputAnexo.files[0].name;
        } else {
            confirmAnexo.value = 'Nenhum arquivo selecionado';
        }

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
            previewContainer.innerHTML = `<p>Nenhum arquivo selecionado</p>`;
        }

        let temErro = false;

        if (!selectTipo.value) {
            errorConfirmTipo.innerText = "Selecione o tipo de documento.";
            confirmTipo.classList.add("is-invalid");
            temErro = true;
        }

        if (!inputAno.value) {
            errorConfirmAno.innerText = "Informe o ano.";
            confirmAno.classList.add("is-invalid");
            temErro = true;
        }

        if (inputAnexo.files.length === 0) {
            errorConfirmAnexo.innerText = "Selecione um arquivo.";
            confirmAnexo.classList.add("is-invalid");
            temErro = true;
        }

        if (temErro) {
            confirmarEnvioBtn.classList.add("d-none");
        } else {
            confirmarEnvioBtn.classList.remove("d-none");
        }

        confirmacaoModal.show();
    });

    confirmarEnvioBtn.addEventListener("click", function () {
        form.submit();
    });
});
