@extends('layouts.app')
@section('content')
@section('title') {{'Página Inicial'}} @endsection
<!DOCTYPE html>
<html lang="pt-BR">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
	<link rel="stylesheet" href="{{asset('css/home.css')}}">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.2.3/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.js"></script>
</head>
<body>

	<div class="container-fluid p-30">
		<div class="col-12 main-datatable">

			<div class="divButtonNewRisk">
				@if(session('error'))
				<script>alert('{{ session('error') }}');</script>
				@endif

				<div id="newRiskButtonDiv" class="buttonNewRisk">
					@if (Auth::user()->unidade->unidadeTipoFK == 1)
						<a href="{{route('riscos.create')}}" class=""><i class="bi bi-plus-lg"></i> Novo Risco</a>
					@endif
				</div>
			</div>
			
			<div class="container-fluid">
				<table id="tableHome" class="table cust-datatable">
					<thead class="">
						<tr>
							<th>Unidade</th>
							<th>Evento de Risco</th>
							<th>Causa</th>
							<th>Consequência</th>
							<th>Avaliação</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($riscos as $risco)
							<tr style="cursor: pointer;" onclick="window.location='{{ route('riscos.show', $risco->id) }}';">
								<td>{{$risco->unidade->unidadeNome}}</td>
								<td>{!!$risco->riscoEvento!!}</td>
								<td>{!!$risco->riscoCausa!!}</td>
								<td>{!!$risco->riscoConsequencia!!}</td>
								<td>{{$risco->riscoAvaliacao}}</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>
			</div>
		</div>

		<footer class="rodape">
			<div class="riskLevelDiv">
				<span>Nível de Risco:</span>
				<span class="riskLevel1">Baixo</span>
				<span class="riskLevel2">Médio</span>
				<span class="riskLevel3">Alto</span>
			</div>
		</footer>
				


		<script>
$(document).ready(function(){
    var table = $('#tableHome').DataTable({
        language: {
					url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/pt-BR.json',
            search: "Procurar:",
            lengthMenu: "Relatórios: _MENU_",
            info: 'Mostrando página _PAGE_ de _PAGES_',
            infoEmpty: 'Sem relatórios disponíveis para visualização',
            infoFiltered: '(Filtrados do total de _MAX_ relatórios)',
            zeroRecords: 'Nada encontrado. Se achar que isso foi um erro, contate o suporte.',
            paginate: {
						next: "Próximo",
						previous: "Anterior"
						}
						
        },
        initComplete: function(){
            // Cria um contêiner para alinhar os elementos na mesma linha
            var divContainer = $('<div class="divContainer" style="display: flex; justify-content: space-between;"></div>');

            // Move o botão de novo risco para a esquerda
            var divButtonNewRisk = $('<div class="divButtonNewRisk"></div>');
            divButtonNewRisk.append($('#newRiskButtonDiv'));
            divContainer.append(divButtonNewRisk);

            // Move o controle de show entries e a caixa de pesquisa para a direita
            var divSearchAndEntries = $('<div class="divSearchAndEntries"></div>');
            divSearchAndEntries.append($('.dataTables_length')).append($('.dataTables_filter'));
            divContainer.append(divSearchAndEntries);

            // Adiciona o contêiner ao topo da tabela
            $(table.table().container()).prepend(divContainer);
        }
    });

    table.on('draw', function(){
        // Garante que os elementos permaneçam alinhados após a recriação da tabela
        if (!$(".divContainer").length) {
            var divContainer = $('<div class="divContainer" style="display: flex; justify-content: space-between;"></div>');
            
            var divButtonNewRisk = $('<div class="divButtonNewRisk"></div>');
            divButtonNewRisk.append($('#newRiskButtonDiv'));
            divContainer.append(divButtonNewRisk);

            var divSearchAndEntries = $('<div class="divSearchAndEntries"></div>');
            divSearchAndEntries.append($('.dataTables_length')).append($('.dataTables_filter'));
            divContainer.append(divSearchAndEntries);

            $(table.table().container()).prepend(divContainer);
        }
    });
});


		</script>
		
		



</body>
</html>
@endsection
