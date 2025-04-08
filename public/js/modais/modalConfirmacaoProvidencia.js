document.addEventListener('DOMContentLoaded', () => {
    const form = document.querySelector('#respostaModal form');
    const confirmModalElement = document.getElementById('confirmModal');
    const confirmModal = new bootstrap.Modal(confirmModalElement);

    form.addEventListener('submit', function (e) {
        e.preventDefault();

        if (typeof CKEDITOR !== 'undefined' && CKEDITOR.instances['respostaRisco']) {
            CKEDITOR.instances['respostaRisco'].updateElement();
        }

        const status = form.querySelector('[name="statusMonitoramento"]').value;
        const resposta = form.querySelector('[name="respostaRisco"]').value;
        const anexo = form.querySelector('[name="anexo"]').files[0];

        document.getElementById('confirmStatus').textContent = status;
        document.getElementById('confirmResposta').innerHTML = resposta || "<em>Sem providência.</em>";
        document.getElementById('confirmAnexo').textContent = anexo ? anexo.name : 'Nenhum anexo';

        const respostaModal = bootstrap.Modal.getInstance(document.getElementById('respostaModal'));
        respostaModal.hide();

        setTimeout(() => {
            confirmModal.show();
        }, 300);
    });

    document.getElementById('confirmSend').addEventListener('click', () => {
        form.submit();
    });

    document.getElementById('cancelConfirm').addEventListener('click', () => {
        document.body.classList.remove('modal-open');
        const backdrop = document.querySelector('.modal-backdrop');
        if (backdrop) backdrop.remove();
    });
});