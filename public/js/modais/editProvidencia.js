document.addEventListener("DOMContentLoaded", function () {
    const abrirConfirmacaoBtn = document.getElementById("abrirEditConfirmacaoBtn"); 
    const confirmarEdicaoBtn = document.getElementById("confirmarEdicaoBtn"); 
    const form = document.querySelector("#editRespostaForm");

    const selectStatus = document.querySelector('#statusMonitoramento');
    const inputAnexo = document.querySelector('#editRespostaAnexo');

    const spanStatus = document.getElementById("editConfirmStatus");
    const divProvidencia = document.getElementById("editConfirmProvidencia");
    const spanAnexo = document.getElementById("editConfirmAnexo");

    const editRespostaModalEl = document.getElementById('editRespostaModal');
    const editConfirmacaoModalEl = document.getElementById('editConfirmacaoModal');

    const editRespostaModal = new bootstrap.Modal(editRespostaModalEl);
    const editConfirmacaoModal = new bootstrap.Modal(editConfirmacaoModalEl);

    abrirConfirmacaoBtn.addEventListener("click", function () {
        let providenciaContent = '';
        if (typeof CKEDITOR !== 'undefined' && CKEDITOR.instances['editRespostaRisco']) {
            providenciaContent = CKEDITOR.instances['editRespostaRisco'].getData();
        } else {
            providenciaContent = document.querySelector('#editRespostaRisco').value;
        }

        spanStatus.textContent = selectStatus.options[selectStatus.selectedIndex].text;

        divProvidencia.innerHTML = providenciaContent || '<p>Não preenchido</p>';

        spanAnexo.textContent = inputAnexo.files.length > 0 ? inputAnexo.files[0].name : 'Nenhum arquivo selecionado';

        editRespostaModalEl.addEventListener('hidden.bs.modal', function handler() {
            editConfirmacaoModal.show();
            editRespostaModalEl.removeEventListener('hidden.bs.modal', handler);
        });

        editRespostaModal.hide();
    });

    confirmarEdicaoBtn.addEventListener("click", function () {
        form.submit();
    });

    // Quando o modal de confirmação for fechado, reabre o modal de edição
    editConfirmacaoModalEl.addEventListener('hidden.bs.modal', function () {
        editRespostaModal.show();
    });
});
