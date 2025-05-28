<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8" />
    <title>Relatório do Eixo</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            font-size: 13pt;
            margin: 30px 40px;
            color: #212529;
            line-height: 1.6;
            background-color: #ffffff;
        }

        h2 {
            text-align: center;
            font-size: 26px;
            margin-bottom: 30px;
            color: #2c3e50;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .atividade {
            background-color: #fafafa;
            padding: 25px 30px;
            margin-bottom: 30px;
            border: 1.5px solid #ced4da;
            border-radius: 8px;
            box-sizing: border-box;
            box-shadow: 0 2px 8px rgb(0 0 0 / 0.05);
            transition: box-shadow 0.3s ease;
        }

        .atividade:hover {
            box-shadow: 0 6px 15px rgb(0 0 0 / 0.1);
        }

        .atividade h3 {
            font-size: 20px;
            background-color: #34495e;
            color: #ecf0f1;
            padding: 14px 22px;
            margin-top: 0;
            margin-bottom: 22px;
            font-weight: 700;
            border-radius: 8px;
            letter-spacing: 0.03em;
            user-select: none;
        }

        .campo {
            margin-bottom: 16px;
            font-size: 15px;
            color: #495057;
            display: flex;
            flex-wrap: wrap;
        }

        .campo strong {
            width: 190px;
            font-weight: 700;
            color: #2c3e50;
            flex-shrink: 0;
        }

        .campo-texto {
            background: #fff;
            border: 1px solid #ced4da;
            border-radius: 6px;
            padding: 14px 18px;
            margin-top: 6px;
            margin-bottom: 20px;
            color: #2f3640;
            font-size: 14.5px;
            line-height: 1.5;
            white-space: pre-wrap; 
            box-shadow: inset 0 1px 3px rgb(0 0 0 / 0.1);
        }

        p {
            margin: 0;
            text-align: justify;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 24px;
            border: 1px solid #adb5bd;
            font-size: 15px;
            color: #495057;
        }

        table th,
        table td {
            padding: 12px 14px;
            border: 1px solid #adb5bd;
            text-align: left;
            vertical-align: middle;
        }

        table th {
            background-color: #e9ecef;
            font-weight: 700;
            color: #343a40;
            user-select: none;
        }

        table tr:nth-child(even) td {
            background-color: #f8f9fa;
        }

        @media (max-width: 768px) {
            body {
                margin: 20px 15px;
                font-size: 12pt;
            }

            h2 {
                font-size: 20px;
                margin-bottom: 24px;
            }

            .campo strong {
                width: 130px;
            }

            .atividade {
                padding: 18px 20px;
            }

            .atividade h3 {
                font-size: 18px;
                padding: 12px 15px;
            }
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
