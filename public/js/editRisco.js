function showConfirmationModal() {
    // Captura dos dados do formulário
    let riscoAno = document.getElementById('riscoAno').value;
    let responsavelRisco = document.getElementById('responsavelRisco').value;
    let riscoEvento = CKEDITOR.instances.riscoEvento.getData();
    let riscoCausa = CKEDITOR.instances.riscoCausa.getData();
    let riscoConsequencia = CKEDITOR.instances.riscoConsequencia.getData();
    let nivel_de_risco = document.getElementById('nivel_de_risco').value;
    let unidadeId = document.querySelector('[name="unidadeId"]').options[document.querySelector(
        '[name="unidadeId"]').selectedIndex].text;

    // Construção do HTML para o modal de confirmação
    let modalContent = `

        <div class="row g-3 mb-3">
            <div class="col-sm-4">
                <div>Ano:</div>
                <div class="modalBg form-control">${riscoAno}</div>
            </div>

            <div class="col-sm-8">
                <div>Unidade:</div>
                <div class="modalBg form-control">${unidadeId}</div>
            </div>
        </div>

        <div class="row g-3 mb-3">
            <div class="col-sm-12">
                <div>Responsável:</div>
                <div class="modalBg form-control">${responsavelRisco}</div>
            </div>
        </div>

        <div class="row g-3 mb-3">
            <div class="col-sm-12">
                <div>Evento de Risco:</div>
                <div class="modalBg form-control">${riscoEvento}</div>
            </div>
        </div>

        <div class="row g-3 mb-3">
            <div class="col-sm-12">
                <div>Causa do Risco:</div>
                <div class="modalBg form-control">${riscoCausa}</div>
            </div>
        </div>

        <div class="row g-3 mb-3">
            <div class="col-sm-12">
                <div>Causa da consequência:</div>
                <div class="modalBg form-control">${riscoConsequencia}</div>
            </div>
        </div>

        <hr>
        <p class="text-center mb-0">Deseja realmente salvar as alterações?</p>
    `;

    // Inserção do conteúdo no modal de confirmação
    document.getElementById('modalContent').innerHTML = modalContent;

    // Exibir o modal de confirmação
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
