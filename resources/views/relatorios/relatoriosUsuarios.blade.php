<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Relatório de Usuários</title>
    <style>
        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 8px;
            margin-top: 10px;
            /* box-shadow: 0 2px 8px rgb(0 0 0 / 0.05); Removido para PDF */
            table-layout: fixed;
        }

        thead th {
            color: #fff;
            background-color: #34495e;
            font-weight: 600;
            letter-spacing: 0.05em;
            text-align: left;
        }

        thead th:nth-child(1),
        tbody td:nth-child(1) {
            width: 25%;
        }

        thead th:nth-child(2),
        tbody td:nth-child(2) {
            width: 30%;
        }

        thead th:nth-child(3),
        tbody td:nth-child(3) {
            width: 25%;
        }

        thead th:nth-child(4),
        tbody td:nth-child(4) {
            width: 25%;
        }

        thead th:nth-child(5),
        tbody td:nth-child(5) {
            width: 30%;
        }

        th,
        td {
            padding: 14px 20px;
            border: none;
            word-wrap: break-word;
            overflow-wrap: break-word;
        }

        tbody tr {
            background-color: #f9fbfd;
            border-radius: 6px;
            transition: background-color 0.3s ease;
        }

        tbody tr:hover {
            background-color: #e1e9f5;
        }

        tbody tr+tr {
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
    </style>
</head>

<body>

    <header>
        <h2>Relatório de Usuários</h2>
        <p>Gerado em {{ \Carbon\Carbon::now()->format('d/m/Y H:i') }}</p>
    </header>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>E-mail</th>
                    <th>CPF</th>
                    <th>Unidade</th>
                    <th>Diretoria</th>
                </tr>
            </thead>
            <tbody>
                @forelse($usuarios as $usuario)
                    <tr>
                        <td>{{ $usuario->name }}</td>
                        <td>{{ $usuario->email }}</td>
                        <td>{{ $usuario->cpf }}</td>
                        <td>{{ $usuario->unidade->unidadeSigla ?? '—' }}</td>
                        <td>{{ $usuario->unidade->diretoria->diretoriaSigla ?? '—' }}</td>
                    </tr>
                @empty
                    <tr class="empty-row">
                        <td colspan="5">Nenhum usuário encontrado.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <footer>
        Relatório gerado automaticamente pelo sistema em {{ \Carbon\Carbon::now()->format('d/m/Y H:i') }}
    </footer>

</body>

</html>
