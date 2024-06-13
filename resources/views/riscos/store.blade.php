@extends('layouts.app')
@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<style>

		.form_risco{
			border: solid 1px greenyellow;
			width: 100%;
			position: absolute;
			display: flex;
			align-items: center;
			justify-content: center;
		}
		.form_create{
			border: solid 1px red;
			display: flex;
			align-items: center;
			flex-direction: column;
			margin: 10px;
			padding: 10px;
			width: 20%;
		}
		.textInput{
			width: 100%;
			height: 10%;
		}
		.selection{
			margin: 10px;
		}
		@media screen and (max-width: 900px) {
			.form_risco{
				width: 100%;
			}
			.form_create{
				width: 75%;
			}
			.textInput{
				width: 100%;
			}
		}

	</style>
		<script>
		let cont = 0;

		function addMonitoramentos(){
			let controleSugerido = document.createElement('input');
			controleSugerido.setAttribute('type','text');
			controleSugerido.setAttribute(`name`,`monitoramentos[${cont}][monitoramentoControleSugerido]`);
			controleSugerido.setAttribute('placeholder','Monitoramento');
			controleSugerido.setAttribute('class','textInput');

			let statusMonitoramento = document.createElement('input');
			statusMonitoramento.type = `text`;
			statusMonitoramento.name = `monitoramentos[${cont}][statusMonitoramento]`;
			statusMonitoramento.placeholder = "Status do Monitoramento";
			statusMonitoramento.classList = "textInput";

      let execucaoMonitoramento = document.createElement('input');
      execucaoMonitoramento.setAttribute('type','text');
      execucaoMonitoramento.setAttribute('name',`monitoramentos[${cont}][execucaoMonitoramento]`);
      execucaoMonitoramento.setAttribute('placeholder','Execução do Monitoramento');
      execucaoMonitoramento.setAttribute('class','textInput');

			const br = document.createElement('br');


			let monitoramentosDiv = document.getElementById('formCreate');
			monitoramentosDiv.appendChild(controleSugerido);
			monitoramentosDiv.appendChild(statusMonitoramento);
      monitoramentosDiv.appendChild(execucaoMonitoramento);
			cont++;
		}

	</script>
	<title>Document</title>
</head>
<body>
	<div class="form_risco">
		<form action="{{route('riscos.store')}}" method="post" class="form_create" id="formCreate">
			@csrf
			<label for="name">Evento</label>
			<textarea type="text" name="riscoEvento" class="textInput" required></textarea>

			<label for="name">Causa</label>
			<textarea type="text" name="riscoCausa" class="textInput" required></textarea>

			<label for="name">Consequência</label>
			<textarea type="text" name="riscoConsequencia" class="textInput" required></textarea>

			<label for="name">Avaliação</label>
			<textarea type="text" name="riscoAvaliacao" class="textInput" required></textarea>

			<label for="name">Unidade</label>
			<select name="unidadeRiscoFK" class="selection" requireds>
				<option selected disabled>Selecione uma unidade</option>
				@foreach($unidades as $unidade )
					<option value="{{$unidade->id}}">{{$unidade->unidadeNome}}</option>
				@endforeach
			</select>
			<div id="monitoramentosDiv" class="monitoramento"></div>
			<input type="button" onclick="addMonitoramentos()" value="Adicionar Monitoramento"></input>

			<input type="submit" value="Salvar">

		</form>
	</div>

</body>
</html>

@endsection
