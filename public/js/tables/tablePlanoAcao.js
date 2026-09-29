$(document).ready(function () {
    let tabela = $('#tablePlanoAcao').DataTable({
        order: [[0, "desc"]], 
        autoWidth: false,
        columnDefs: [
            { targets: "_all", defaultContent: "" },
            { targets: [6], orderable: false }
        ],
        language: {
            decimal: ",",
            thousands: ".",
            emptyTable: "Nenhum dado disponível na tabela",
            info: "Mostrando página _PAGE_ de _PAGES_",
            infoEmpty: "Sem planos de ação disponíveis no momento",
            infoFiltered: "(Filtrados do total de _MAX_ registros)",
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

    $('#filter-bienio').on('change', function () {
        let bienio = $(this).val();
        if (bienio) {
            tabela.column(1).search('^' + bienio + '$', true, false).draw();
        } else {
            tabela.column(1).search('').draw();
        }
    });

    $('#filter-eixo').on('change', function () {
        let eixo = $(this).val();
        tabela.column(2).search(eixo).draw();
    });

    $('#filter-responsavel').on('change', function () {
        let responsavel = $(this).val();
        tabela.column(4).search(responsavel).draw();
    });
});