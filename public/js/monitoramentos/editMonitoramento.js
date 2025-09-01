function showConfirmationModal() {
    let monitoramentoControleSugerido = CKEDITOR.instances['monitoramentoControleSugerido'].getData();
    let statusMonitoramento = document.getElementById('statusMonitoramento').value;
    let isContinuo = document.getElementById('isContinuo').value;
    let inicioMonitoramento = document.getElementById('inicioMonitoramento').value;
    let fimMonitoramento = document.getElementById('fimMonitoramento').value;

    function formatDate(dateString) {
        if (!dateString) return 'N/A';
        const [year, month, day] = dateString.split('-');
        return `${day}/${month}/${year}`;
    }

    let formattedInicioMonitoramento = formatDate(inicioMonitoramento);
    let formattedFimMonitoramento = formatDate(fimMonitoramento);

    let modalContent = `
        <div class="row g-3">
            <div class="col-12">
                <span>Controle Sugerido:</span>
                <textarea id="modalControleSugerido" class="form-control" rows="4">${monitoramentoControleSugerido}</textarea>
            </div>
        </div>

        <div class="row g-3 mt-1">
            <div class="col-12 col-sm-6">
                <span>Situação:</span>
                <input type="text" class="form-control input-disabled" value="${statusMonitoramento}" readonly>
            </div>

            <div class="col-12 col-sm-6">
                <span>É continuo?</span>
                <input type="text" class="form-control input-disabled" value="${isContinuo === '1' ? 'Sim' : 'Não'}" readonly>
            </div>
        </div>

        <div class="row g-3 mt-1 mb-2">
            <div class="col-sm-6">
                <span>Início:</span>
                <input type="text" class="form-control input-disabled" value="${formattedInicioMonitoramento}" readonly>
            </div>

            <div class="col-sm-6">
                <span>Fim:</span>
                <input type="text" class="form-control input-disabled" value="${formattedFimMonitoramento}" readonly>
            </div>
        </div>
    `;

    document.getElementById('modalContent').innerHTML = modalContent;

    CKEDITOR.replace('modalControleSugerido', {
        extraPlugins: 'wordcount',
        wordcount: {
            showCharCount: true,
            maxCharCount: 10000,
            maxCharCountMsg: 'Você atingiu o limite máximo de caracteres permitidos.',
            charCountMsg: 'Caracteres restantes: {0}'
        }
    });

    let confirmationModal = new bootstrap.Modal(document.getElementById('confirmationModal'));
    confirmationModal.show();
}

function toggleFimMonitoramento() {
    const isContinuo = document.getElementById('isContinuo').value;
    const fimMonitoramentoContainer = document.getElementById('fimMonitoramentoContainer');
    const fimMonitoramentoInput = document.getElementById('fimMonitoramento');

    if (isContinuo === '1') {
        fimMonitoramentoContainer.style.display = 'none';
        fimMonitoramentoInput.value = '';
    } else {
        fimMonitoramentoContainer.style.display = 'block';
    }
}

document.addEventListener('DOMContentLoaded', function () {
    toggleFimMonitoramento();

    document.getElementById('isContinuo').addEventListener('change', toggleFimMonitoramento);

    CKEDITOR.replace('monitoramentoControleSugerido', {
        extraPlugins: 'wordcount',
        wordcount: {
            showCharCount: true,
            maxCharCount: 10000,
            maxCharCountMsg: 'Você atingiu o limite máximo de caracteres permitidos.',
            charCountMsg: 'Caracteres restantes: {0}'
        }
    });
});

function submitForm() {
    document.getElementById('formEditMonitoramento').submit();
}
