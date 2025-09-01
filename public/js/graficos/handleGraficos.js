document.addEventListener('DOMContentLoaded', () => {
  const chartData = window.chartData || {};

  function createChart(container, title, data, chartType) {
    Highcharts.chart(container, {
      chart: { type: chartType },
      title: { text: null }, 
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

  createChart('container-eixos', '', chartData.eixos || [], 'bar');
  createChart('container-publico', '', chartData.publico || [], 'line');

  Highcharts.chart('container-eventos', {
    chart: { type: 'pie' },
    title: { text: null },  // Sem título para o gráfico de pizza
    series: [{
      name: 'Atividades',
      colorByPoint: true,
      data: chartData.eventos || []
    }],
    tooltip: {
      pointFormat: '{point.name}: <b>{point.y}</b> Atividades'
    }
  });

  createChart('container-canais', '', chartData.canais || [], 'area');

  function filterCharts() {
    const select = document.querySelector('[data-filter-select]');
    const selectedCategory = select ? select.value : '';

    let foundResults = false;

    document.querySelectorAll('[data-chart-card]').forEach(card => {
      const category = card.getAttribute('data-category');
      if (!selectedCategory || category === selectedCategory) {
        card.style.display = '';
        foundResults = true;
      } else {
        card.style.display = 'none';
      }
    });

    const noResultsMessage = document.getElementById('no-results-message');
    if (noResultsMessage) {
      if (foundResults) {
        noResultsMessage.classList.add('d-none');
      } else {
        noResultsMessage.classList.remove('d-none');
      }
    }
  }

  const filterButton = document.querySelector('[data-filter-button]');
  if (filterButton) {
    filterButton.addEventListener('click', filterCharts);
  }
});
