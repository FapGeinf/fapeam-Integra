$(document).ready(function () {
	let table = $('#indicadores-table').DataTable({
		order: [
			[0, "asc"] // Corrigido o índice de ordenação (antes estava [7], o que provavelmente não existe)
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
			infoEmpty: "Nenhum registro disponível",
			infoFiltered: "(Filtrados de _MAX_ registros no total)",
			infoPostFix: "",
			loadingRecords: "Carregando...",
			zeroRecords: "Nada encontrado. Se achar que isso é um erro, contate o suporte.",
			emptyTable: "Nenhum dado disponível nesta tabela",
			paginate: {
				first: "Primeiro",
				previous: "Anterior",
				next: "Próximo",
				last: "Último"
			},
			aria: {
				sortAscending: ": ativar para ordenar a coluna de forma ascendente",
				sortDescending: ": ativar para ordenar a coluna de forma descendente"
			}
		}
	});
});
