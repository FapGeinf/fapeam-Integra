@extends('layouts.app')

@section('content')
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Riscos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
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
            <table class="table table-bordered"> <!-- Adiciona uma classe mb-4 para criar espaço abaixo da tabela -->
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
