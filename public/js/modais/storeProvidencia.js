document.addEventListener("DOMContentLoaded", function () {
    const abrirConfirmacaoBtn = document.getElementById("abrirConfirmacaoBtn");
    const confirmarEnvioBtn = document.getElementById("confirmarEnvioBtn");
    const form = document.querySelector("#respostaModal form");

    const selectStatus = document.querySelector('[name="statusMonitoramento"]');
    const inputAnexo = document.querySelector('[name="anexo"]');

    const spanStatus = document.getElementById("confirmStatus");
    const divProvidencia = document.getElementById("confirmProvidencia");
    const spanAnexo = document.getElementById("confirmAnexo");

    const respostaModalEl = document.getElementById('respostaModal');
    const confirmacaoModalEl = document.getElementById('confirmacaoModal');

    const respostaModal = new bootstrap.Modal(respostaModalEl);
    const confirmacaoModal = new bootstrap.Modal(confirmacaoModalEl);

    abrirConfirmacaoBtn.addEventListener("click", function () {
        let providenciaContent = '';
        if (typeof CKEDITOR !== 'undefined' && CKEDITOR.instances['respostaRisco']) {
            providenciaContent = CKEDITOR.instances['respostaRisco'].getData();
        } else {
            providenciaContent = document.querySelector('[name="respostaRisco"]').value;
        }

        spanStatus.textContent = selectStatus.options[selectStatus.selectedIndex].text;

        divProvidencia.innerHTML = providenciaContent || '<p>Não preenchido</p>';

        spanAnexo.textContent = inputAnexo.files.length > 0 ? inputAnexo.files[0].name : 'Nenhum arquivo selecionado';

        respostaModalEl.addEventListener('hidden.bs.modal', function handler() {
            confirmacaoModal.show();
            respostaModalEl.removeEventListener('hidden.bs.modal', handler);
        });

        respostaModal.hide();
    });

    confirmarEnvioBtn.addEventListener("click", function () {
        form.submit();
    });

    confirmacaoModalEl.addEventListener('hidden.bs.modal', function () {
        respostaModal.show();
    });
});
