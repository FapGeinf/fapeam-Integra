<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Relatório do Eixo</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
            margin: 30px;
            color: #333;
            line-height: 1.5;
        }

        h2 {
            text-align: center;
            font-size: 18px;
            margin-bottom: 20px;
            color: #2a2a2a;
            font-weight: bold;
        }

        .atividade {
            border: 1px solid #ccc;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 25px;
            background-color: #fafafa;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }

        .atividade h3 {
            background-color: #e9ecef;
            padding: 10px;
            font-size: 14px;
            border-radius: 6px;
            margin-top: 0;
            color: #007bff;
            font-weight: bold;
        }

        .campo {
            margin-bottom: 12px;
            font-size: 12px;
        }

        .campo strong {
            display: inline-block;
            width: 160px;
            font-weight: bold;
            color: #495057;
        }

        p {
            margin-top: 5px;
            margin-bottom: 10px;
            text-align: justify;
            font-size: 12px;
            color: #555;
        }

        .campo p {
            margin: 0;
        }

        .atividade .campo {
            margin-bottom: 12px;
        }

        .campo span {
            font-weight: normal;
            color: #555;
        }

        .campo:last-child {
            margin-bottom: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table th,
        table td {
            padding: 8px;
            border: 1px solid #ccc;
            text-align: left;
        }

        table th {
            background-color: #f7f7f7;
            font-weight: bold;
        }

        @media (max-width: 768px) {
            body {
                margin: 10px;
                font-size: 10px;
            }

            h2 {
                font-size: 16px;
            }

            .campo strong {
                width: 140px;
            }

            .atividade {
                padding: 15px;
            }

            .atividade h3 {
                font-size: 13px;
                padding: 8px;
            }
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
