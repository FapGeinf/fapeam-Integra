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
		<div class="error-message alertShow pt-4">
    	@if($errors->any())
      	<div class="alert alert-danger d-flex justify-content-center">
        	@foreach ($errors->all() as $error )
             <p>{{$error}}</p>
        	@endforeach
      	</div>
    	@endif
  	</div>

    <div class="container-xxl d-flex justify-content-center pt-5">
        <div class="col-12 col-md-8 col-lg-7 box-shadow pb-5">

    <div class="form-wrapper pt-4">
        <div class="form_create">
            <h3 style="text-align: center; margin-bottom:20px;">
                Novo Evento de Risco Inerente
            </h3>
            <hr>

            <form action="{{ route('riscos.store') }}" method="post" id="formCreate">
                @csrf

                <div class="row g-3">
                    <div class="col-sm-4 col-md-3">
                        <label class="dataLim" for="riscoNum">N° do Risco:</label>
                        <div class="dateTime">
                            <input type="text" name="riscoNum" id="" class="textInput form-control">
                        </div>
                    </div>

                    <div class="col-sm-4 col-md-3">
                        <label for="riscoAno">Insira o Ano:</label>
                        <input type="text" id="riscoAno" name="riscoAno" class="form-control dataValue">
                    </div>

                    <div class="col-sm-4 col-md-6 selectUnidade">
                        <label for="unidadeId">Unidade:</label>
                        <select name="unidadeId" class="" required>
                            <option selected disabled>Selecione uma unidade</option>
                            @foreach($unidades as $unidade)
                            <option value="{{ $unidade->id }}">{{ $unidade->unidadeNome }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <label class="dataLim" for="responsavel">Responsável:</label>
                <input type="text" name="responsavelRisco" id="responsavel" class="textInput form-control"
                    placeholder="Ex: Fulano da Silva Pompeo">

                <label for="riscoEvento">Evento de Risco Inerente:</label>
                <textarea id="riscoEvento" name="riscoEvento" class="textInput" required></textarea>

                <label for="riscoCausa">Causa do Risco:</label>
                <textarea id="riscoCausa" name="riscoCausa" class="textInput" required></textarea>

                <label for="riscoConsequencia">Causa da Consequência:</label>
                <textarea id="riscoConsequencia" name="riscoConsequencia" class="textInput" required></textarea>

                <div class="row g-3">
                    <div class="col-sm-6 col-md-6">
                        <label for="probabilidade_risco">Probabilidade de Risco:</label>
                        <select name="probabilidade_risco" id="probabilidade_risco" required
                            onchange="calculateRiscoAvaliacao()">
                            <option value="1">Baixo</option>
                            <option value="3">Médio</option>
                            <option value="5">Alto</option>
                        </select>
                    </div>

                    <div class="col-sm-6 col-md-6">
                        <label for="impacto_risco">Impacto do Risco:</label>
                        <select name="impacto_risco" id="impacto_risco" required onchange="calculateRiscoAvaliacao()">
                            <option value="1">Baixo</option>
                            <option value="3">Médio</option>
                            <option value="5">Alto</option>
                        </select>
                    </div>
                </div>

                <input type="hidden" name="riscoAvaliacao" id="riscoAvaliacao">

                <div id="monitoramentosDiv" class="monitoramento"></div>

                <hr>

                <div class="mt-3 text-end">
                  <input type="button" onclick="addMonitoramentos()" value="Adicionar Monitoramento" class="blue-btn">
                  <input type="submit" value="Salvar" class="green-btn">
                </div>


                <input type="hidden" id="isContinuoHidden" name="isContinuo" value="false">
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
        CKEDITOR.replace('riscoEvento');
        CKEDITOR.replace('riscoCausa');
        CKEDITOR.replace('riscoConsequencia');

        let cont = 0;

        function addMonitoramentos() {
            let monitoramentosDiv = document.getElementById('monitoramentosDiv');

            let novoMonitoramento = document.createElement('div');
            novoMonitoramento.id = `monitoramento${cont}`;
            novoMonitoramento.classList.add('monitoramento');
            monitoramentosDiv.appendChild(novoMonitoramento);

            let label = document.createElement('label');
            label.textContent = `Monitoramento N° ${cont + 1}`;
            novoMonitoramento.appendChild(label);

            let divControleSugerido = document.createElement('div');
            divControleSugerido.classList = 'form-group';
            novoMonitoramento.appendChild(divControleSugerido);

            let controleSugerido = document.createElement('textarea');
            controleSugerido.name = `monitoramentos[${cont}][monitoramentoControleSugerido]`;
            controleSugerido.placeholder = 'Monitoramento';
            controleSugerido.classList = 'form-control textInput';
            controleSugerido.id = `monitoramentoControleSugerido${cont}`;
            divControleSugerido.appendChild(controleSugerido);

            CKEDITOR.replace(`monitoramentoControleSugerido${cont}`);

            let divStatusMonitoramento = document.createElement('div');
            divStatusMonitoramento.classList = 'form-group';
            novoMonitoramento.appendChild(divStatusMonitoramento);

            let labelStatusMonitoramento = document.createElement('label');
            labelStatusMonitoramento.textContent = 'Status do Monitoramento:';
            divStatusMonitoramento.appendChild(labelStatusMonitoramento);

            let statusMonitoramento = document.createElement('select');
            statusMonitoramento.name = `monitoramentos[${cont}][statusMonitoramento]`;
            statusMonitoramento.classList = 'textInput';

            let options = [
                { value: "NÃO IMPLEMENTADA", text: "NÃO IMPLEMENTADA" },
                { value: "EM IMPLEMENTAÇÃO", text: "EM IMPLEMENTAÇÃO" },
                { value: "IMPLEMENTADA PARCIALMENTE", text: "IMPLEMENTADA PARCIALMENTE" },
                { value: "IMPLEMENTADA", text: "IMPLEMENTADA" }
            ];

            options.forEach(function(optionData) {
                let option = document.createElement('option');
                option.value = optionData.value;
                option.text = optionData.text;
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
            execucaoMonitoramento.placeholder = 'Execução do Monitoramento';
            execucaoMonitoramento.classList = 'form-control textInput';
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

            let optionSim = document.createElement('option');
            optionSim.value = 1;
            optionSim.textContent = 'Sim';
            selectIsContinuo.appendChild(optionSim);

            let optionNao = document.createElement('option');
            optionNao.value = 0;
            optionNao.textContent = 'Não';
            selectIsContinuo.appendChild(optionNao);

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

            cont++;

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

        }

        function calculateRiscoAvaliacao() {
            const probabilidade = document.getElementById('probabilidade_risco').value;
            const impacto = document.getElementById('impacto_risco').value;
            const avaliacao = probabilidade * impacto;
            document.getElementById('riscoAvaliacao').value = avaliacao;
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
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>

</body>

</html>
@endsection

