$(document).ready(function () {
    let tabelaUnidades = $('#unidades-table').DataTable({
        order: [[0, "asc"]],
        autoWidth: false,
        columnDefs: [
            {
                targets: "_all",
                defaultContent: ""
            },
            {
                targets: 4,
                orderable: false,
                searchable: false
            }
        ],
        language: {
            decimal: ",",
            thousands: ".",
            emptyTable: "Nenhuma unidade cadastrada no sistema",
            info: "Mostrando página _PAGE_ de _PAGES_",
            infoEmpty: "Sem unidades disponíveis no momento",
            infoFiltered: "(Filtrados do total de _MAX_ unidades)",
            infoPostFix: "",
            lengthMenu: "Mostrar _MENU_ registros por página",
            loadingRecords: "Carregando unidades...",
            processing: "Processando...",
            search: "Procurar:",
            zeroRecords: "Nenhuma unidade encontrada para a busca.",
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
});