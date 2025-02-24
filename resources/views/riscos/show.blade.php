@extends('layouts.app')
@section('content')

@section('title')
    {{ 'Detalhes do Risco' }}
@endsection

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Riscos</title>
    <link rel="stylesheet" href="{{ asset('css/show.css') }}">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <style>
        .liDP {
            margin-left: 0 !important;
        }
    </style>
    <script src="/ckeditor/ckeditor.js"></script>
</head>

<body>
    @if (session('error'))
        <script>
            alert('{{ session('error') }}');
        </script>
    @endif

    <div class="container-fluid p-30 mt-5">
        <div class="col-12 border box-shadow">
            <h5 class="text-center mb-2">Detalhamento do Risco Inerente</h5>

            <div>
                <table class="table table-bordered mb-4">
                    <thead>
                        <tr>
                            <th scope="col" style="white-space: nowrap; width: 100px;" class="text-center text-light tBorder">N° Risco</th>
                            <th scope="col" class="text-center text-light tBorder">Evento:</th>
                            <th scope="col" class="text-center text-light tBorder">Causa:</th>
                            <th scope="col" class="text-center text-light tBorder">Consequência:</th>
                            <th scope="col" style="width: 100px;" class="text-center text-light">Avaliação:</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="text13">
                            <td class="text-center pb-1 tBorder">{!! $risco->id !!}</td>
                            <td class="pb-1 tBorder">{!! $risco->riscoEvento !!}</td>
                            <td class="pb-1 tBorder">{!! $risco->riscoCausa !!}</td>
                            <td class="pb-1 tBorder">{!! $risco->riscoConsequencia !!}</td>
                            @if ($risco->nivel_de_risco == 1)
                                <td class="bg-baixo riscoAvaliacao"><span class="fontBold">Baixo</span></td>
                            @elseif ($risco->nivel_de_risco == 2)
                                <td class="bg-medio riscoAvaliacao"><span class="fontBold">Médio</span></td>
                            @else
                                <td class="bg-alto riscoAvaliacao"><span class="fontBold">Alto</span></td>
                            @endif
                        </tr>
                    </tbody>
                </table>

                <h5 class="text-center mb-2">Plano de ação</h5>
                <table class="table table-bordered mb-4">
                    <thead>
                        <tr>
                            <th scope="col" class="text-center text-light tBorder">Controle Sugerido:</th>
                            <th scope="col" class="text-center text-light">Data:</th>
                            <th scope="col" class="text-center text-light tBorder">Situação:</th>
                            <th scope="col" class="text-center text-light">Anexo:</th>
                            <th scope="col" class="text-center text-light">Opções:</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($risco->monitoramentos as $monitoramento)
                            <tr>
                                <td class="text13 pb-1 tBorder">{!! $monitoramento->monitoramentoControleSugerido !!}</td>
                                <td style="white-space: nowrap;" class="text-center text-13 pb-1">
                                    {{ \Carbon\Carbon::parse($monitoramento->inicioMonitoramento)->format('d/m/Y') }} -
                                    {{ $monitoramento->fimMonitoramento ? \Carbon\Carbon::parse($monitoramento->fimMonitoramento)->format('d/m/Y') : 'Contínuo' }}
                                </td>
                                <td style="white-space: nowrap;" class="text-center text13 pb-1 tBorder">
                                    {!! $monitoramento->statusMonitoramento !!}</td>
                                <td class="text-center text13 pb-1 tBorder">
                                    @if ($monitoramento->anexoMonitoramento)
                                        <a href="{{ Storage::url($monitoramento->anexoMonitoramento) }}" target="_blank" class="btn btn-outline-primary btn-sm" title="Visualizar Anexo">
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
                                    <div class="ms-2" style="display: flex; flex-direction: column; align-items: center;">
																			{{-- -ESSE IF DEVE SER == 1 APENAS --}}
                                        @if (auth()->user()->unidade->unidadeTipo->id != 10)
                                            <a href="{{ route('riscos.editMonitoramento', ['id' => $monitoramento->id]) }}" class="warning mb-2" style="font-size: 13px; white-space: nowrap;">
                                                Editar Controle Sugerido
                                            </a>
                                        @endif
                                            <a href="{{ route('riscos.respostas', ['id' => $monitoramento->id]) }}" class="primary" style="font-size: 13px; white-space: nowrap;">
                                             Visualizar Providências
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="text-center mb-4">
                    @if (Auth::user()->unidade->unidadeTipoFK == 1)
                        <a href="{{ route('riscos.edit', $risco->id) }}" class="warning">Editar Risco</a>
                        <a href="{{ route('riscos.edit-monitoramentos', ['id' => $risco->id]) }}" class="primary">Adicionar Controles Sugeridos</a>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- <footer class="rodape">
        <div class="riskLevelDiv">
            <span>Nível de Risco (Avaliação):</span>
            <span class="mode riskLevel1">Baixo</span>
            <span class="mode riskLevel2">Médio</span>
            <span class="mode riskLevel3">Alto</span>
        </div>
    </footer> -->

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script> -->

</body>

</html>
@endsection
