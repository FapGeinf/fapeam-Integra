@extends('layouts.app')
@section('content')
<div class="container-lg mt-5">
    <div class="row row-cols-1 row-cols-md-3 g-4">
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
    </div>
</div>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/offline-exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
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
    });
</script>
@endsection
