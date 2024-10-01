@extends('layouts.app')
@section('title')
    {{ 'Não Implementadas' }}
@endsection


@section('content')

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.2.3/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.js"></script>
</head>

<body>

    <div class="container-fluid p-30 paddingLeft">

        <div class="col-12 border main-datatable">
            <div class="container-fluid">
                <table id="tableHome" class="table cust-datatable">
                    <thead>
                        <tr>
                            <th style="white-space: nowrap; width: 100px;">Unidade</th>
                            <th>Controle Sugerido</th>
                            <th style="white-space: nowrap;">Data</th>
                            <th style="white-space: nowrap;">Situação</th>
                            <th style="white-space: nowrap;">Anexo</th>
                            <th style="white-space: nowrap;">Opções</th>
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
                                        <div class="ms-2 d-flex flex-column align-items-center">
                                            <a href="{{ route('riscos.show', $risco->id) }}" class="btn btn-warning mb-2">Mostrar Risco</a>
                                            <a href="{{ route('riscos.respostas', ['id' => $monitoramento->id]) }}" class="primary" style="font-size: 13px; white-space: nowrap;">
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
    </div>

    <footer class="rodape">
        <div class="riskLevelDiv">
            <span>Nível de Risco (Avaliação):</span>
            <span class="mode riskLevel1">Baixo</span>
            <span class="mode riskLevel2">Médio</span>
            <span class="mode riskLevel3">Alto</span>
        </div>
    </footer>

    <script>
        $(document).ready(function() {
            var table = $('#tableHome').DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/pt-BR.json',
                    search: "Procurar:",
                    lengthMenu: "Riscos: _MENU_",
                    info: 'Mostrando página _PAGE_ de _PAGES_',
                    infoEmpty: 'Sem relatórios de risco disponíveis no momento',
                    infoFiltered: '(Filtrados do total de _MAX_ relatórios)',
                    zeroRecords: 'Nada encontrado. Se achar que isso é um erro, contate o suporte.',
                    paginate: {
                        next: "Próximo",
                        previous: "Anterior"
                    }
                },
                initComplete: function() {
                    // CONTAINER QUE ALINHA TODOS NA MESMA LINHA
                    var divContainer = $('<div class="divContainer"></div>');
    
                    if (!$('#filterUnidade').length) {
                        var selectUnidade = $('<select id="filterUnidade" class="form-select form-select-sm divFilterUnidade"><option value="">Todas as Unidades</option></select>');
                        @foreach ($riscos->unique('unidade.unidadeNome') as $risco)
                            selectUnidade.append('<option value="{{ $risco->unidade->unidadeNome }}">{{ $risco->unidade->unidadeNome }}</option>');
                        @endforeach
    
                        var labelUnidades = $('<label for="filterUnidade" class="labelUnidade">Unidades:</label>');
                        $('.dataTables_length').append(labelUnidades).append(selectUnidade);
                    }
    
                    divContainer.append($('.dataTables_filter'));
                    divContainer.append($('.dataTables_length'));
                    $(table.table().container()).prepend(divContainer);
    
                    $('#filterUnidade').on('change', function() {
                        var val = $.fn.dataTable.util.escapeRegex($(this).val());
                        table.column(0).search(val ? '^' + val + '$' : '', true, false).draw();
                    });
                }
            });
    
            table.on('draw', function() {
                if (!$(".divContainer").length) {
                    var divContainer = $('<div class="divContainer"></div>');
    
                    if (!$('#filterUnidade').length) {
                        var selectUnidade = $('<select id="filterUnidade" class="form-select form-select-sm divFilterUnidade"><option value="">TODAS</option></select>');
                        @foreach ($riscos->unique('unidade.unidadeNome') as $risco)
                            selectUnidade.append('<option value="{{ $risco->unidade->unidadeSigla }}">{{ $risco->unidade->unidadeSigla }}</option>');
                        @endforeach
    
                        var labelUnidades = $('<label for="filterUnidade" class="labelUnidade">Unidades:</label>');
                        $('.dataTables_length').append(labelUnidades).append(selectUnidade);
                    }
    
                    divContainer.append($('.dataTables_length'));
                    divContainer.append($('.dataTables_filter'));
    
                    $(table.table().container()).prepend(divContainer);
    
                    $('#filterUnidade').on('change', function() {
                        var val = $.fn.dataTable.util.escapeRegex($(this).val());
                        table.column(0).search(val ? '^' + val + '$' : '', true, false).draw();
                    });
                }
            });
        });
    </script>
</body>

</html>
@endsection
