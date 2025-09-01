$(document).ready(function () {
    let table = $('#versionamentosTable').DataTable({
        order: [[2, "asc"]],
        autoWidth: false,
        columnDefs: [{
            targets: "_all",
            defaultContent: ""
        }],
        language: {
            emptyTable: "Nenhum registro disponível",
            info: "Mostrando página _PAGE_ de _PAGES_",
            infoEmpty: "Sem registros disponíveis no momento",
            infoFiltered: "(filtrado de _MAX_ registros no total)",
            lengthMenu: "Mostrar _MENU_ registros",
            loadingRecords: "Carregando...",
            processing: "Processando...",
            search: "Procurar:",
            zeroRecords: "Nada encontrado. Se achar que isso é um erro, contate o suporte.",
            paginate: {
                first: "Primeiro",
                last: "Último",
                next: "Próximo",
                previous: "Anterior"
            },
            aria: {
                sortAscending: ": ativar para ordenar a coluna em ordem crescente",
                sortDescending: ": ativar para ordenar a coluna em ordem decrescente"
            }
        }
    });

    $('#filter-data').on('change', function () {
        let order = $(this).val();
        table.order([2, order]).draw();
    });

});
