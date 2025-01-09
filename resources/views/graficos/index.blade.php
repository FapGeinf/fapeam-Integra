@extends('layouts.app')
<link rel="stylesheet" href="{{ asset('css/graficos.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"> <!-- CDN Font Awesome -->

@section('content')
<div class="container-fluid mt-5">
    <div class="row justify-content-center mb-4">
        <div class="col-lg-10">
            <div class="card p-3 shadow-sm rounded-3">
                <div class="d-flex justify-content-between align-items-center">
                    <input type="text" id="search-bar" class="form-control w-75" placeholder="Pesquise por categoria..."
                        onkeyup="filterCharts()">
                    <button class="btn btn-primary ms-3" onclick="filterCharts()">Filtrar</button>
                </div>
            </div>
        </div>
    </div>

    <div id="no-results-message" class="alert alert-warning d-none text-center" role="alert">
        Nenhum resultado encontrado.
    </div>

    <div class="row text-center mb-4">
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card info-card shadow-lg">
                <div class="card-body">
                    <h5 class="card-title"><i class="fas fa-tasks me-2"></i>Total de Atividades</h5>
                    <p class="info-badge bg-primary">{{ $atividades->count() }}</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card info-card shadow-lg">
                <div class="card-body">
                    <h5 class="card-title"><i class="fas fa-cogs me-2"></i>Total de Eixos</h5>
                    <p class="info-badge bg-success">{{ $eixos->count() }}</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card info-card shadow-lg">
                <div class="card-body">
                    <h5 class="card-title"><i class="fas fa-share-alt me-2"></i>Total de Canais de Divulgação</h5>
                    <p class="info-badge bg-warning">{{ $canais->count() }}</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card info-card shadow-lg">
                <div class="card-body">
                    <h5 class="card-title"><i class="fas fa-users me-2"></i>Total de Tipos de Públicos</h5>
                    <p class="info-badge bg-danger">{{ $publicos->count() }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        @foreach([['eixos', 'Eixo', 'Eixos'], ['publico', 'Público', 'Publico'], ['eventos', 'Tipo de Evento','Eventos','Evento'], ['canais', 'Canal', 'Canais']] as $chart)
            <div class="col-lg-6 col-md-12 mb-4">
                <div class="card chart-card shadow-lg" data-category="{{ $chart[0] }}">
                    <div class="card-body">
                        <h4 class="card-title d-flex align-items-center">
                            <i class="fas fa-chart-bar me-2"></i>{{ 'Distribuição das Atividades por ' . $chart[1] }}
                        </h4>
                        <div id="container-{{ $chart[0] }}" class="chart-container"></div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
<script src="https://code.highcharts.com/modules/offline-exporting.js"></script>
<script>
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
            pie: { innerSize: '50%', depth: 45 },
            area: { stacking: 'normal' }
        }
    });

    Highcharts.chart('container-eixos', chartOptions('container-eixos', '', chartData.eixos, 'bar'));
    Highcharts.chart('container-publico', chartOptions('container-publico', '', chartData.publico, 'line'));
    Highcharts.chart('container-eventos', {
        chart: { type: 'pie' },
        title: { text: 'Distribuição das Atividades por Tipo de Evento' },
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
        let foundResults = false;

        document.querySelectorAll('.chart-card').forEach(card => {
            const category = card.getAttribute('data-category');
            const chartTitle = card.querySelector('.card-title').textContent.toLowerCase();
            if (chartTitle.includes(searchQuery)) {
                card.style.display = 'block';
                foundResults = true;
            } else {
                card.style.display = 'none';
            }
        });

        const noResultsMessage = document.getElementById('no-results-message');
        if (foundResults) {
            noResultsMessage.classList.add('d-none');
        } else {
            noResultsMessage.classList.remove('d-none');
        }
    }
</script>
@endsection
