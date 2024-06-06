<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<style>
		
	</style>
	<title>Document</title>
</head>
<body>
	<div class="form_risco">
		<form action="{{route('riscos.store')}}" method="post" >
			@csrf 
			<label for="name">Form 1</label>
			<input type="text" name="riscoEvento" id = "name" required>
			<label for="name">Form 1</label>
			<input type="text" name="riscoCausa" id = "name" required>
			<label for="name">Form 1</label>
			<input type="text" name="riscoConsequencia" id = "name" required>
			<label for="name">Form 1</label>
			<input type="text" name="riscoAvaliacao" id = "name" required>
			<label for="name">Form 1</label>

			<input type="text" name="unidadeRiscoFK" id = "name" required>
			<select name="unidadeRiscoFk" id="">
				<option selected>ARTIGOS</option>
				@foreach($unidades as $unidade )
					<option value="{{$unidade->id}}">{{$unidade->unidadeNome}}</option>
				@endforeach
			</select>
			<input type="submit" value="Subscribe">

		</form>
	</div>

</body>
</html>