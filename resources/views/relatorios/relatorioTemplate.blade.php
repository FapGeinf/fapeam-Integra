<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatório de Riscos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        h1, h2, h3, h4 {
            text-align: center;
        }
        .risco, .monitoramento, .resposta {
            margin: 10px 0; 
            padding: 15px;
        }
        .resposta {
            margin-top: 5px;
            padding-left: 10px;
          
        }
        span {
            display: inline;
        }
        @media print {
            .page-break {
                page-break-before: always; 
                page-break-after: always; 
            }
        }
    </style>
</head>
<body>
    <h1>Relatório de Riscos</h1>
    <p>Gerado em: {{ date('d/m/Y H:i:s') }}</p>

    @foreach ($riscosAgrupados as $unidadeId => $riscos)
        <div class="page-break"></div> <!-- Adiciona quebra de página antes da nova unidade -->
        <h2>Riscos Identificados - Unidade: {{ $riscos->first()->unidade->unidadeSigla }}</h2> <!-- Exibe o nome da unidade -->
        
        @foreach ($riscos as $index => $risco)
            <div class="risco">
                <h4>Risco #{{ $index + 1 }}</h4>
                <strong>Ano:</strong> <span>{!! $risco->riscoAno !!}</span><br>
                <strong>Responsável pelo Risco:</strong> <span>{{$risco->responsavelRisco}}</span><br>
                <strong>Risco:</strong> <span>{!! $risco->riscoEvento !!}</span><br>
                <strong>Causa:</strong> <span>{!! $risco->riscoCausa !!}</span><br>
                <strong>Consequência:</strong> <span>{!! $risco->riscoConsequencia !!}</span><br>
                <strong>Nível de Risco:</strong> <span>{!! $risco->nivel_de_risco !!}</span><br>
               
                @foreach ($risco->monitoramentos as $monitoramento)
                    <div class="monitoramento">
                        <h5>Monitoramento</h5>
                        <strong>Status:</strong> <span>{!! $monitoramento->statusMonitoramento !!}</span><br>
                        <strong>Início:</strong> <span>{{ \Carbon\Carbon::parse($monitoramento->inicioMonitoramento)->format('d/m/Y') }}</span><br>
                        <strong>Fim:</strong> <span>{{ \Carbon\Carbon::parse($monitoramento->fimMonitoramento)->format('d/m/Y') }}</span><br>
                        <strong>Anexo:</strong> <span>{!! $monitoramento->anexoMonitoramento ?? 'Nenhum' !!}</span><br>

                        <h6>Respostas</h6>
                        @if ($monitoramento->respostas->isEmpty())
                            <p>Não há respostas para este monitoramento.</p>
                        @else
                            @foreach ($monitoramento->respostas as $resposta)
                                <div class="resposta">
                                    <strong>Resposta:</strong> <span>{!! $resposta->respostaRisco !!}</span><br>
                                    <strong>Responsável:</strong> <span>{!! $resposta->user->name ?? 'Desconhecido' !!}</span><br>
                                </div>
                            @endforeach
                        @endif
                    </div>
                @endforeach
            </div>
        @endforeach
    @endforeach
</body>
</html>
