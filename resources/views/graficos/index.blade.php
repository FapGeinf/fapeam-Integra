@extends('layouts.app')

<script src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
<script src="https://code.highcharts.com/modules/offline-exporting.js"></script>

<link rel="stylesheet" href="{{ asset('css/index.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

@section('content')
    <div class="container-fluid pt-5 p-30">
        @if(session('success'))
            <div class="alert alert-success text-center auto-dismiss">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger text-center auto-dismiss">
                {{ session('error') }}
            </div>
        @endif

        <div class="col-12 border main-datatable">
            <div class="container-fluid">
                <div class="row g-3 mb-3">
                    <div class="col-md-4 mb-3">
                        <label for="category-select" class="fw-bold">Filtrar Gráficos:</label>
                        <select id="category-select" class="form-select pointer">
                            <option value="">Todas as categorias</option>
                            <option value="eixos">Eixos</option>
                            <option value="publico">Público</option>
                            <option value="canais">Canais</option>
                            <option value="eventos">Eventos</option>
                        </select>
                    </div>
                    <div class="col-md-2 align-self-end mb-3">
                        <button class="btn btn-primary btn-sm" onclick="filterCharts()">Filtrar</button>
                    </div>

                </div>

                <div id="no-results-message" class="alert alert-warning d-none text-center" role="alert">
                    Nenhum resultado encontrado.
                </div>

                <div class="row text-center mb-4">
                    <div class="col-lg-3 col-md-6 mb-3">
                        <div class="card info-card shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title"><i class="fas fa-tasks me-2"></i>Total de Atividades</h5>
                                <p class="info-badge bg-primary">{{ $atividades->count() }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-3">
                        <div class="card info-card shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title"><i class="fas fa-cogs me-2"></i>Total de Eixos</h5>
                                <p class="info-badge bg-success">{{ $eixos->count() }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-3">
                        <div class="card info-card shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title"><i class="fas fa-share-alt me-2"></i>Total de Canais de Divulgação
                                </h5>
                                <p class="info-badge bg-warning">{{ $canais->count() }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-3">
                        <div class="card info-card shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title"><i class="fas fa-users me-2"></i>Total de Tipos de Públicos</h5>
                                <p class="info-badge bg-danger">{{ $publicos->count() }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <div class="row">
                        @foreach([['eixos', 'Eixo'], ['publico', 'Público'], ['eventos', 'Tipo de Evento'], ['canais', 'Canal']] as $chart)
                            <div class="col-lg-6 col-md-12 mb-4">
                                <div class="card shadow-sm" data-category="{{ $chart[0] }}">
                                    <div class="card-body">
                                        <h5 class="fw-bold text-center mb-3">
                                            Distribuição das Atividades por {{ $chart[1] }}
                                        </h5>
                                        <div id="container-{{ $chart[0] }}" style="min-height: 350px;"></div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
        const chartData = {
            eixos: @json($graficoEixos),
            publico: @json($graficoPublico),
            eventos: @json($graficoEventos),
            canais: @json($graficoCanais)
        };

        function createChart(container, title, data, chartType) {
            Highcharts.chart(container, {
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
        }

        createChart('container-eixos', '', chartData.eixos, 'bar');
        createChart('container-publico', '', chartData.publico, 'line');
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
        createChart('container-canais', '', chartData.canais, 'area');

        function filterCharts() {
            const selectedCategory = document.getElementById('category-select').value;

            let foundResults = false;

            document.querySelectorAll('[data-category]').forEach(card => {
                const category = card.getAttribute('data-category');

                if (selectedCategory === '') {
                    card.style.display = 'block';
                    foundResults = true;
                } else if (category === selectedCategory) {
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