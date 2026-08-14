$(document).ready(function () {
    $('#diretorias-table').DataTable({
        order: [[0, "asc"]], // Ordena por padrão pela Sigla
        autoWidth: false,
        columnDefs: [
            { targets: "_all", defaultContent: "" },
            { targets: 3, orderable: false, searchable: false } // Desativa ordenação na coluna de ações (index 3)
        ],
        language: {
            decimal: ",",
            thousands: ".",
            emptyTable: "Nenhuma diretoria cadastrada no sistema",
            info: "Mostrando página _PAGE_ de _PAGES_",
            infoEmpty: "Sem diretorias disponíveis",
            infoFiltered: "(Filtrados do total de _MAX_ diretorias)",
            lengthMenu: "Mostrar _MENU_ registros por página",
            loadingRecords: "Carregando...",
            processing: "Processando...",
            search: "Procurar:",
            zeroRecords: "Nenhuma diretoria encontrada.",
            paginate: { first: "Primeiro", last: "Último", next: "Próximo", previous: "Anterior" }
        }
    });
});