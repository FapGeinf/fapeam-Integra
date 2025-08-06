$(document).ready(function () {
  if ($.fn.DataTable.isDataTable('#respostasTable')) {
    $('#respostasTable').DataTable().destroy();
  }

  // Pegar dados do Blade via atributo data
  let unidades = $('#respostasTableWrapper').data('unidades');

  let table = $('#respostasTable').DataTable({
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

        // Popular options
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
          api.column(1).search(val ? '^' + val + '$' : '', true, false).draw();
        });
      }, 0);
    }
  });
});
