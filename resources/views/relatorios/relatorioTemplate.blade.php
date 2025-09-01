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
            line-height: 1.5;
        }

        h1 {
            text-align: center;
            font-size: 28px;
            margin-bottom: 20px;
            color: #2c3e50;
            letter-spacing: 1px;
        }

        h2 {
            font-size: 20px;
            margin-top: 50px;
            margin-bottom: 20px;
            padding: 12px 20px;
            background-color: #e9eff5;
            border-left: 8px solid #34495e;
            color: #34495e;
            text-transform: uppercase;
            letter-spacing: 1.2px;
            border-radius: 4px;
        }

        .risco {
            border: 1px solid #cbd4df;
            border-radius: 8px;
            padding: 30px 25px;
            margin-bottom: 40px;
            background-color: #f9fbfd;
            box-shadow: 0 2px 6px rgb(0 0 0 / 0.05);
        }

        .risco-title {
            font-weight: 700;
            font-size: 18px;
            margin-bottom: 25px;
            border-bottom: 2px solid #cbd4df;
            padding-bottom: 10px;
            color: #1f2d3d;
            letter-spacing: 0.05em;
        }

        .linha {
            display: flex;
            flex-wrap: wrap;
            gap: 35px;
            margin-bottom: 30px;
        }

        .info {
            flex: 1;
            min-width: 240px;
            font-size: 15px;
            color: #4a4f55;
            padding: 12px 16px;
            border: 1px solid #dde4eb;
            border-radius: 6px;
            background-color: #ffffff;
            margin-bottom: 20px;
            box-sizing: border-box;
            transition: background-color 0.3s ease;
        }

        .info strong {
            width: 140px;
            display: inline-block;
            color: #2c3e50;
            font-weight: 600;
            flex-shrink: 0;
        }

        .info:hover {
            background-color: #f0f5fa;
        }

        .info-bloco {
            margin-bottom: 25px;
            font-size: 15px;
            line-height: 1.6;
            border-radius: 6px;
        }

        .nivel-baixo {
            color: #2a7f62;
            font-weight: 700;
        }

        .nivel-medio {
            color: #d4af37;
            font-weight: 700;
        }

        .nivel-alto {
            color: #a33e3e;
            font-weight: 700;
        }

        .nivel-risco {
            font-weight: 700;
            padding-left: 5px;
            border-left: 5px solid currentColor;
            margin-left: 10px;
            font-size: 15px;
        }

        .monitoramento {
            background-color: #e7eef7;
            padding: 20px 25px;
            margin-top: 30px;
            border-left: 6px solid #2f4366;
            border-radius: 8px;
            font-size: 15px;
            color: #2f4366;
            box-shadow: 0 1px 4px rgb(0 0 0 / 0.07);
        }

        .monitoramento h5 {
            margin: 0 0 15px 0;
            font-size: 17px;
            font-weight: 700;
            letter-spacing: 0.04em;
            color: #1b2a4d;
        }

        .footer {
            text-align: center;
            font-size: 12px;
            margin-top: 40px;
            color: #6c757d;
            letter-spacing: 0.03em;
        }

        @media (max-width: 700px) {
            .linha {
                flex-direction: column;
            }
            .info {
                min-width: 100%;
            }
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

                <div class="linha">
                    <div class="info"><strong>Ano:</strong> {{ $risco->riscoAno }}</div>
                    <div class="info"><strong>Responsável:</strong> {{ $risco->responsavelRisco }}</div>
                    <div class="info">
                        <strong>Nível de Risco:</strong>
                        @php
                            $nivelTexto = ['Baixo', 'Médio', 'Alto'];
                            $nivelClasses = ['nivel-baixo', 'nivel-medio', 'nivel-alto'];
                            $nivelIndex = max(0, min(2, (int) $risco->nivel_de_risco - 1));
                        @endphp
                        <span class="nivel-risco {{ $nivelClasses[$nivelIndex] }}">
                            {{ $nivelTexto[$nivelIndex] }}
                        </span>
                    </div>
                </div>

                <div class="info-bloco info"><strong>Risco:</strong> {!! $risco->riscoEvento !!}</div>
                <div class="info-bloco info"><strong>Causa:</strong> {!! $risco->riscoCausa !!}</div>
                <div class="info-bloco info"><strong>Consequência:</strong> {!! $risco->riscoConsequencia !!}</div>

                @foreach ($risco->monitoramentos as $mIndex => $monitoramento)
                    <div class="monitoramento">
                        <h5>Monitoramento #{{ $mIndex + 1 }}</h5>
                        <div class="linha">
                            <div class="info"><strong>Status:</strong> {{ $monitoramento->statusMonitoramento }}</div>
                            <div class="info"><strong>Início:</strong>
                                {{ \Carbon\Carbon::parse($monitoramento->inicioMonitoramento)->format('d/m/Y') }}
                            </div>
                            <div class="info"><strong>Fim:</strong>
                                {{ \Carbon\Carbon::parse($monitoramento->fimMonitoramento)->format('d/m/Y') }}
                            </div>
                        </div>
                        <div class="info-bloco info"><strong>Controle Sugerido:</strong> {!! $monitoramento->monitoramentoControleSugerido !!}</div>
                    </div>
                @endforeach
            </div>
        @endforeach
    @endforeach

</body>

</html>
