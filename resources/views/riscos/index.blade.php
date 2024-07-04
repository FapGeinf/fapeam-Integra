@extends('layouts.app')
@section('content')
@section('title') {{'Página Inicial'}} @endsection
<!DOCTYPE html>
<html lang="pt-BR">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
	<link rel="stylesheet" href="{{asset('css/index.css')}}">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.2.3/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.js"></script>
</head>
<body>

	<div class="container-fluid p-30">

		<div class="divButtonNewRisk">
			@if(session('error'))
				<script>alert('{{ session('error') }}')</script>
			@endif
			<div class="divPrazoGeral">
				<div id="newRiskButtonDiv" class="green-btn">
					@if (Auth::user()->unidade->unidadeTipoFK == 1)
						<a href="{{route('riscos.create')}}" class="green-btn"><i class="bi bi-plus-lg"></i> Novo Risco</a>
					@endif
				</div>

			<div></div>
	
			<div class="warningRisks">
				Riscos Abertos: <span id="spanRisk">{{ $riscosAbertos }} </span>

				/

				Hoje: <span id="spanRiskHoje">{{ $riscosAbertosHoje }}</span>
				@if ($riscosAbertosHoje > 0)
						<i class="bi bi-caret-up-fill" style="color: #28a745"></i>
				@else
						<i class="bi bi-caret-down-fill" style="color: red"></i>
				@endif
		</div>
		
			
			<div>
				<button type="button" class="btnInserirPrazo" data-bs-toggle="modal" data-bs-target="#prazoModal">
					<i class="bi bi-calendar2-plus-fill"></i>
				</button>

				<p class="prazoGeral" id="prazo">
					<span id="spanPrazoGeral">Prazo Final: {{ \Carbon\Carbon::parse($prazo)->format('d/m/Y') }}</span> 
				</p>
			</div>
		</div>
		

		</div>

		<div class="col-12 main-datatable">

			<div class="container-fluid">
				<table id="tableHome" class="table cust-datatable">
					<thead>
						<tr>
							<th style="width: 90px;">N° Risco</th>
							<th>Responsável</th>
							<th style="white-space:nowrap;">Unidade</th>
							<th style="white-space: nowrap;">Evento de Risco</th>
							<th>Causa</th>
							<th>Consequência</th>
							<th style="width: 90px;">Avaliação</th>
							<th>Início Monitoramento</th>
							<th>Fim Monitoramento</th>
						</tr>
					</thead>

					<tbody>
						@foreach ($riscos as $risco)
							@foreach ($risco->monitoramentos as $monitoramento)
								<tr style="cursor: pointer;" onclick="window.location='{{ route('riscos.show', $risco->id) }}';">
									<td>{{ $risco->riscoNum }}</td>
									<td style="white-space: nowrap;">{!! $risco->responsavelRisco !!}</td>
									<td style="white-space: nowrap;">{!! $risco->unidade->unidadeNome !!}</td>
									<td>{!! Str::limit($risco->riscoEvento, 80) !!}</td>
									<td>{!! Str::limit($risco->riscoCausa, 80) !!}</td>
									<td>{!! Str::limit($risco->riscoConsequencia, 80) !!}</td>
									@if($risco->riscoAvaliacao<=3)
									<td class = "mode bg-baixo riscoAvaliacao">{!! $risco->riscoAvaliacao !!}</td>
									@elseif ($risco->riscoAvaliacao <=14)
									<td class = "mode bg-medio riscoAvaliacao">{!! $risco->riscoAvaliacao !!}</td>
									@else
									<td class = "mode bg-alto riscoAvaliacao">{!! $risco->riscoAvaliacao !!}</td>
									@endif
									<td>{{ \Carbon\Carbon::parse($monitoramento->inicioMonitoramento)->format('d/m/Y') }}</td>
									<td>
										@if ($monitoramento->fimMonitoramento)
											{{ \Carbon\Carbon::parse($monitoramento->fimMonitoramento)->format('d/m/Y') }}
										@else
											Contínuo
										@endif
									</td>
								</tr>
							@endforeach
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>

	<footer class="rodape">
		<div class="riskLevelDiv">
			<span>Nível de Risco (Avaliação):</span>
			<span class="mode riskLevel1">Baixo</span>
			<span class="mode riskLevel2">Médio</span>
			<span class="mode riskLevel3">Alto</span>
		</div>
	</footer>

	<div class="modal fade" id="prazoModal" tabindex="-1" aria-labelledby="prazoModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="prazoModalLabel">Novo Prazo</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>

				<div class="modal-body">
					<form action="{{route('riscos.prazo')}}" id="prazoForm" method="POST">
						@csrf
						<div class="mb-3">
							<label for="data" class="form-label">Data:</label>
							<input type="date" class="form-control" id="data" name="data" required>
						</div>

						<div class="text-end mt-4">
							<button type="submit" class="btn btn-primary">Salvar Prazo</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

	<script>
		$(document).ready(function(){
			var table = $('#tableHome').DataTable({
				language: {
					url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/pt-BR.json',
						search: "Procurar:",
						lengthMenu: "Riscos: _MENU_",
						info: 'Mostrando página _PAGE_ de _PAGES_',
						infoEmpty: 'Sem relatórios de risco disponíveis para visualização',
						infoFiltered: '(Filtrados do total de _MAX_ relatórios)',
						zeroRecords: 'Nada encontrado. Se achar que isso é um erro, contate o suporte.',
						paginate: {
						next: "Próximo",
						previous: "Anterior"
						}
					},

				initComplete: function(){
					// CONTAINER QUE ALINHA TODOS NA MESMA LINHA
					var divContainer = $('<div class="divContainer" style="display: flex; justify-content: space-between;"></div>');

					// BOTÃO NA ESQUERDA
					var divButtonNewRisk = $('<div class="divButtonNewRisk"></div>');
					divButtonNewRisk.append($('#newRiskButtonDiv'));
					divContainer.append(divButtonNewRisk);

					// RELATÓRIOS E SEARCH BOX NA DIRETA
					var divSearchAndEntries = $('<div class="divSearchAndEntries"></div>');
					divSearchAndEntries.append($('.dataTables_length')).append($('.dataTables_filter'));
					divContainer.append(divSearchAndEntries);

					// CONTAINER NO TOPO DA TABELA
					$(table.table().container()).prepend(divContainer);
				}
			});

			table.on('draw', function(){

				// MANTÉM OS ELEMENTOS ALINHADO A CADA REFRESH
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
