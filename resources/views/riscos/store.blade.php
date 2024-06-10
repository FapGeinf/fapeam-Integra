<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<style>
		/* *{
			border: solid 1px red;
		} */
		body{
			/* border: solid 1px red; */
			display: flex;
			justify-content: center;
			align-items: center;
		}
		.form_risco{
			width: 50%;
			display: flex;
			justify-content: center;
			align-items: center;
		}
		.form_create{
			display: flex;
			align-items: center;
			flex-direction: column;
			margin: 10px;
			padding: 10px;
			width: 75%;
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
	<script defer>
		let cont = 0;

		function addMonitoramentos(){
			let controleSugerido = document.createElement('input');
			controleSugerido.setAttribute('type','text');
			controleSugerido.setAttribute('name','monitoramentos['+cont+'][monitoramentoControleSugerido]');
			controleSugerido.setAttirbute('placeholder','Monitoramento');
			controleSugerido.setAttirbute('class','controle');
			

			let monitoramentosDiv = document.getElementById('monitoramentos');
			monitoramentosDiv.appendChild(contoleSugerido);

			cont++;
		}

	</script>
	<title>Document</title>
</head>
<body>
	<div class="form_risco">
		<input action="{{route('riscos.store')}}" method="post" class="form_create">
			@csrf 
			<label for="name">Evento</label>
			<textarea type="text" name="riscoEvento" class="textInput" required></textarea>
			
			<label for="name">Causa</label>
			<textarea type="text" name="riscoCausa" class="textInput" required></textarea>
			
			<label for="name">Consequência</label>
			<textarea type="text" name="riscoConsequencia" class="textInput" required></textarea>
			
			<label for="name">Avaliação</label>
			<textarea type="text" name="riscoAvaliacao" class="textInput" required></textarea>
		
			<label for="name">Unidades</label>
			<select name="unidadeRiscoFK" class="selection" requireds>
				<option selected disabled>Selecione uma unidade</option>
				@foreach($unidades as $unidade )
					<option value="{{$unidade->id}}">{{$unidade->unidadeNome}}</option>
				@endforeach
			</select>
			<input type="button" onclick="addMonitoramentos()" value="Adicionar Monitoramento"></input>
			<input type="submit" value="Salvar">

		</form>
	</div>

</body>
</html>