@extends('layouts.app')
@section('title')
    {{ 'Monitoramentos Implementados' }}
@endsection


@section('content')

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monitoramentos Implementados</title>
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
    <link rel="stylesheet" href="{{ asset('css/filterImplement.css') }}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.2.3/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.js"></script>
</head>

<body>

    <div class="container-fluid p-30">

        <div class="col-12 border main-datatable">
            <div class="container-fluid">
                <table id="tableHome2" class="table cust-datatable">
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
                        @foreach ($monitoramentosDaUnidade as $monitoramento)
                            <tr>
                                <td class="text-center text13 pb-1 tBorder">
                                    {!! $monitoramento->risco->unidade->unidadeSigla !!}
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
                                        <a href="{{ route('riscos.show', $monitoramento->risco->id) }}" class="btn btn-warning mb-2">Mostrar Risco</a>
                                        <a href="{{ route('riscos.respostas', ['id' => $monitoramento->id]) }}" class="primary" style="font-size: 13px; white-space: nowrap;">
                                            Visualizar Providências
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
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

    <script>
        $(document).ready(function() {
            var table = $('#tableHome2').DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/pt-BR.json',
                    search: "Procurar:",
                    lengthMenu: "Monitoramentos: _MENU_",
                    info: 'Mostrando página _PAGE_ de _PAGES_',
                    infoEmpty: 'Sem monitoramentos disponíveis no momento',
                    infoFiltered: '(Filtrados do total de _MAX_ monitoramentos)',
                    zeroRecords: 'Nada encontrado. Se achar que isso é um erro, contate o suporte.',
                    paginate: {
                        next: "Próximo",
                        previous: "Anterior"
                    }
                },
                initComplete: function() {
                    // Cria o dropdown container para os filtros
                    var dropdownContainer = $(`
                        <div class="dropdown d-none mb-2">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownFilters" data-bs-toggle="dropdown" aria-expanded="false">
                                Filtros
                            </button>
                            <div class="dropdown-menu p-3" aria-labelledby="dropdownFilters">
                                <div id="filtersContent"></div>
                            </div>
                        </div>
                    `);
            
                    // Verifica e cria o filtro de unidades
                    if (!$('#filterUnidade').length) {
                        var selectUnidade = $('<select style="background-color: #f1f1f1; cursor: pointer;" id="filterUnidade" class="form-select form-select-sm mb-2"><option value="">TODAS</option></select>');
                        @foreach ($monitoramentosDaUnidade->unique('risco.unidade.unidadeNome') as $monitoramento)
                            selectUnidade.append('<option value="{{ $monitoramento->risco->unidade->unidadeSigla }}">{{ $monitoramento->risco->unidade->unidadeSigla }}</option>');
                        @endforeach
            
                        var labelUnidades = $('<label for="filterUnidade" class="form-label">Unidades:</label>');
                        $('#filtersContent').append(labelUnidades).append(selectUnidade);
                    }
            
                    // Mover a parte de paginação para dentro do dropdown
                    $('#filtersContent').append($('.dataTables_length'));
            
                    // Adiciona o dropdown dentro da div com id "tableHome2_filter"
                    $('#tableHome2_filter').prepend(dropdownContainer);
            
                    // Evento de filtro de unidade (agora filtrando pela sigla)
                    $('#filterUnidade').on('change', function() {
                        var val = $.fn.dataTable.util.escapeRegex($(this).val());
                        table.column(0)  // Coluna 0 é onde você deve ter a sigla da unidade
                            .search(val ? '^' + val + '$' : '', true, false)  // A pesquisa é feita pela sigla exata
                            .draw();
                    });
                }
            });
        
            table.on('draw', function() {
                // Garante que os filtros sejam movidos para o dropdown após a atualização da tabela
                if (!$("#dropdownFilters").length) {
                    var dropdownContainer = $(`
                        <div class="dropdown mb-2">
                            <button class="btnFilter dropdown-toggle" type="button" id="dropdownFilters" data-bs-toggle="dropdown" aria-expanded="false">
                                Filtros
                            </button>
                            <div class="dropdown-menu p-3" aria-labelledby="dropdownFilters">
                                <div id="filtersContent"></div>
                            </div>
                        </div>
                    `);
            
                    if (!$('#filterUnidade').length) {
                        var selectUnidade = $('<select id="filterUnidade" class="form-select form-select-sm mb-2"><option value="">TODAS</option></select>');
                        @foreach ($monitoramentosDaUnidade->unique('risco.unidade.unidadeNome') as $monitoramento)
                            selectUnidade.append('<option value="{{ $monitoramento->risco->unidade->unidadeSigla }}">{{ $monitoramento->risco->unidade->unidadeSigla }}</option>');
                        @endforeach
            
                        var labelUnidades = $('<label for="filterUnidade" class="form-label">Unidades:</label>');
                        $('#filtersContent').append(labelUnidades).append(selectUnidade);
                    }
            
                    $('#filtersContent').append($('.dataTables_length'));
            
                    // Adiciona o dropdown dentro da div com id "tableHome2_filter"
                    $('#tableHome2_filter').prepend(dropdownContainer);
            
                    // Evento de filtro de unidade (agora filtrando pela sigla)
                    $('#filterUnidade').on('change', function() {
                        var val = $.fn.dataTable.util.escapeRegex($(this).val());
                        table.column(0)  // Coluna 0 é onde você deve ter a sigla da unidade
                            .search(val ? '^' + val + '$' : '', true, false)  // A pesquisa é feita pela sigla exata
                            .draw();
                    });
                }
            });
        });
    </script>
    
</body>

</html>
@endsection
