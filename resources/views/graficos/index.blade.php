@extends('layouts.app')

<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>

@section('content')
<div class="container-fluid mt-5">
    <div class="row d-flex justify-content-center">
        @foreach([['eixos', 'Eixo'], ['publico', 'Público'], ['eventos', 'Tipo de Evento'], ['canais', 'Canal']] as $chart)
            <div class="col-lg-6 mb-4">
                <div class="card rounded-3 border-1">
                    <div class="card-body">
                        <h4 class="card-title">Distribuição das Atividades por {{ $chart[1] }}</h4>
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
            data: data.map(item => item.y)  
        }]
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
        }]
    });

    // Gráfico de área para Canal
    Highcharts.chart('container-canais', chartOptions('container-canais', '', chartData.canais, 'area'));
</script>
@endsection
