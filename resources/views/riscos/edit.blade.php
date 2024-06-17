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
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }

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
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            padding: 10px 20px;
            cursor: pointer;
            font-size: 16px;
        }

        .form_create button:hover {
            background-color: #0056b3;
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

        .remove-monitoramento-btn {
            background-color: #dc3545;
            color: white;
            border: none;
            border-radius: 4px;
            padding: 5px 10px;
            cursor: pointer;
            font-size: 12px;
            margin-left: 5px;
            position: relative;
            top: 5px;
        }

        .remove-monitoramento-btn:hover {
            background-color: #c82333;
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

                {{-- Monitoramentos existentes --}}
                @foreach ($risco->monitoramentos as $key => $monitoramento)
                    <div class="monitoramento">
                        <span class="numeration">Monitoramento Nº {{ $key + 1 }}</span>
                        <textarea type="text" name="monitoramentos[{{ $monitoramento->id }}][monitoramentoControleSugerido]" class="textInput" required>{{ $monitoramento->monitoramentoControleSugerido }}</textarea>
                        <textarea type="text" name="monitoramentos[{{ $monitoramento->id }}][statusMonitoramento]" class="textInput" required>{{ $monitoramento->statusMonitoramento }}</textarea>
                        <textarea type="text" name="monitoramentos[{{ $monitoramento->id }}][execucaoMonitoramento]" class="textInput" required>{{ $monitoramento->execucaoMonitoramento }}</textarea>

                        {{-- Botão para remover monitoramento --}}
                        <button type="button" class="remove-monitoramento-btn">Remover</button>
                    </div>
                @endforeach

                <!-- Div para adicionar monitoramentos -->
                <div id="monitoramentosDiv"></div>

                <!-- Botão para adicionar monitoramento -->
                <div class="add-monitoramento-btn">
                    <i class="fas fa-plus"></i>
                    <span>Adicionar Monitoramento</span>
                </div>

                <!-- Botão para salvar o formulário -->
                <button type="submit">Salvar</button>


            </form>
        </div>
    </div>



    <script>

        let cont = {{ count($risco->monitoramentos) }};

        document.querySelector('.add-monitoramento-btn').addEventListener('click', addMonitoramentos);

        function addMonitoramentos() {
            let monitoramentoDiv = document.createElement('div');
            monitoramentoDiv.classList.add('monitoramento');

            let numeration = document.createElement('span');
            numeration.classList.add('numeration');
            numeration.textContent = `Monitoramento Nº ${cont + 1}.`;
            monitoramentoDiv.appendChild(numeration);

            let controleSugerido = document.createElement('textarea');
            controleSugerido.type = 'text';
            controleSugerido.name = `monitoramentos[${cont}][monitoramentoControleSugerido]`;
            controleSugerido.placeholder = 'Monitoramento';
            controleSugerido.classList.add('textInput');
            controleSugerido.required = true;
            monitoramentoDiv.appendChild(controleSugerido);

            let statusMonitoramento = document.createElement('textarea');
            statusMonitoramento.type = 'text';
            statusMonitoramento.name = `monitoramentos[${cont}][statusMonitoramento]`;
            statusMonitoramento.placeholder = 'Status do Monitoramento';
            statusMonitoramento.classList.add('textInput');
            statusMonitoramento.required = true;
            monitoramentoDiv.appendChild(statusMonitoramento);

            let execucaoMonitoramento = document.createElement('textarea');
            execucaoMonitoramento.type = 'text';
            execucaoMonitoramento.name = `monitoramentos[${cont}][execucaoMonitoramento]`;
            execucaoMonitoramento.placeholder = 'Execução do Monitoramento';
            execucaoMonitoramento.classList.add('textInput');
            execucaoMonitoramento.required = true;
            monitoramentoDiv.appendChild(execucaoMonitoramento);

            let removeBtn = document.createElement('button');
            removeBtn.type = 'button';
            removeBtn.classList.add('remove-monitoramento-btn');
            removeBtn.textContent = 'Remover';
            removeBtn.addEventListener('click', () => {
                monitoramentoDiv.remove();
            });
            monitoramentoDiv.appendChild(removeBtn);

            document.getElementById('monitoramentosDiv').appendChild(monitoramentoDiv);
            cont++;
        }
    </script>

</body>
</html>
@endsection
