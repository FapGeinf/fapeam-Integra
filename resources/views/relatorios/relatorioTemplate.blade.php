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
            color: #2c3e50;
        }

        h2 {
            font-size: 18px;
            margin-top: 40px;
            margin-bottom: 15px;
            padding: 10px;
            background-color: #f4f6f8;
            border-left: 6px solid #34495e;
            color: #34495e;
        }

        .risco {
            border: 1px solid #d1d9e6;
            border-radius: 5px;
            padding: 25px 20px;
            margin-bottom: 30px;
            background-color: #fafbfc;
        }

        .risco-title {
            font-weight: 600;
            font-size: 16px;
            margin-bottom: 20px;
            border-bottom: 1px solid #d1d9e6;
            padding-bottom: 8px;
            color: #2c3e50;
        }

        .info {
            margin-bottom: 15px;
            font-size: 14px;
            color: #4a4f55;
            padding: 10px 12px;
            border: 1px solid #e1e6eb;
            border-radius: 4px;
            background-color: #ffffff;
            display: flex;
            align-items: center;
        }

        .info strong {
            width: 160px;
            display: inline-block;
            color: #2c3e50;
            flex-shrink: 0;
        }

        .nivel-baixo {
            color: #2a7f62;
            font-weight: 600;
        }

        .nivel-medio {
            color: #d4af37;
            font-weight: 600;
        }

        .nivel-alto {
            color: #a33e3e;
            font-weight: 600;
        }

        .nivel-risco .bola {
            display: inline-block;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            margin-right: 8px;
            vertical-align: middle;
            background-color: #212529; /* bolinha preta */
        }

        .monitoramento {
            background-color: #f4f6f8;
            padding: 15px 20px;
            margin-top: 20px;
            border-left: 4px solid #34495e;
            border-radius: 6px;
            font-size: 14px;
            color: #34495e;
        }

        .monitoramento h5 {
            margin: 0 0 10px;
            font-size: 15px;
            color: #34495e;
            font-weight: 600;
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
            <div class="risco">
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
                        {{ $nivelTexto[$nivelIndex] }}
                    </span>
                </div>

                @foreach ($risco->monitoramentos as $mIndex => $monitoramento)
                    <div class="monitoramento">
                        <h5>Monitoramento #{{ $mIndex + 1 }}</h5>
                        <div class="info"><strong>Status:</strong> {{ $monitoramento->statusMonitoramento }}</div>
                        <div class="info"><strong>Controle Sugerido:</strong> {!! $monitoramento->monitoramentoControleSugerido !!}</div>
                        <div class="info"><strong>Início:</strong>
                            {{ \Carbon\Carbon::parse($monitoramento->inicioMonitoramento)->format('d/m/Y') }}</div>
                        <div class="info"><strong>Fim:</strong>
                            {{ \Carbon\Carbon::parse($monitoramento->fimMonitoramento)->format('d/m/Y') }}</div>
                    </div>
                @endforeach
            </div>
        @endforeach
    @endforeach

</body>

</html>
