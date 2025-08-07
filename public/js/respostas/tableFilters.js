$(document).ready(function () {
  if ($.fn.DataTable.isDataTable('#respostasTable')) {
    $('#respostasTable').DataTable().destroy();
  }

  // Pegar dados do Blade via atributo data
  let unidades = $('#respostasTableWrapper').data('unidades');

  let table = $('#respostasTable').DataTable({
    language: {
      "sEmptyTable": "Nenhum registro encontrado",
      "sInfo": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
      "sInfoEmpty": "Mostrando 0 até 0 de 0 registros",
      "sInfoFiltered": "(Filtrados de _MAX_ registros)",
      "sInfoPostFix": "",
      "sInfoThousands": ".",
      "sLengthMenu": "_MENU_ resultados por página",
      "sLoadingRecords": "Carregando...",
      "sProcessing": "Processando...",
      "sZeroRecords": "Nenhum registro encontrado",
      "sSearch": "Pesquisar",
      "oPaginate": {
        "sNext": "Próximo",
        "sPrevious": "Anterior",
        "sFirst": "Primeiro",
        "sLast": "Último"
      },
      "oAria": {
        "sSortAscending": ": Ordenar colunas de forma ascendente",
        "sSortDescending": ": Ordenar colunas de forma descendente"
      }
    },
    initComplete: function () {
      let api = this.api();

      setTimeout(function () {
        let filterUnidadeDiv = $(`
          <div class="dt-layout-cell d-flex align-items-center" style="gap: 4px;">
            <label for="filter-unidade">Unidade:</label>
            <select id="filter-unidade" class="form-select form-select-sm" style="background-color: #fff !important; border: 1px solid #aaa; border-radius: 3px !important;">
              <option value="">Todas as unidades</option>
            </select>
          </div>
        `);

        unidades.sort((a, b) => a.unidadeSigla.localeCompare(b.unidadeSigla));

        unidades.forEach(u => {
          filterUnidadeDiv.find('select').append(
            `<option value="${u.unidadeSigla}">${u.unidadeSigla}</option>`
          );
        });

        let lengthDiv = $('.dt-length');
        let searchDiv = $('.dt-search');

        let parent = lengthDiv.parent();
        parent.css({
          display: 'flex',
          alignItems: 'center',
          justifyContent: 'space-between',
          flexWrap: 'nowrap'
        });

        lengthDiv.wrap('<div class="dt-layout-cell"></div>');
        searchDiv.wrap('<div class="dt-layout-cell"></div>');

        // À esquerda do "per page"
        filterUnidadeDiv.insertBefore(lengthDiv.parent());

        $('#filter-unidade').on('change', function () {
          let val = $.fn.dataTable.util.escapeRegex($(this).val());
          api.column(2).search(val ? '^' + val + '$' : '', true, false).draw();
        });
      }, 0);
    }
  });
});
