$(document).ready(function () {
    let table = $('#respostasTable').DataTable({
        paging: true,
        searching: true,
        lengthChange: true,
        info: true,
        autoWidth: false,
        responsive: true,
        language: {
            sSearch: "Pesquisar:",
            sLengthMenu: "Exibir _MENU_ registros por página",
            sInfo: "Exibindo _START_ até _END_ de _TOTAL_ registros",
            sInfoEmpty: "Exibindo 0 até 0 de 0 registros",
            sInfoFiltered: "(filtrado de _MAX_ registros no total)",
            sZeroRecords: "Nenhum registro encontrado",
            oPaginate: {
                sPrevious: "Anterior",
                sNext: "Próximo"
            }
        }
    });

    $('#filter-unidade').on('change', function () {
        let unidade = $(this).val();
        table.column(1).search(unidade).draw(); 
    });
});
