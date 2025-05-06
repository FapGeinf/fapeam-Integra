$(document).ready(function() {
    let table = $('#tableHome2').DataTable({
        order: [
            [7, "asc"]
        ],
        autoWidth: false,
        columnDefs: [{
            targets: "_all",
            defaultContent: ""
        }],
        language: {
            decimal: ",",
            thousands: ".",
            processing: "Processando...",
            search: "Procurar:",
            lengthMenu: "Mostrar _MENU_ registros",
            info: "Mostrando página _PAGE_ de _PAGES_",
            infoEmpty: "Sem monitoramentos disponíveis no momento",
            infoFiltered: "(Filtrados do total de _MAX_ monitoramentos)",
            infoPostFix: "",
            loadingRecords: "Carregando...",
            zeroRecords: "Nada encontrado. Se achar que isso é um erro, contate o suporte.",
            emptyTable: "Nenhum dado disponível na tabela",
            paginate: {
                first: "Primeiro",
                previous: "Anterior",
                next: "Próximo",
                last: "Último"
            },
            aria: {
                sortAscending: ": ativar para ordenar a coluna de forma crescente",
                sortDescending: ": ativar para ordenar a coluna de forma decrescente"
            }
        }
    });
});