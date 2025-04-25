$(document).ready(function () {
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
            emptyTable: "Nenhum dado disponível na tabela",
            info: "Mostrando página _PAGE_ de _PAGES_",
            infoEmpty: "Sem monitoramentos disponíveis no momento",
            infoFiltered: "(Filtrados do total de _MAX_ monitoramentos)",
            infoPostFix: "",
            thousands: ".",
            lengthMenu: "Mostrar _MENU_ monitoramentos por página",
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
                sortAscending: ": ativar para ordenar a coluna de forma ascendente",
                sortDescending: ": ativar para ordenar a coluna de forma descendente"
            },
            select: {
                rows: {
                    _: "Você selecionou %d linhas",
                    0: "Clique em uma linha para selecioná-la",
                    1: "Apenas 1 linha selecionada"
                }
            }
        }
    });
});