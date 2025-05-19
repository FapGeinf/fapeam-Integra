<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8" />
    <title>Relatório do Eixo</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            font-size: 12pt;
            margin: 30px;
            color: #212529;
            line-height: 1.6;
            background-color: #ffffff;
        }

        h2 {
            text-align: center;
            font-size: 22px;
            margin-bottom: 25px;
            color: #333333;
            font-weight: bold;
        }

        .atividade {
            background-color: #f8f9fa;
            padding: 20px 25px;
            margin-bottom: 30px;
            border: 1px solid #adb5bd;
            border-radius: 6px;
            box-sizing: border-box;
            page-break-inside: avoid;
        }

        .atividade h3 {
            font-size: 18px;
            background-color: #6c757d;
            color: white;
            padding: 15px 20px;
            margin-top: 0;
            margin-bottom: 20px;
            font-weight: bold;
            border-radius: 6px;
        }

        .campo {
            margin-bottom: 18px;
            font-size: 14px;
            color: #495057;
        }

        .campo strong {
            display: inline-block;
            width: 180px;
            font-weight: 600;
            color: #212529;
            vertical-align: top;
        }

        /* Caixa para textos mais longos como objetivo e justificativa */
        .campo-texto {
            background: white;
            border: 1px solid #ced4da;
            border-radius: 5px;
            padding: 12px 15px;
            margin-top: 5px;
            margin-bottom: 18px;
            color: #343a40;
            font-size: 14px;
            line-height: 1.5;
        }

        p {
            margin: 0;
            /* já temos margem na caixa */
            text-align: justify;
        }

        @media (max-width: 768px) {
            body {
                margin: 15px;
                font-size: 11pt;
            }

            h2 {
                font-size: 18px;
            }

            .campo strong {
                width: 140px;
            }

            .atividade {
                padding: 15px 20px;
            }

            .atividade h3 {
                font-size: 16px;
                padding: 12px 15px;
            }
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            border: 1px solid #adb5bd;
            font-size: 14px;
            color: #495057;
        }

        table th,
        table td {
            padding: 10px 12px;
            border: 1px solid #adb5bd;
            text-align: left;
        }

        table th {
            background-color: #e9ecef;
            font-weight: 600;
            color: #343a40;
        }

        table tr:nth-child(even) td {
            background-color: #f8f9fa;
        }
    </style>
</head>

<body>
    <h2>Relatório de Atividades - Eixo: {{ $eixoNome }}</h2>

    @foreach($atividades as $index => $atividade)
        <div class="atividade">
            <h3>Atividade {{ $index + 1 }}</h3>
            <div class="campo-texto">
                {!! $atividade->atividade_descricao !!}
            </div>

            @if($atividade->objetivo)
                <div class="campo"><strong>Objetivo:</strong></div>
                <div class="campo-texto">
                    <p>{!! $atividade->objetivo !!}</p>
                </div>
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
                <div class="campo-texto">
                    <p>{!! $atividade->justificativa !!}</p>
                </div>
            @endif
        </div>
    @endforeach

</body>

</html>