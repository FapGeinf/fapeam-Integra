<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Relatório de Logs</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            margin: 30px;
            color: #333;
            background-color: #fff;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #2c3e50;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 10px;
            border: 1px solid #ccc;
            text-align: left;
        }

        th {
            background-color: #f4f4f4;
        }

        tr:nth-child(even) {
            background-color: #fafafa;
        }
    </style>
</head>
<body>
    <h2>Relatório de Logs - {{ \Carbon\Carbon::now()->format('d/m/Y') }}</h2>

    <table>
        <thead>
            <tr>
                <th>Usuário</th>
                <th>Ação</th>
                <th>Detalhes</th>
                <th>Data</th>
            </tr>
        </thead>
        <tbody>
            @forelse($logs as $log)
                <tr>
                    <td>{{ $log->user->name ?? 'Desconhecido' }}</td>
                    <td>{{ $log->acao }}</td>
                    <td>{{ $log->descricao }}</td>
                    <td>{{ \Carbon\Carbon::parse($log->created_at)->format('d/m/Y H:i') }}</td>  
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align: center;">Nenhum log encontrado para a data selecionada.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
