<<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Relatório do Eixo</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            font-size: 12pt; 
            margin: 3cm; 
            color: #333;
            line-height: 1.6;
            background-color: #ffffff;
        }

        h2 {
            text-align: center;
            font-size: 16pt;
            margin-bottom: 40px;
            color: #2c3e50;
            font-weight: bold;
        }

        .atividade {
            background-color: #ffffff;
            padding: 20px;
            margin-bottom: 30px;
            border: 1px solid #ddd;
            box-sizing: border-box;
            border-radius: 5px; 
        }

        .atividade h3 {
            font-size: 14pt; 
            background-color: #2980b9;
            color: white;
            padding: 15px;
            margin-top: 0;
            font-weight: bold;
            border-radius: 5px;
        }

        .campo {
            margin-bottom: 18px;
            font-size: 12pt;
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
            font-size: 12pt;
        }

        @media (max-width: 768px) {
            body {
                margin: 20px;
                font-size: 11pt;
            }

            h2 {
                font-size: 14pt;
            }

            .campo strong {
                width: 140px;
            }

            .atividade {
                padding: 15px;
            }

            .atividade h3 {
                font-size: 12pt;
                padding: 12px;
            }
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            border: 1px solid #ddd;
        }

        table th, table td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
            color: #555;
            font-size: 12pt;
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

        table th, table td {
            border-width: 0.5px;
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
