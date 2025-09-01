@extends('layouts.app')

<script src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
<script src="https://code.highcharts.com/modules/offline-exporting.js"></script>

<link rel="stylesheet" href="{{ asset('css/index.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<script src="{{ asset('js/graficos/handleGraficos.js') }}"></script>

@section('content')
    <style>
        .page-title {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            padding-bottom: 0.5rem;
            margin-bottom: 2.5rem;
            font-weight: 700;
            position: relative;
            min-height: 60px;
            font-size: 2.5rem;
            color: #212529;
            margin-top: 25px;
        }

        .page-title::after {
            content: '';
            width: 80px;
            height: 4px;
            background-color: #0d6efd;
            border-radius: 3px;
            margin-top: 10px;
        }


        .filter-row {
            margin-bottom: 3rem;
        }

        .info-cards-row {
            margin-bottom: 3.5rem;
        }

        .chart-card {
            padding: 1.8rem 1.5rem;
        }

        [data-chart-card]>.card {
            height: 100%;
        }
    </style>

    <div class="container-fluid pt-5 p-30 mt-5 mb-5">
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
            <div class="container-fluid mt-5 mb-5">

                <h1 class="page-title text-center">Dashboard de Atividades</h1>
                <p class="text-center text-muted mb-5">
                    Visualize a distribuição das atividades por categorias para análise rápida.
                </p>

                <div class="row g-3 filter-row justify-content-center">
                    <div class="col-md-4 mb-3">
                        <label for="category-select" class="fw-bold">Filtrar Gráficos:</label>
                        <select id="category-select" class="form-select pointer" data-filter-select>
                            <option value="">Todas as categorias</option>
                            <option value="eixos">Eixos</option>
                            <option value="publico">Público</option>
                            <option value="canais">Canais</option>
                            <option value="eventos">Eventos</option>
                        </select>
                    </div>
                    <div class="col-md-2 align-self-end mb-3">
                        <button class="btn btn-primary btn-sm w-100" data-filter-button>Filtrar</button>
                    </div>
                </div>

                <div id="no-results-message" class="alert alert-warning d-none text-center fw-semibold" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i> Nenhum resultado encontrado.
                </div>

                <div class="row text-center info-cards-row">
                    <div class="col-lg-3 col-md-6 mb-3">
                        <div class="card info-card shadow-sm rounded-4 border-0">
                            <div class="card-body">
                                <i class="fas fa-tasks fa-3x text-primary mb-3"></i>
                                <h5 class="card-title fw-semibold">Total de Atividades</h5>
                                <p class="display-6 fw-bold">{{ $atividades->count() }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6 mb-3">
                        <div class="card info-card shadow-sm rounded-4 border-0">
                            <div class="card-body">
                                <i class="fas fa-cogs fa-3x text-success mb-3"></i>
                                <h5 class="card-title fw-semibold">Total de Eixos</h5>
                                <p class="display-6 fw-bold">{{ $eixos->count() }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6 mb-3">
                        <div class="card info-card shadow-sm rounded-4 border-0">
                            <div class="card-body">
                                <i class="fas fa-share-alt fa-3x text-warning mb-3"></i>
                                <h5 class="card-title fw-semibold">Total de Canais de Divulgação</h5>
                                <p class="display-6 fw-bold">{{ $canais->count() }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6 mb-3">
                        <div class="card info-card shadow-sm rounded-4 border-0">
                            <div class="card-body">
                                <i class="fas fa-users fa-3x text-danger mb-3"></i>
                                <h5 class="card-title fw-semibold">Total de Tipos de Públicos</h5>
                                <p class="display-6 fw-bold">{{ $publicos->count() }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <div class="row">
                        @foreach([['eixos', 'Eixo'], ['publico', 'Público'], ['eventos', 'Tipo de Evento'], ['canais', 'Canal']] as $chart)
                            <div class="col-lg-6 col-md-12 mb-4" data-category="{{ $chart[0] }}" data-chart-card>
                                <h5 class="text-center mb-3 fw-semibold text-secondary">
                                    Distribuição das Atividades por {{ $chart[1] }}
                                </h5>
                                <div class="card shadow-sm rounded-4 border-0 chart-card">
                                    <div id="container-{{ $chart[0] }}" style="min-height: 350px;" data-chart-container></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
        window.chartData = {
            eixos: @json($graficoEixos),
            publico: @json($graficoPublico),
            eventos: @json($graficoEventos),
            canais: @json($graficoCanais)
        };
    </script>
@endsection