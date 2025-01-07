@extends('layouts.app')

<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>

@section('content')
<div class="container-fluid mt-5">
    <div class="row d-flex justify-content-center">
        <div class="col-lg-8 mb-4">
            <div class="card p-3 shadow-sm rounded-3">
                <div class="d-flex justify-content-between">
                    <input type="text" id="search-bar" class="form-control w-75" placeholder="Pesquise por categoria..." onkeyup="filterCharts()">
                    <button class="btn btn-primary" onclick="filterCharts()">Filtrar</button>
                </div>
            </div>
        </div>

        @foreach([['eixos', 'Eixo'], ['publico', 'Público'], ['eventos', 'Tipo de Evento'], ['canais', 'Canal']] as $chart)
            <div class="col-lg-6 mb-4">
                <div class="card rounded-3 border-0 shadow-lg chart-card" data-category="{{ $chart[0] }}">
                    <div class="card-body">
                        <h4 class="card-title d-flex align-items-center">
                            <i class="fas fa-chart-bar mr-2"></i>{{ 'Distribuição das Atividades por ' . $chart[1] }}
                        </h4>
                        <div id="container-{{ $chart[0] }}" style="width: 100%; height: 400px;"></div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

<script type="text/javascript">
    const chartData = {
        eixos: @json($graficoEixos),
        publico: @json($graficoPublico),
        eventos: @json($graficoEventos),
        canais: @json($graficoCanais)
    };

    const chartOptions = (container, title, data, chartType) => ({
        chart: { type: chartType }, 
        title: { text: title },
        xAxis: {
            categories: data.map(item => item.name),  
            title: { text: null }
        },
        yAxis: {
            min: 0,
            title: { text: 'Número de Atividades', align: 'high' },
            labels: { overflow: 'justify' }
        },
        series: [{
            name: 'Atividades',
            data: data.map(item => item.y),
            color: '#007bff',  
            borderRadius: 5    
        }],
        tooltip: { 
            pointFormat: '<b>{point.y}</b> Atividades'
        },
        plotOptions: {
            pie: {
                innerSize: '50%', 
                depth: 45
            },
            area: {
                stacking: 'normal'
            }
        }
    });

    Highcharts.chart('container-eixos', chartOptions('container-eixos', '', chartData.eixos, 'bar'));
    Highcharts.chart('container-publico', chartOptions('container-publico', '', chartData.publico, 'line'));
    Highcharts.chart('container-eventos', {
        chart: { type: 'pie' },
        title: { text: '' },
        series: [{
            name: 'Atividades',
            colorByPoint: true,
            data: chartData.eventos
        }],
        tooltip: {
            pointFormat: '{point.name}: <b>{point.y}</b> Atividades'
        }
    });
    Highcharts.chart('container-canais', chartOptions('container-canais', '', chartData.canais, 'area'));

    function filterCharts() {
        const searchQuery = document.getElementById('search-bar').value.toLowerCase();
        
        document.querySelectorAll('.chart-card').forEach(function(card) {
            const category = card.getAttribute('data-category');
            const chartTitle = card.querySelector('.card-title').textContent.toLowerCase();
            
            if (chartTitle.includes(searchQuery)) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });
    }
</script>

@endsection
