<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8" />
    <title>Relatório de Logs</title>
    <style>
        body {
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            font-size: 15px;
            margin: 30px;
            color: #2c3e50;
            background-color: #ffffff;
            line-height: 1.6;
        }

        h2 {
            text-align: center;
            margin-bottom: 25px;
            color: #34495e;
            font-weight: 700;
            font-size: 24px;
            letter-spacing: 0.05em;
        }

        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 8px;
            margin-top: 10px;
            box-shadow: 0 2px 8px rgb(0 0 0 / 0.05);
        }

        thead tr {
            background-color: #34495e;
            color: #fff;
            text-align: left;
            font-weight: 600;
            letter-spacing: 0.05em;
        }

        th, td {
            padding: 14px 20px;
            border: none;
        }

        tbody tr {
            background-color: #f9fbfd;
            transition: background-color 0.3s ease;
            border-radius: 6px;
        }

        tbody tr:hover {
            background-color: #e1e9f5;
        }

        tbody tr + tr {
            margin-top: 8px;
        }

        tbody tr td:first-child {
            border-top-left-radius: 6px;
            border-bottom-left-radius: 6px;
        }

        tbody tr td:last-child {
            border-top-right-radius: 6px;
            border-bottom-right-radius: 6px;
        }

        tbody tr.empty-row td {
            text-align: center;
            color: #7f8c8d;
            font-style: italic;
            padding: 30px 0;
            background-color: transparent;
            border-radius: 0;
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
                <tr class="empty-row">
                    <td colspan="4">Nenhum log encontrado para a data selecionada.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>

</html>
