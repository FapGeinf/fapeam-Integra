$(document).ready(function () {
    $('#painel-table').DataTable({
        language: {
            processing: "Processando...",
            search: "Pesquisar:",
            lengthMenu: "Mostrar _MENU_ registros",
            info: "Mostrando de _START_ até _END_ de _TOTAL_ registros",
            infoEmpty: "Mostrando 0 até 0 de 0 registros",
            infoFiltered: "(filtrado de _MAX_ registros no total)",
            infoPostFix: "",
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
            },
            buttons: {
                copy: 'Copiar',
                print: 'Imprimir',
                colvis: 'Visibilidade'
            }
        }
    });
});