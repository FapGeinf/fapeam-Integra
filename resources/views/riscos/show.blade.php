@extends('layouts.app')

@section('content')
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Riscos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa; /* Cor de fundo do corpo */
        }

        .container-fluid{
            position: relative;
            top: 120px;
            display: flex;
            justify-content: center;
        }

        .box-shadow {
            box-shadow: 0 .5rem 1rem rgba(0, 0, 0, .15); /* Adiciona sombra à caixa */
            border-radius: .25rem; /* Borda arredondada */
            background-color: #fff; /* Cor de fundo da caixa */
            padding: 20px; /* Espaçamento interno */
            margin-bottom: 30px; /* Espaçamento abaixo da caixa */
        }

        .table th,
        .table td {
            vertical-align: middle; /* Alinha verticalmente o conteúdo da célula */
        }

        .text-center {
            text-align: center; /* Alinha o texto no centro */
        }

        .text-light {
            color: #f8f9fa !important; /* Cor do texto claro */
        }

        .bg-dark {
            background-color: #343a40 !important; /* Cor de fundo escura */
        }

        .mb-4 {
            margin-bottom: 1.5rem !important; /* Espaçamento abaixo de 1.5rem */
        }
    </style>
</head>
<body>
    <div class="container-fluid pt-4">
        <div class="box-shadow">
            <h1 class="text-center mb-4">Risco Detalhado</h1>
            <table class="table table-bordered mb-4">
                <thead>
                    <tr>
                        <th scope="col" class="text-center text-light bg-dark">Evento</th>
                        <th scope="col" class="text-center text-light bg-dark">Causa</th>
                        <th scope="col" class="text-center text-light bg-dark">Consequência</th>
                        <th scope="col" class="text-center text-light bg-dark">Avaliação</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="text-center">{{ $risco->riscoEvento }}</td>
                        <td class="text-center">{{ $risco->riscoCausa }}</td>
                        <td class="text-center">{{ $risco->riscoConsequencia }}</td>
                        <td class="text-center">{{ $risco->riscoAvaliacao }}</td>
                    </tr>
                </tbody>
            </table>
            <h2 class="text-center mb-4">Monitoramentos</h2>
            <table class="table table-bordered mb-4">
                <thead>
                    <tr>
                        <th scope="col" class="text-center text-light bg-dark">Controle Sugerido</th>
                        <th scope="col" class="text-center text-light bg-dark">Status</th>
                        <th scope="col" class="text-center text-light bg-dark">Execução</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($risco->monitoramentos as $monitoramento)
                    <tr>
                        <td class="text-center">{{ $monitoramento->monitoramentoControleSugerido }}</td>
                        <td class="text-center">{{ $monitoramento->statusMonitoramento }}</td>
                        <td class="text-center">{{ $monitoramento->execucaoMonitoramento }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
@endsection
