$(document).ready(function() {
    let table = $('#indicadores-table').DataTable({
        order: [
            [7, "asc"]
        ],
        autoWidth: false,
        columnDefs: [{
            targets: "_all",
            defaultContent: ""
        }],
        responsive: true,
        language: {
            search: "Procurar:",
            info: 'Mostrando página _PAGE_ de _PAGES_',
            infoEmpty: 'Sem monitoramentos disponíveis no momento',
            infoFiltered: '(Filtrados do total de _MAX_ monitoramentos)',
            zeroRecords: 'Nada encontrado. Se achar que isso é um erro, contate o suporte.',
            paginate: {
                next: "Próximo",
                previous: "Anterior"
            }
        }
    });
});
