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

    <div class="form-wrapper pt-4">
        <div class="form_create">
            <h3 style="text-align: center; margin-bottom:20px;">
                Novo Evento de Risco Inerente
            </h3>
            <hr>

            <form action="{{ route('riscos.store') }}" method="post" id="formCreate">
                @csrf

                <div class="row g-3">
                    <div class="col-sm-8 col-md-8 selectUnidade">
                        <label for="unidadeId">Unidade:</label>
                        <select name="unidadeId" class="" required>
                            <option selected disabled>Selecione uma unidade</option>
                            @foreach($unidades as $unidade)
                            <option value="{{ $unidade->id }}">{{ $unidade->unidadeNome }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-sm-4 col-md-4">
                        <label for="riscoAno">Insira o Ano:</label>
                        <input type="text" id="riscoAno" name="riscoAno" class="form-control dataValue">
                    </div>
                </div>

                <label class="dataLim" for="responsavel">Responsável:</label>
                <input type="text" name="responsavel" id="responsavel" class="textInput form-control"
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

                <div id="monitoramentosDiv" class="monitoramento">
                    {{-- O BUG QUE NAO DEIXA SALVAR ESTA AQUI DENTRO  --}}
                    {{-- <h3 style="text-align: center; margin-top:40px">Monitoramentos</h3>
                    <hr>

                    <div id="monitoramento1">
                        <label>Monitoramento N° 1</label>
                        <textarea name="monitoramentos[0][monitoramentoControleSugerido]" placeholder="Monitoramento"
                            class="textInput" id="monitoramentoControleSugerido0"></textarea>

                        <label>Status do Monitoramento:</label>
                        <input type="text" name="monitoramentos[0][statusMonitoramento]"
                            placeholder="Status do Monitoramento" class="textInput">

                        <label>Execução do Monitoramento:</label>
                        <input type="text" name="monitoramentos[0][execucaoMonitoramento]"
                            placeholder="Execução do Monitoramento" class="textInput">

                        <div class="row g-3">
                            <div class="col-sm-6 col-md-6">
                                <label>Início do Monitoramento:</label>
                                <input type="date" name="monitoramentos[0][inicioMonitoramento]"
                                    class="textInput dateInput">
                            </div>
                            <div class="col-sm-6 col-md-6">
                                <label>Fim do Monitoramento:</label>
                                <input type="date" name="monitoramentos[0][fimMonitoramento]"
                                    class="textInput dateInput">
                            </div>
                        </div>
                    </div> --}}
                </div>

                <hr>

                <div class="text-center">
                    <button type="button" class="blue-btn" onclick="addMonitoramentos()">Adicionar Monitoramento</button>
                    <input type="submit" class="green-btn" value="Salvar">
                </div>

            </form>
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
            
            // let labelControleSugerido = document.createElement('label');
            // labelControleSugerido.textContent = 'Monitoramento:';
            // divControleSugerido.appendChild(labelControleSugerido);

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

            let statusMonitoramento = document.createElement('textarea');
            statusMonitoramento.name = `monitoramentos[${cont}][statusMonitoramento]`;
            statusMonitoramento.placeholder = 'Status do Monitoramento';
            statusMonitoramento.classList = 'form-control textInput';
            statusMonitoramento.id = `statusMonitoramento${cont}`;
            divStatusMonitoramento.appendChild(statusMonitoramento);

            CKEDITOR.replace(`statusMonitoramento${cont}`);

            let divExecucaoMonitoramento = document.createElement('div');
            divExecucaoMonitoramento.classList = 'form-group';
            novoMonitoramento.appendChild(divExecucaoMonitoramento);

            let labelExecucaoMonitoramento = document.createElement('label');
            labelExecucaoMonitoramento.textContent = 'Execução do Monitoramento:';
            divExecucaoMonitoramento.appendChild(labelExecucaoMonitoramento);

            let execucaoMonitoramento = document.createElement('textarea');
            execucaoMonitoramento.name = `monitoramentos[${cont}][execucaoMonitoramento]`;
            execucaoMonitoramento.placeholder = 'Execução do Monitoramento';
            execucaoMonitoramento.classList = 'form-control textInput';
            execucaoMonitoramento.id = `execucaoMonitoramento${cont}`;
            divExecucaoMonitoramento.appendChild(execucaoMonitoramento);

            CKEDITOR.replace(`execucaoMonitoramento${cont}`);

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

            cont++;
        }

        function calculateRiscoAvaliacao() {
            const probabilidade = document.getElementById('probabilidade_risco').value;
            const impacto = document.getElementById('impacto_risco').value;
            const avaliacao = probabilidade * impacto;
            document.getElementById('riscoAvaliacao').value = avaliacao;
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>

</body>

</html>
@endsection
