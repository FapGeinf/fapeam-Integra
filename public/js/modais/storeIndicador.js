function showConfirmationModal() {
    let eixoSelect = document.querySelector('[name="eixo_fk"]');
    let eixo = eixoSelect.options[eixoSelect.selectedIndex].text;
    let nomeIndicador = document.getElementById('nomeIndicador').value;
    let descricaoIndicador = CKEDITOR.instances['descricaoIndicador'].getData();


    let modalContent = `
        <div class="row g-3">
            <div class="col-12">
                <span><strong>Eixo:</strong></span>
                <input type="text" class="form-control input-disabled" value="${eixo}" readonly>
            </div>

            <div class="col-12">
                <span><strong>Nome do Indicador:</strong></span>
                <input type="text" class="form-control input-disabled" value="${nomeIndicador}" readonly>
            </div>

            <div class="col-12">
                <span><strong>Descrição do Indicador:</strong></span>
                <div class="border rounded p-2" style="background-color: #f8f9fa;">${descricaoIndicador}</div>
            </div>
        </div>
    `;

    document.getElementById('modalContent').innerHTML = modalContent;
    let confirmationModal = new bootstrap.Modal(document.getElementById('confirmationModal'));
    confirmationModal.show();

}

function formSubmit() {
    document.getElementById('formStoreIndicador').submit();
}