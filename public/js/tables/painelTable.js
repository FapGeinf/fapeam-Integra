$(document).ready(function () {

    let table = $('#painel-table').DataTable({
        dom:
            "<'row align-items-center mb-2'<'col-auto'l><'col d-flex justify-content-center unidade-container'><'col-auto'f>>" +
            "rt" +
            "<'row align-items-center mt-2'<'col'i><'col-auto'p>>",
        language: {
            processing: "Processando...",
            search: "Pesquisar:",
            lengthMenu: "Mostrar _MENU_ registros",
            info: "Mostrando de _START_ até _END_ de _TOTAL_ registros",
            infoEmpty: "Mostrando 0 até 0 de 0 registros",
            infoFiltered: "(filtrado de _MAX_ registros no total)",
            loadingRecords: "Carregando...",
            zeroRecords: "Nenhum registro encontrado",
            emptyTable: "Nenhum dado disponível na tabela",
            paginate: {
                first: "Primeiro",
                previous: "Anterior",
                next: "Próximo",
                last: "Último"
            },
            aria: {
                sortAscending: ": ativar para ordenar a coluna em ordem crescente",
                sortDescending: ": ativar para ordenar a coluna em ordem decrescente"
            }
        }
    });

    $('.unidade-container').html(
        $('#unidadeFilter').closest('div').show()
    );

    $('#unidadeFilter').on('change', function () {
        table
            .column(3)
            .search(this.value)
            .draw();
    });

});
