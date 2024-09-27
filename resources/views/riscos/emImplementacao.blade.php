@extends('layouts.app')

@section('title', 'Detalhes do Risco')

@section('content')
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Riscos</title>
    <link rel="stylesheet" href="{{ asset('css/show.css') }}">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <script src="/ckeditor/ckeditor.js"></script>
    @if (session('error'))
        <script>
            alert('{{ session('error') }}');
        </script>
    @endif

    <div class="container-fluid p-30 paddingLeft">
        <div class="col-12 box-shadow">
            <h5 class="text-center mb-2">Monitoramentos Em Implementação</h5>

            <table class="table table-bordered mb-4">
                <thead>
                    <tr>
                        <th scope="col" class="text-center text-light">Unidade:</th>
                        <th scope="col" class="text-center text-light tBorder">Controle Sugerido:</th>
                        <th scope="col" class="text-center text-light">Data:</th>
                        <th scope="col" class="text-center text-light tBorder">Situação:</th>
                        <th scope="col" class="text-center text-light">Anexo:</th>
                        <th scope="col" class="text-center text-light">Opções:</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($riscosDaUnidade as $risco)
                        @foreach ($risco->monitoramentos as $monitoramento)
                            <tr>
                                <td class="text-center text13 pb-1 tBorder">
                                    {!! $risco->unidade->unidadeSigla !!}
                                </td>
                                <td class="text13 pb-1 tBorder">{!! $monitoramento->monitoramentoControleSugerido !!}</td>
                                <td class="text-center text-13 pb-1" style="white-space: nowrap;">
                                    {{ \Carbon\Carbon::parse($monitoramento->inicioMonitoramento)->format('d/m/Y') }} -
                                    {{ $monitoramento->fimMonitoramento ? \Carbon\Carbon::parse($monitoramento->fimMonitoramento)->format('d/m/Y') : 'Contínuo' }}
                                </td>
                                <td class="text-center text13 pb-1 tBorder">{!! $monitoramento->statusMonitoramento !!}</td>
                                <td class="text-center text13 pb-1 tBorder">
                                    @if ($monitoramento->anexoMonitoramento)
                                        <a href="{{ Storage::url($monitoramento->anexoMonitoramento) }}" target="_blank"
                                            class="btn btn-outline-primary btn-sm" title="Visualizar Anexo">
                                            @if (strpos($monitoramento->anexoMonitoramento, '.pdf') !== false)
                                                <i class="bi bi-file-earmark-pdf"></i>
                                            @else
                                                <i class="bi bi-file-earmark-image"></i>
                                            @endif
                                            {{ basename($monitoramento->anexoMonitoramento) }}
                                        </a>
                                    @else
                                        <div class="center">
                                            <i class="bi bi-file-earmark-excel"></i>
                                            Nenhum anexo disponível
                                        </div>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="ms-2 d-flex flex-column align-items-center">
                                        <a href="{{ route('riscos.show', $risco->id) }}" class="btn btn-warning mb-2">Mostrar Risco</a>
                                        <a href="{{ route('riscos.respostas', ['id' => $monitoramento->id]) }}"
                                            class="primary" style="font-size: 13px; white-space: nowrap;">
                                            Visualizar Providências
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <footer class="rodape">
        <div class="riskLevelDiv">
            <span>Nível de Risco (Avaliação):</span>
            <span class="mode riskLevel1">Baixo</span>
            <span class="mode riskLevel2">Médio</span>
            <span class="mode riskLevel3">Alto</span>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
@endsection
