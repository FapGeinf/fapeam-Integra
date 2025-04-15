<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Relatório do Eixo</title>
    <style>
        /* Fonte e estilo global */
        body {
            font-family: 'Arial', sans-serif;
            font-size: 14px;
            margin: 40px;
            color: #333;
            line-height: 1.6;
            background-color: #ffffff; /* Alterado para fundo branco */
        }

        h2 {
            text-align: center;
            font-size: 22px;
            margin-bottom: 30px;
            color: #2c3e50;
            font-weight: bold;
        }

        /* Estilo do bloco de atividades */
        .atividade {
            background-color: #ffffff; /* Fundo branco simples */
            padding: 20px;
            margin-bottom: 30px;
            border: 1px solid #ddd;
            box-sizing: border-box;
        }

        /* Título da atividade */
        .atividade h3 {
            font-size: 16px;
            background-color: #2980b9;
            color: white;
            padding: 12px;
            margin-top: 0;
            font-weight: bold;
        }

        /* Estilo dos campos */
        .campo {
            margin-bottom: 16px;
            font-size: 14px;
            color: #555;
        }

        .campo strong {
            display: inline-block;
            width: 180px;
            font-weight: bold;
            color: #333;
        }

        .campo span {
            color: #2980b9;
            font-weight: bold;
        }

        p {
            margin-top: 5px;
            margin-bottom: 12px;
            text-align: justify;
            color: #666;
        }

        /* Responsividade para dispositivos menores */
        @media (max-width: 768px) {
            body {
                margin: 20px;
                font-size: 12px;
            }

            h2 {
                font-size: 20px;
            }

            .campo strong {
                width: 150px;
            }

            .atividade {
                padding: 15px;
            }

            .atividade h3 {
                font-size: 14px;
                padding: 10px;
            }
        }

        /* Estilo para tabelas ou outros elementos */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table th,
        table td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: left;
            color: #555;
        }

        table th {
            background-color: #f9fafb;
            font-weight: bold;
        }

        table td {
            background-color: #ffffff;
        }

        table tr:nth-child(even) td {
            background-color: #f9f9f9;
        }
    </style>
</head>

<body>
    <h2>Relatório de Atividades - Eixo: {{ $eixoNome }}</h2>

    @foreach($atividades as $index => $atividade)
        <div class="atividade">
            <h3>Atividade {{ $index + 1 }} {!! $atividade->atividade_descricao !!}</h3>

            @if($atividade->objetivo)
                <div class="campo"><strong>Objetivo:</strong></div>
                <p>{!! $atividade->objetivo !!}</p>
            @endif

            <div class="campo"><strong>Público:</strong> {{ $atividade->publico->nome }}</div>

            <div class="campo">
                <strong>Tipo de Evento:</strong>
                @if($atividade->tipo_evento == 1)
                    Presencial
                @elseif($atividade->tipo_evento == 2)
                    Online
                @elseif($atividade->tipo_evento == 3)
                    Presencial e Online
                @elseif($atividade->tipo_evento == 0 || $atividade->tipo_evento === null)
                    Sem evento
                @endif
            </div>

            <div class="campo"><strong>Canal:</strong> {{ $atividade->canais->pluck('nome')->implode(', ') ?: '-' }}</div>
            <div class="campo"><strong>Data Prevista:</strong>
                {{ \Carbon\Carbon::parse($atividade->data_prevista)->format('d/m/Y') }}</div>
            <div class="campo"><strong>Data Realizada:</strong>
                {{ $atividade->data_realizada ? \Carbon\Carbon::parse($atividade->data_realizada)->format('d/m/Y') : '-' }}
            </div>
            <div class="campo"><strong>Meta:</strong> {{ $atividade->meta }}</div>
            <div class="campo"><strong>Realizado:</strong> {{ $atividade->realizado }}</div>
            <div class="campo"><strong>Medida:</strong> {{ $atividade->medida->nome }}</div>
            <div class="campo"><strong>Responsável:</strong> {{ $atividade->responsavel }}</div>

            @if($atividade->justificativa)
                <div class="campo"><strong>Justificativa:</strong></div>
                <p>{!! $atividade->justificativa !!}</p>
            @endif
        </div>
    @endforeach
</body>

</html>
