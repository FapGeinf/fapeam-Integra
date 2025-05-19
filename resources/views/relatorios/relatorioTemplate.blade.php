<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Relatório de Riscos</title>
    <style>
        body {
            font-family: "Arial", sans-serif;
            margin: 30px;
            background-color: #ffffff;
            color: #212529;
        }

        h1 {
            text-align: center;
            font-size: 26px;
            margin-bottom: 10px;
            color: #333333;
        }

        h2 {
            font-size: 18px;
            margin-top: 40px;
            margin-bottom: 15px;
            padding: 10px;
            background-color: #e9ecef;
            border-left: 6px solid #6c757d;
            color: #495057;
        }

        .risco {
            border: 1px solid #adb5bd;
            border-radius: 5px;
            padding: 25px 20px;
            margin-bottom: 30px;
            background-color: #f8f9fa;

            /* Evita quebra de página dentro do risco */
            page-break-inside: avoid;
            page-break-after: avoid;
        }

        .page-break {
            page-break-before: always;
        }

        .risco-title {
            font-weight: bold;
            font-size: 16px;
            margin-bottom: 20px;
            border-bottom: 1px solid #ced4da;
            padding-bottom: 8px;
            color: #343a40;
        }

        .info {
            margin-bottom: 15px;
            font-size: 14px;
            color: #495057;
            padding: 10px 12px;
            border: 1px solid #dee2e6;
            border-radius: 4px;
            background-color: #ffffff;
            display: flex;
            align-items: center;
        }

        .info strong {
            width: 160px;
            display: inline-block;
            color: #212529;
            flex-shrink: 0;
        }

        .nivel-baixo {
            color: #198754;
            font-weight: bold;
        }

        .nivel-medio {
            color: #fd7e14;
            font-weight: bold;
        }

        .nivel-alto {
            color: #dc3545;
            font-weight: bold;
        }

        .monitoramento {
            background-color: #e9ecef;
            padding: 15px 20px;
            margin-top: 20px;
            border-left: 4px solid #6c757d;
            border-radius: 6px;
        }

        .monitoramento h5 {
            margin: 0 0 10px;
            font-size: 15px;
            color: #6c757d;
        }

        .footer {
            text-align: center;
            font-size: 11px;
            margin-top: 15px;
            color: #6c757d;
        }
    </style>
</head>

<body>

    <h1>Relatório de Riscos</h1>
    <p class="footer">Gerado em: {{ date('d/m/Y H:i:s') }}</p>

    @foreach ($riscosAgrupados as $unidadeId => $riscos)
        <h2>Unidade: {{ $riscos->first()->unidade->unidadeSigla }}</h2>

        @foreach ($riscos as $index => $risco)
            <div class="risco @if($index > 0) page-break @endif">
                <div class="risco-title">Risco #{{ $index + 1 }}</div>

                <div class="info"><strong>Ano:</strong> {{ $risco->riscoAno }}</div>
                <div class="info"><strong>Responsável:</strong> {{ $risco->responsavelRisco }}</div>
                <div class="info"><strong>Risco:</strong> {!! $risco->riscoEvento !!}</div>
                <div class="info"><strong>Causa:</strong> {!! $risco->riscoCausa !!}</div>
                <div class="info"><strong>Consequência:</strong> {!! $risco->riscoConsequencia !!}</div>
                <div class="info"><strong>Nível de Risco:</strong>
                    @php
                        $nivelTexto = ['Baixo', 'Médio', 'Alto'];
                        $nivelClasses = ['nivel-baixo', 'nivel-medio', 'nivel-alto'];
                        $nivelIndex = max(0, min(2, (int) $risco->nivel_de_risco - 1));
                    @endphp
                    <span class="nivel-risco {{ $nivelClasses[$nivelIndex] }}">
                        <span class="bola"></span> {{ $nivelTexto[$nivelIndex] }}
                    </span>
                </div>

                @foreach ($risco->monitoramentos as $monitoramento)
                    <div class="monitoramento">
                        <h5>Monitoramento</h5>
                        <div class="info"><strong>Status:</strong> {{ $monitoramento->statusMonitoramento }}</div>
                        <div class="info"><strong>Controle Sugerido:</strong> {!! $monitoramento->monitoramentoControleSugerido !!}</div>
                        <div class="info"><strong>Início:</strong> {{ \Carbon\Carbon::parse($monitoramento->inicioMonitoramento)->format('d/m/Y') }}</div>
                        <div class="info"><strong>Fim:</strong> {{ \Carbon\Carbon::parse($monitoramento->fimMonitoramento)->format('d/m/Y') }}</div>
                    </div>
                @endforeach
            </div>
        @endforeach
    @endforeach

</body>

</html>
