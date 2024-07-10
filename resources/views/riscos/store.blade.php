@extends('layouts.app')

@section('content')

@section('title') {{ 'Novo Risco Inerente' }} @endsection

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="/ckeditor/ckeditor.js"></script>
    <link rel="stylesheet" href="{{ asset('css/edit.css') }}">
</head>

<body>
    <div class="error-message">
        @if($errors->any())
             <div class="alert alert-danger">
                 <ul style="list-style-type:none;">
                     @foreach ($errors->all() as $error )
                         <li>{{$error}}</li>
                     @endforeach
                 </ul>
             </div>
         @endif
     </div>

    <div class="form-wrapper pt-4">
        <div class="form_create">
            <h3 style="text-align: center; margin-bottom:5px;">
                Novo Evento de Risco Inerente
            </h3>

            <span class="tipWarning mb-3">
                <span class="asteriscoTop">*</span>
                    Campos obrigatórios
            </span>

            <form action="{{ route('riscos.store') }}" method="post" id="formCreate">
                @csrf

                <div class="row g-3">
                    <div class="col-sm-4 col-md-3">
                        <label for="riscoAno">Insira o Ano:<span class="asterisco">*</span></label>
                        <input type="text" id="riscoAno" name="riscoAno" class="form-control dataValue" placeholder="0000" minlength="4" maxlength="4" required>
                    </div>

                    <div class="col-sm-4 col-md-9 selectUnidade">
                        <label for="unidadeId">Unidade:<span class="asterisco">*</span></label>
                        <select name="unidadeId" class="" required>
                            <option selected disabled>Selecione uma unidade</option>
                            @foreach($unidades as $unidade)
                            <option value="{{ $unidade->id }}">{{ $unidade->unidadeNome }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <label class="dataLim" for="responsavel">Responsável:<span class="asterisco">*</span></label>
                <input type="text" name="responsavelRisco" id="responsavel" class="textInput form-control" placeholder="Ex: Fulano da Silva Pompeo" maxlength="100" required>

                <label for="riscoEvento">Evento de Risco Inerente:<span class="asterisco">*</span></label>
                <textarea id="riscoEvento" name="riscoEvento" class="textInput" required></textarea>

                <label for="riscoCausa">Causa do Risco:<span class="asterisco">*</span></label>
                <textarea id="riscoCausa" name="riscoCausa" class="textInput" required></textarea>

                <label for="riscoConsequencia">Causa da Consequência:<span class="asterisco">*</span></label>
                <textarea id="riscoConsequencia" name="riscoConsequencia" class="textInput" required></textarea>

                <div class="row g-3">
                    <div class="col-sm-6 col-md-6">
                        <label for="nivel_de_risco">Nivel de Risco:<span class="asterisco">*</span></label>
                        <select name="nivel_de_risco" id="nivel_de_risco" required>
                            <option value="1">Baixo</option>
                            <option value="2">Médio</option>
                            <option value="3">Alto</option>
                        </select>
                    </div>
                </div>



                <div id="monitoramentosDiv" class="monitoramento"></div>

                <hr>

                <div class="mt-3 text-end">
                  <input type="button" onclick="addMonitoramentos()" value="Adicionar Monitoramento" class="blue-btn">
                  <input type="submit" value="Salvar" class="green-btn green-btn-store">
                </div>


            </form>
        </div>
    </div>

    <div class="modal fade" id="alertModal" tabindex="-1" aria-labelledby="alertModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="alertModalLabel">Aviso</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Adicione pelo menos um monitoramento antes de enviar o formulário.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>

    <script>
<<<<<<< Updated upstream
        CKEDITOR.replace('riscoEvento').on('required',function(evt){
					alert('É necessario a inserção' );
					evt.cancel();
					console.log('CKeditor vazio');
				});
        CKEDITOR.replace('riscoCausa').on('required',function(evt){
					alert('É necessario a inserção' );
					evt.cancel();
					console.log('CKeditor vazio');
				});
        CKEDITOR.replace('riscoConsequencia').on('required',function(evt){
					alert('É necessario a inserção' );
					evt.cancel();
					console.log('CKeditor vazio');
				});

=======
        CKEDITOR.replace('riscoEvento');
        CKEDITOR.replace('riscoCausa');
        CKEDITOR.replace('riscoConsequencia');
    
>>>>>>> Stashed changes
        let cont = 0;
    
        function addMonitoramentos() {
            let monitoramentosDiv = document.getElementById('monitoramentosDiv');
    
            // Criando um contêiner para o monitoramento e seus elementos associados
            let monitoramentoContainer = document.createElement('div');
            monitoramentoContainer.classList.add('monitoramento-container');
    
            // Adicionando o trecho de código solicitado
            let novoEventoTitulo = document.createElement('h4');
            novoEventoTitulo.style.textAlign = 'center';
            novoEventoTitulo.style.marginTop = '1rem';
            novoEventoTitulo.textContent = 'Novo Monitoramento';
            monitoramentoContainer.appendChild(novoEventoTitulo);
    
            let hrMonitoramento = document.createElement('hr');
            monitoramentoContainer.appendChild(hrMonitoramento);
    
            let novoMonitoramento = document.createElement('div');
            let monitoramentoId = `monitoramento${cont}`;
            novoMonitoramento.id = monitoramentoId;
            novoMonitoramento.classList.add('monitoramento');
            monitoramentoContainer.appendChild(novoMonitoramento);
    
            // Criando a div com a classe 'labelDel'
            let divLabelDel = document.createElement('div');
            divLabelDel.classList.add('labelDel');
    
            // Criando o label
            let label = document.createElement('label');
            label.textContent = `Monitoramento N° ${cont + 1}`;
    
            // Criando o ícone de exclusão com a palavra "Fechar"
            let deleteWrapper = document.createElement('div');
            deleteWrapper.style.display = 'flex';
            deleteWrapper.style.alignItems = 'center';
            deleteWrapper.style.gap = '2px';
            deleteWrapper.style.cursor = 'pointer';
    
            let deleteIcon = document.createElement('i');
            deleteIcon.classList.add('bi', 'bi-trash3-fill', 'text-danger');
            deleteIcon.title = 'Excluir';
    
            let deleteText = document.createElement('span');
            deleteText.textContent = 'Excluir';
            deleteText.classList.add('text-danger');
    
            deleteWrapper.appendChild(deleteIcon);
            deleteWrapper.appendChild(deleteText);
            deleteWrapper.onclick = function() {
                monitoramentosDiv.removeChild(monitoramentoContainer);
                cont--; // Decrementa o contador ao excluir um monitoramento
            };
    
            // Adicionando os elementos à div 'labelDel'
            divLabelDel.appendChild(label);
            divLabelDel.appendChild(deleteWrapper);
    
            // Adicionando a div 'labelDel' ao contêiner 'novoMonitoramento'
            novoMonitoramento.appendChild(divLabelDel);
    
            let divControleSugerido = document.createElement('div');
            divControleSugerido.classList = 'form-group';
            novoMonitoramento.appendChild(divControleSugerido);
    
            let controleSugerido = document.createElement('textarea');
            controleSugerido.name = `monitoramentos[${cont}][monitoramentoControleSugerido]`;
            controleSugerido.placeholder = 'Monitoramento';
            controleSugerido.classList = 'form-control textInput';
            controleSugerido.id = `monitoramentoControleSugerido${cont}`;
            divControleSugerido.appendChild(controleSugerido);
    
            let divStatusMonitoramento = document.createElement('div');
            divStatusMonitoramento.classList = 'form-group';
            novoMonitoramento.appendChild(divStatusMonitoramento);
    
            let labelStatusMonitoramento = document.createElement('label');
            labelStatusMonitoramento.textContent = 'Status do Monitoramento:';
            divStatusMonitoramento.appendChild(labelStatusMonitoramento);
    
            let statusMonitoramento = document.createElement('select');
            statusMonitoramento.name = `monitoramentos[${cont}][statusMonitoramento]`;
            statusMonitoramento.classList = 'form-select';
    
            let options = [
                { value: "NÃO IMPLEMENTADA", text: "NÃO IMPLEMENTADA" },
                { value: "EM IMPLEMENTAÇÃO", text: "EM IMPLEMENTAÇÃO" },
                { value: "IMPLEMENTADA PARCIALMENTE", text: "IMPLEMENTADA PARCIALMENTE" },
                { value: "IMPLEMENTADA", text: "IMPLEMENTADA" }
            ];
    
            options.forEach(function(optionData) {
                let option = document.createElement('option');
                option.value = optionData.value;
                option.textContent = optionData.text;
                statusMonitoramento.appendChild(option);
            });
    
            divStatusMonitoramento.appendChild(statusMonitoramento);
    
            let divExecucaoMonitoramento = document.createElement('div');
            divExecucaoMonitoramento.classList = 'form-group';
            novoMonitoramento.appendChild(divExecucaoMonitoramento);
    
            let labelExecucaoMonitoramento = document.createElement('label');
            labelExecucaoMonitoramento.textContent = 'Execução do Monitoramento:';
            divExecucaoMonitoramento.appendChild(labelExecucaoMonitoramento);
    
            let execucaoMonitoramento = document.createElement('input');
            execucaoMonitoramento.type = 'text';
            execucaoMonitoramento.name = `monitoramentos[${cont}][execucaoMonitoramento]`;
            execucaoMonitoramento.placeholder = '';
            execucaoMonitoramento.classList = 'form-control textInput';
						execucaoMonitoramento.required = true;
            divExecucaoMonitoramento.appendChild(execucaoMonitoramento);
    
            let divIsContinuo = document.createElement('div');
            divIsContinuo.classList.add('form-group');
            novoMonitoramento.appendChild(divIsContinuo);
    
            let labelIsContinuo = document.createElement('label');
            labelIsContinuo.textContent = 'Monitoramento Contínuo:';
            divIsContinuo.appendChild(labelIsContinuo);
    
            let selectIsContinuo = document.createElement('select');
            selectIsContinuo.name = `monitoramentos[${cont}][isContinuo]`;
            selectIsContinuo.classList.add('form-select');
    
            let optionNao = document.createElement('option');
            optionNao.value = 0;
            optionNao.textContent = 'Não';
            selectIsContinuo.appendChild(optionNao);
    
            let optionSim = document.createElement('option');
            optionSim.value = 1;
            optionSim.textContent = 'Sim';
            selectIsContinuo.appendChild(optionSim);
    
            divIsContinuo.appendChild(selectIsContinuo);
    
            let divRow = document.createElement('div');
            divRow.classList = 'row g-3';
            novoMonitoramento.appendChild(divRow);
    
            let divInicioMonitoramento = document.createElement('div');
            divInicioMonitoramento.classList = 'col-sm-6 col-md-6';
            divRow.appendChild(divInicioMonitoramento);
    
            let labelInicioMonitoramento = document.createElement('label');
            labelInicioMonitoramento.textContent = 'Início do Monitoramento:';
            divInicioMonitoramento.appendChild(labelInicioMonitoramento);
    
            let inputInicioMonitoramento = document.createElement('input');
            inputInicioMonitoramento.type = 'date';
            inputInicioMonitoramento.name = `monitoramentos[${cont}][inicioMonitoramento]`;
            inputInicioMonitoramento.classList = 'form-control textInput dateInput';
            divInicioMonitoramento.appendChild(inputInicioMonitoramento);
    
            let divFimMonitoramento = document.createElement('div');
            divFimMonitoramento.classList = 'col-sm-6 col-md-6';
            divRow.appendChild(divFimMonitoramento);
    
            let labelFimMonitoramento = document.createElement('label');
            labelFimMonitoramento.textContent = 'Fim do Monitoramento:';
            divFimMonitoramento.appendChild(labelFimMonitoramento);
    
            let inputFimMonitoramento = document.createElement('input');
            inputFimMonitoramento.type = 'date';
            inputFimMonitoramento.name = `monitoramentos[${cont}][fimMonitoramento]`;
            inputFimMonitoramento.classList = 'form-control textInput dateInput';
            divFimMonitoramento.appendChild(inputFimMonitoramento);
    
            inputFimMonitoramento.addEventListener('change', function() {
                let isContinuoValue = (this.value !== '') ? 'false' : 'true';
                document.getElementById(`isContinuo${cont}`).value = isContinuoValue;
            });
    
            // Evento para controlar a exibição do input de data fimMonitoramento
            selectIsContinuo.addEventListener('change', function() {
                if (this.value == 1) {
                    inputFimMonitoramento.value = '';
                    inputFimMonitoramento.hidden = true;
                    labelFimMonitoramento.hidden = true;
                } else if(this.value == 0) {
                    labelFimMonitoramento.hidden = false;
                    inputFimMonitoramento.hidden = false;
                }
            });
    
            monitoramentosDiv.appendChild(monitoramentoContainer);
<<<<<<< Updated upstream
						function teste(){
							console.log('entrou')
						}

            // Inicializar CKEditor após adicionar o contêiner ao DOM
            CKEDITOR.replace(`monitoramentoControleSugerido${cont}`).on('required', function(evt){
							alert('É necessario a inserção' );
							evt.cancel();
							console.log('CKeditor vazio');
						});
=======
    
            // Inicializar CKEditor após adicionar o contêiner ao DOM
            CKEDITOR.replace(`monitoramentoControleSugerido${cont}`);
    
>>>>>>> Stashed changes
            cont++;
        }
    
        document.getElementById('formCreate').addEventListener('submit', function (event) {
            let monitoramentosDiv = document.getElementById('monitoramentosDiv');
            if (monitoramentosDiv.children.length === 0) {
                event.preventDefault();
                let alertModal = new bootstrap.Modal(document.getElementById('alertModal'));
                alertModal.show();
            }
        });
    </script>
    
    
    
    



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>

</body>

</html>
@endsection
