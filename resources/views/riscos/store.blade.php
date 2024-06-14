@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulário de Risco</title>
    <style>
        .form_risco {
            border: solid 1px greenyellow;
            width: 100%;
            position: absolute;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .form_create {
            border: solid 1px red;
            display: flex;
            align-items: center;
            flex-direction: column;
            margin: 10px;
            padding: 10px;
            width: 20%;
        }

        .textInput {
            width: 100%;
            height: 10%;
        }

        .selection {
            margin: 10px;
        }

        @media screen and (max-width: 900px) {
            .form_risco {
                width: 100%;
            }

            .form_create {
                width: 75%;
            }

            .textInput {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="form_risco">
        <form action="{{ route('riscos.store') }}" method="post" class="form_create" id="formCreate">
            @csrf
            <label for="riscoEvento">Evento</label>
            <textarea type="text" name="riscoEvento" class="textInput" required></textarea>

            <label for="riscoCausa">Causa</label>
            <textarea type="text" name="riscoCausa" class="textInput" required></textarea>

            <label for="riscoConsequencia">Consequência</label>
            <textarea type="text" name="riscoConsequencia" class="textInput" required></textarea>

            <label for="riscoAvaliacao">Avaliação</label>
            <input type="number" name="riscoAvaliacao" class="textInput" required>

            <label for="unidadeId">Unidade</label>
            <select name="unidadeId" class="selection" required>
                <option selected disabled>Selecione uma unidade</option>
                @foreach($unidades as $unidade)
                    <option value="{{ $unidade->id }}">{{ $unidade->unidadeNome }}</option>
                @endforeach
            </select>

            <div id="monitoramentosDiv" class="monitoramento"></div>
            <input type="button" onclick="addMonitoramentos()" value="Adicionar Monitoramento">
            <button type="submit">Salvar</button>
        </form>
    </div>

    <script>
        let cont = 0;

        function addMonitoramentos() {
            let controleSugerido = document.createElement('input');
            controleSugerido.type = 'text';
            controleSugerido.name = `monitoramentos[${cont}][monitoramentoControleSugerido]`;
            controleSugerido.placeholder = 'Monitoramento';
            controleSugerido.classList = 'textInput';
            controleSugerido.value = ''; // Defina o valor padrão aqui se necessário

            let statusMonitoramento = document.createElement('input');
            statusMonitoramento.type = 'text';
            statusMonitoramento.name = `monitoramentos[${cont}][statusMonitoramento]`;
            statusMonitoramento.placeholder = 'Status do Monitoramento';
            statusMonitoramento.classList = 'textInput';
            statusMonitoramento.value = ''; // Defina o valor padrão aqui se necessário

            let execucaoMonitoramento = document.createElement('input');
            execucaoMonitoramento.type = 'text';
            execucaoMonitoramento.name = `monitoramentos[${cont}][execucaoMonitoramento]`;
            execucaoMonitoramento.placeholder = 'Execução do Monitoramento';
            execucaoMonitoramento.classList = 'textInput';
            execucaoMonitoramento.value = ''; // Defina o valor padrão aqui se necessário

            let monitoramentosDiv = document.getElementById('monitoramentosDiv');
            monitoramentosDiv.appendChild(controleSugerido);
            monitoramentosDiv.appendChild(statusMonitoramento);
            monitoramentosDiv.appendChild(execucaoMonitoramento);
            cont++;
        }
    </script>
</body>
</html>
@endsection
