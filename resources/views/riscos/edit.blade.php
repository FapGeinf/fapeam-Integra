@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulário de Risco</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        .form-wrapper {
            display: flex;
            justify-content: center; /* Centraliza horizontalmente */
            align-items: center; /* Centraliza verticalmente */
            min-height: 100vh; /* Altura mínima total da viewport */
            padding: 0 10px; /* Adiciona espaçamento à esquerda e à direita */
        }

        .form_create {
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            width: 100%; /* Largura total do contêiner pai */
            max-width: 600px; /* Largura máxima do formulário */
        }

        .form_create label {
            font-weight: bold;
            margin-bottom: 5px;
        }

        .form_create .textInput {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .form_create select {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            appearance: none;
            background-image: url('data:image/svg+xml;utf8,<svg fill="#000000" height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg"><path d="M7 10l5 5 5-5z"/><path d="M0 0h24v24H0z" fill="none"/></svg>');
            background-repeat: no-repeat;
            background-position: calc(100% - 10px) center;
        }

        .form_create button {
            border: none;
            border-radius: 4px;
            padding: 10px 20px;
            cursor: pointer;
            font-size: 16px;
            margin-right: 10px; /* Adiciona margem à direita */
            transition: background-color 0.3s;
        }

        .form_create button.add-btn {
            background-color: #007bff;
            color: #fff;
        }

        .form_create button.add-btn:hover {
            background-color: #0056b3;
        }

        .form_create button.close-btn {
            background-color: #dc3545;
            color: white;
        }

        .form_create button.close-btn:hover {
            background-color: #c82333;
        }

        .form_create button.submit-btn {
            background-color: #28a745;
            color: white;
        }

        .form_create button.submit-btn:hover {
            background-color: #218838;
        }

        .add-monitoramento-btn {
            display: flex;
            align-items: center;
            justify-content: flex-start;
            margin-bottom: 15px;
        }

        .add-monitoramento-btn i {
            margin-right: 5px;
            color: #007bff;
        }

        /* Estilo para a numeração dos monitoramentos */
        .numeration {
            font-weight: bold;
            margin-right: 5px;
        }

        /* Estilo para cada monitoramento */
        .monitoramento {
            position: relative;
            margin-bottom: 15px;
        }

        /* Estilo para o botão de adicionar monitoramento */
        .add-monitoramento-btn {
            margin-top: 15px;
            margin-bottom: 30px;
        }

        @media screen and (max-width: 480px) {
            .form_create {
                padding: 20px 10px;
            }
        }
    </style>
</head>
<body>
    @if(session('error'))
        <script>alert('{{ session('error') }}');</script>
    @endif
    <div class="form-wrapper">
        <div class="form_create">
            <h2 style="text-align: center; margin-bottom: 20px;">Formulário de Risco</h2>
            <form action="{{ route('riscos.update', ['id' => $risco->id]) }}" method="post" id="formCreate">
                @csrf
                @method('PUT')
                <input type="hidden" name="risco_id" value="{{ $risco->id }}">
                <label for="riscoEvento">Evento</label>
                <textarea type="text" name="riscoEvento" class="textInput" required>{{ $risco->riscoEvento ?? old('riscoEvento') }}</textarea>

                <label for="riscoCausa">Causa</label>
                <textarea type="text" name="riscoCausa" class="textInput" required>{{ $risco->riscoCausa ?? old('riscoCausa') }}</textarea>

                <label for="riscoConsequencia">Consequência</label>
                <textarea type="text" name="riscoConsequencia" class="textInput" required>{{ $risco->riscoConsequencia ?? old('riscoConsequencia') }}</textarea>

                <label for="riscoAvaliacao">Avaliação</label>
                <input type="number" name="riscoAvaliacao" class="textInput" value="{{ $risco->riscoAvaliacao ?? old('riscoAvaliacao') }}" required>

                <label for="unidadeId">Unidade</label>
                <select name="unidadeId" required>
                    <option selected disabled>Selecione uma unidade</option>
                    @foreach($unidades as $unidade)
                        <option value="{{ $unidade->id }}" {{ isset($risco) && $risco->unidadeId == $unidade->id ? 'selected' : '' }}>{{ $unidade->unidadeNome }}</option>
                    @endforeach
                </select>

                <div>
                    <span>Monitoramentos adicionados: </span>
                    <span id="monitoramentoCounter">{{ count($risco->monitoramentos) }}</span>
                </div>

                <div id="monitoramentosDiv" class="monitoramento"></div>
                <button type="button" class="add-btn" onclick="addMonitoramentos()">Adicionar Monitoramento</button>
                <button type="button" class="close-btn" onclick="fecharFormulario()">Fechar</button>
                <button type="submit" class="submit-btn">Salvar</button>

            </form>
        </div>
    </div>



    <script>

          let cont = {{ count($risco->monitoramentos) }};

          let monitoramentoCounter = document.getElementById('monitoramentoCounter');

          function updateCounter() {
             monitoramentoCounter.textContent = cont;
          }

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
            execucaoMonitoramento.value = '';

            let monitoramentosDiv = document.getElementById('monitoramentosDiv');
            monitoramentosDiv.appendChild(controleSugerido);
            monitoramentosDiv.appendChild(statusMonitoramento);
            monitoramentosDiv.appendChild(execucaoMonitoramento);

            let monitoramentoDiv = document.createElement('div');
            monitoramentoDiv.classList.add('monitoramento');
            let numeration = document.createElement('span');
            numeration.classList.add('numeration');
            numeration.textContent = `Monitoramento Nº ${cont + 1}`;
            monitoramentoDiv.appendChild(numeration);
            document.getElementById('monitoramentosDiv').appendChild(monitoramentoDiv);
            cont++;
            updateCounter();
        }

        function fecharFormulario() {
            document.getElementById('monitoramentosDiv').innerHTML = ''; // Limpa o conteúdo dos monitoramentos
            cont = 0; // Reseta o contador
            updateCounter(); // Atual
        }

        updateCounter();
    </script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>

</body>
</html>
@endsection
