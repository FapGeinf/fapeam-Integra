@extends('layouts.app')
@section('content')
<div class="container-lg mt-5">
    <div class="row row-cols-1 row-cols-md g-4 mt-4 mb-4">
        <div class="col">
            <div class="card shadow-sm border-1 rounded-3 bg-light">
                <div class="card-body">
                    <form method="GET" action="{{ route('graficos.index') }}" class="mb-4">
                        <div class="row">
                            <div class="col-md-2">
                                <label for="ano" class="form-label">Ano</label>
                                <select name="ano" id="ano" class="form-select">
                                    <option value="">Selecione um ano</option>
                                    @foreach($anos as $ano)
                                        <option value="{{ $ano }}" {{ request('ano') == $ano ? 'selected' : '' }}>{{ $ano }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="unidade" class="form-label">Unidade</label>
                                <select name="unidade" id="unidade" class="form-select">
                                    <option value="">Selecione uma unidade</option>
                                    @foreach($unidades as $unidade)
                                        <option value="{{ $unidade->id }}" {{ request('unidade') == $unidade->id ? 'selected' : '' }}>
                                            {{ $unidade->unidadeNome }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="eixo" class="form-label">Eixo</label>
                                <select name="eixo" id="eixo" class="form-select">
                                    <option value="">Selecione um eixo</option>
                                    @foreach($eixos as $eixo)
                                        <option value="{{ $eixo->id }}" {{ request('eixo') == $eixo->id ? 'selected' : '' }}>
                                            {{ $eixo->nome }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="nivel_de_risco" class="form-label">Nível de Risco</label>
                                <select name="nivel_de_risco" id="nivel_de_risco" class="form-select">
                                    <option value="">Selecione um nível de risco</option>
                                    <option value="1" {{ request('nivel_de_risco') == 1 ? 'selected' : '' }}>Baixo
                                    </option>
                                    <option value="2" {{ request('nivel_de_risco') == 2 ? 'selected' : '' }}>Médio
                                    </option>
                                    <option value="3" {{ request('nivel_de_risco') == 3 ? 'selected' : '' }}>Alto</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="isContinuo" class="form-label">Tipo de Monitoramento</label>
                                <select name="isContinuo" id="isContinuo" class="form-select">
                                    <option value="">Selecione uma opção</option>
                                    <option value="1" {{ request('isContinuo') == '1' ? 'selected' : '' }}>Contínuo
                                    </option>
                                    <option value="0" {{ request('isContinuo') == '0' ? 'selected' : '' }}>Não Contínuo
                                    </option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="statusMonitoramento" class="form-label">Status do Monitoramento</label>
                                <select name="statusMonitoramento" id="statusMonitoramento" class="form-select">
                                    <option value="">Selecione um status</option>
                                    <option value="NÃO IMPLEMENTADA" {{ request('statusMonitoramento') == 'NÃO IMPLEMENTADA' ? 'selected' : '' }}>
                                        NÃO IMPLEMENTADA
                                    </option>
                                    <option value="EM IMPLEMENTAÇÃO" {{ request('statusMonitoramento') == 'EM IMPLEMENTAÇÃO' ? 'selected' : '' }}>
                                        EM IMPLEMENTAÇÃO
                                    </option>
                                    <option value="IMPLEMENTADA PARCIALMENTE" {{ request('statusMonitoramento') == 'IMPLEMENTADA PARCIALMENTE' ? 'selected' : '' }}>
                                        IMPLEMENTADA PARCIALMENTE
                                    </option>
                                    <option value="IMPLEMENTADA" {{ request('statusMonitoramento') == 'IMPLEMENTADA' ? 'selected' : '' }}>
                                        IMPLEMENTADA
                                    </option>
                                </select>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary mt-3">Filtrar</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="row row-cols-1 row-cols-md-3 g-4 mt-4">
            <div class="col">
                <div class="card shadow-sm border-1 rounded-3 text-center bg-light">
                    <div class="card-body">
                        <h5 class="card-title text-danger">Total de Riscos</h5>
                        <h2 class="card-text">{{ $totalRiscos }}</h2>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card shadow-sm border-1 rounded-3 text-center bg-light">
                    <div class="card-body">
                        <h5 class="card-title text-info">Total de Monitoramentos</h5>
                        <h2 class="card-text">{{ $totalMonitoramentos }}</h2>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card shadow-sm border-1 rounded-3 text-center bg-light">
                    <div class="card-body">
                        <h5 class="card-title text-primary">Total de Atividades</h5>
                        <h2 class="card-text">{{ $totalAtividades }}</h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-5 g-4">
            <div class="col-md-6 mt-4">
                <div class="card shadow-sm border-1 rounded-3 bg-light">
                    <div class="card-body">
                        <div id="grafico-atividades" style="height: 400px;"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mt-4">
                <div class="card shadow-sm border-1 rounded-3 bg-light">
                    <div class="card-body">
                        <div id="grafico-riscos-unidades" style="height: 400px;"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mt-4">
                <div class="card shadow-sm border-1 rounded-3 bg-light">
                    <div class="card-body">
                        <div id="grafico-riscos-nivel" style="height: 400px;"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mt-4">
                <div class="card shadow-sm border-1 rounded-3 bg-light">
                    <div class="card-body">
                        <div id="grafico-riscos-ano" style="height: 400px;"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mt-4">
                <div class="card shadow-sm border-1 rounded-3 bg-light">
                    <div class="card-body">
                        <div id="grafico-monitoramentos-continuos" style="height: 400px;"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mt-4">
                <div class="card shadow-sm border-1 rounded-3 bg-light">
                    <div class="card-body">
                        <div id="grafico-monitoramentos-status" style="height: 400px;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{asset('js/highcharts.js')}}"></script>
    <script src="{{asset('js/exporting.js')}}"></script>
    <script src="{{asset('js/offline-exporting.js')}}"></script>
    <script src="{{asset('js/export-data.js')}}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            Highcharts.chart('grafico-atividades', {
                chart: {
                    type: 'pie',
                    backgroundColor: '#f8f9fa',
                },
                title: {
                    text: 'Atividades por Eixo',
                },
                tooltip: {
                    pointFormat: '{series.name}: <b>{point.y}</b>',
                },
                plotOptions: {
                    pie: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                        dataLabels: {
                            enabled: true,
                            format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                        },
                        colors: ['#ff5733', '#33c1ff', '#8e44ad', '#f39c12'], // Personalizando as cores
                    },
                },
                series: [
                    {
                        name: 'Atividades',
                        colorByPoint: true,
                        data: @json($atividadesData),
                    },
                ],
                exporting: {
                    enabled: true,
                    buttons: {
                        contextButton: {
                            menuItems: ['downloadPNG', 'downloadPDF', 'downloadCSV', 'downloadXLS'] // Adiciona opções de exportação
                        }
                    }
                }
            });

            Highcharts.chart('grafico-riscos-unidades', {
                chart: {
                    type: 'column',
                    backgroundColor: '#f8f9fa',
                    borderRadius: 8,
                },
                title: {
                    text: 'Riscos por Unidade',
                },
                xAxis: {
                    type: 'category',
                    title: {
                        text: 'Unidades',
                    },
                },
                yAxis: {
                    title: {
                        text: 'Total de Riscos',
                    },
                },
                tooltip: {
                    pointFormat: '<b>{point.name}</b>: {point.y} riscos',
                },
                plotOptions: {
                    column: {
                        dataLabels: {
                            enabled: true,
                            format: '{point.y}',
                        },
                        color: '#3498db' // Cor personalizada para as colunas
                    },
                },
                series: [
                    {
                        name: 'Riscos',
                        colorByPoint: true,
                        data: @json($riscosUnidadeData),
                    },
                ],
                credits: {
                    enabled: false,
                },
                exporting: {
                    enabled: true,
                    buttons: {
                        contextButton: {
                            menuItems: ['downloadPNG', 'downloadPDF', 'downloadCSV', 'downloadXLS'] // Adiciona opções de exportação
                        }
                    }
                }
            });

            Highcharts.chart('grafico-riscos-nivel', {
                chart: {
                    type: 'pie',
                },
                title: {
                    text: 'Distribuição de Riscos por Nível',
                },
                tooltip: {
                    pointFormat: '{series.name}: <b>{point.y}</b> riscos',
                },
                plotOptions: {
                    pie: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                        dataLabels: {
                            enabled: true,
                            format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                        },
                        colors: ['#e74c3c', '#2ecc71', '#f39c12'] // Cores personalizadas para o gráfico de pizza
                    },
                },
                series: [
                    {
                        name: 'Nível de Risco',
                        colorByPoint: true,
                        data: @json($riscosNivelData),
                    },
                ],
                credits: {
                    enabled: false,
                },
                exporting: {
                    enabled: true,
                    buttons: {
                        contextButton: {
                            menuItems: ['downloadPNG', 'downloadPDF', 'downloadCSV', 'downloadXLS'] // Adiciona opções de exportação
                        }
                    }
                }
            });

            Highcharts.chart('grafico-riscos-ano', {
                chart: {
                    type: 'column',
                    backgroundColor: '#f8f9fa',
                    borderRadius: 8,
                },
                title: {
                    text: 'Riscos por Ano',
                },
                xAxis: {
                    type: 'category',
                    title: {
                        text: 'Ano',
                    },
                },
                yAxis: {
                    title: {
                        text: 'Total de Riscos',
                    },
                },
                tooltip: {
                    pointFormat: '<b>{point.name}</b>: {point.y} riscos',
                },
                plotOptions: {
                    column: {
                        dataLabels: {
                            enabled: true,
                            format: '{point.y}',
                        },
                    },
                },
                series: [
                    {
                        name: 'Riscos',
                        colorByPoint: true,
                        data: @json($riscosAnoData),
                    },
                ],
                credits: {
                    enabled: false,
                },
                exporting: {
                    enabled: true,
                    buttons: {
                        contextButton: {
                            menuItems: ['downloadPNG', 'downloadPDF', 'downloadCSV', 'downloadXLS']
                        }
                    }
                }
            });

            var monitoramentosData = @json($monitoramentosTipos);

            Highcharts.chart('grafico-monitoramentos-continuos', {
                chart: {
                    type: 'bar'
                },
                title: {
                    text: 'Distribuição de Monitoramentos: Contínuos vs Não Contínuos'
                },
                xAxis: {
                    categories: ['Contínuos', 'Não Contínuos'],
                    title: {
                        text: null
                    }
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: 'Quantidade',
                        align: 'high'
                    },
                    labels: {
                        overflow: 'justify'
                    }
                },
                series: [{
                    name: 'Monitoramentos',
                    data: [
                        monitoramentosData.find(item => item.isContinuo === 1)?.total || 0, // Contínuos
                        monitoramentosData.find(item => item.isContinuo === 0)?.total || 0  // Não contínuos
                    ]
                }]
            });
            let monitoramentosStatusData = @json($monitoramentosStatus);


            let categories = monitoramentosStatusData.map(function (item) {
                return item.statusMonitoramento;
            });

            let seriesData = monitoramentosStatusData.map(function (item) {
                return item.total;
            });

            Highcharts.chart('grafico-monitoramentos-status', {
                chart: {
                    type: 'column'
                },
                title: {
                    text: 'Monitoramento por Status'
                },
                xAxis: {
                    categories: categories,
                    title: {
                        text: 'Status'
                    }
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: 'Quantidade de Monitoramentos'
                    }
                },
                series: [{
                    name: 'Status Monitoramento',
                    data: seriesData
                }]
            });
        });
    </script>
    @endsection