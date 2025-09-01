$(document).ready(function () {
    let tabela = $('#tableHome2').DataTable({
        order: [[7, "asc"]],
        autoWidth: false,
        columnDefs: [{
            targets: "_all",
            defaultContent: ""
        }],
        language: {
            decimal: ",",
            thousands: ".",
            emptyTable: "Nenhum dado disponível na tabela",
            info: "Mostrando página _PAGE_ de _PAGES_",
            infoEmpty: "Sem monitoramentos disponíveis no momento",
            infoFiltered: "(Filtrados do total de _MAX_ monitoramentos)",
            infoPostFix: "",
            lengthMenu: "Mostrar _MENU_ registros por página",
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
        let ordem = $(this).val();
        tabela.order([7, ordem]).draw();
    });

    $('#filter-canal').on('change', function () {
        let canal = $(this).val();
        tabela.column(6).search(canal).draw();
    });

    $('#filter-publico').on('change', function () {
        let publico = $(this).val();
        tabela.column(4).search(publico).draw();
    });

    $('#filter-evento').on('change', function () {
        let evento = $(this).val();
        tabela.column(5).search(evento).draw();
    });
});
