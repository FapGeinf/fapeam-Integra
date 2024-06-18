@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<script src="/ckeditor/ckeditor.js" ></script>
	<link rel="stylesheet" href="{{ asset('css/store.css') }}">
	{{-- <script src="//cdn.ckeditor.com/4.18.0/basic/ckeditor.js"></script> --}}

	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

	<title>Document</title>
</head>
<body>


	<div class="container-xxl d-flex justify-content-center pt-5">
		<div class="col-12 col-md-8 col-lg-7 box-shadow pb-5">

      <div class="headerInfo">
        <h4>Riscos Inerentes</h4>
      </div>

      <div class="row p-1 boxForm"><!-- boxForm start -->
        <form action="{{route('riscos.store')}}" method="post" class="form_create" id="formCreate">
          @csrf
          <div class="row g-3">
            <div class="col-sm-12 col-md-8 selectUnidade">

            <label for="unidadeId">Unidade</label>
            <select name="unidadeId" class="selection" required>
                <option selected disabled>Selecione uma unidade</option>
                @foreach($unidades as $unidade)
                    <option value="{{ $unidade->id }}">{{ $unidade->unidadeNome }}</option>
                @endforeach
            </select>


            </div>

            <div class="col-sm-12 col-md-4">
              <label for="name">Insira o Ano:</label>
              <input type="date" id="" name="" class="form-control">
            </div>

            <div class="col-sm-12 col-md-8">
              <label class="dataLim" for="name">Responsável:</label>
              <div class="dateTime">
                <input type="text" name="" id="" class="textInput form-control" placeholder=" Ex: Fulano da Silva Pompeo">
              </div>
            </div>
					</div>

					<div class="row g-3 mt-1">
						<div class="col-sm-12 col-md-8">
							<label for="name">Evento de Risco Inerente:</label>
							<textarea type="text" name="riscoEvento" class="textInput" required></textarea>
						</div>
					</div>

					<div class="row g-3 mt-1">
						<div class="col-sm-12 col-md-8">
							<label for="name">Causa do Risco:</label>
							<textarea type="text" name="riscoCausa" class="textInput" required></textarea>
						</div>
					</div>

					<div class="row g-3 mt-1">
						<div class="col-sm-12 col-md-8">
							<label for="name">Causa da Consequência:</label>
							<textarea type="text" name="riscoConsequencia" class="textInput" required></textarea>
						</div>
					</div>


					<div class="row g-3 mt-1">
						<div class="col-sm-12 col-md-8">
							<label for="name">Probabilidade de Risco:</label>
							<select name="probabilidade_risco" id="probabilidade_risco">
                                    <option value="1">Baixo</option>
                                    <option value="3">Médio</option>
                                    <option value="5">Alto</option>
                            </select>
						</div>
					</div>

                    <div class="row g-3 mt-1">
						<div class="col-sm-12 col-md-8">
							<label for="impacto_risco">Impacto do Risco:</label>
							<select name="impacto_risco" id="impacto_risco">
                                    <option value="1">Baixo</option>
                                    <option value="3">Médio</option>
                                    <option value="5">Alto</option>
                            </select>
						</div>
					</div>

					@php
                        $classe_risco = '';

                        if ($risco->riscoAvaliacao <= 3) {
                            $classe_risco = 'risco-baixo';
                        } elseif ($risco->riscoAvaliacao > 3 && $risco->riscoAvaliacao <= 14) {
                            $classe_risco = 'risco-medio';
                        } else {
                            $classe_risco = 'risco-alto';
                        }
                    @endphp

                    <div class="row g-3 mt-1">
                        <div class="col-sm-12 col-md-8">
                            <label for="name">Avaliação:</label>
                            <div class="{{ $classe_risco }}">
                                Risco calculado: {{ $risco->riscoAvaliacao }}
                            </div>
                        </div>
                    </div>

					{{-- <div class="row g-3 mt-1">
						<div class="col-sm-12 col-md-8">
							<select name="unidadeRiscoFK" class="selection" requireds>
								<option selected disabled>Selecione uma unidade</option>
								@foreach($unidades as $unidade )
									<option value="{{$unidade->id}}">{{$unidade->unidadeNome}}</option>
								@endforeach
							</select>
						</div>
					</div> --}}

					<div id="monitoramentosDiv" class="monitoramento"></div>
				<input type="button" onclick="addMonitoramentos()" value="Adicionar Monitoramento"></input>

				<input type="submit" value="Salvar">

        </form>
      </div><!-- boxForm end -->

		{{-- <div class="form_risco">
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

				<label for="name">Unidades</label>
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
		</div>	 --}}

		</div>
	</div>

	<script>
		CKEDITOR.replace('riscoEvento');
		CKEDITOR.replace('riscoCausa');
		CKEDITOR.replace('riscoConsequencia');
		// CKEDITOR.replace('riscoAvaliacao');
	</script>

	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>


        </form>
    </div>

    <script>
        let cont = 0;

        function addMonitoramentos() {
            let controleSugerido = document.createElement('input');
            controleSugerido.type = 'text';
            controleSugerido.name = `monitoramentos[${cont}][monitoramentoControleSugerido]`;
            controleSugerido.placeholder = 'Monitoramento';
            controleSugerido.classList = 'textInput';
            controleSugerido.value = ''; // Defina o valor padrão aqui se necessário

            let statusMonitoramento = document.createElement('input');
            statusMonitoramento.type = 'text';
            statusMonitoramento.name = `monitoramentos[${cont}][statusMonitoramento]`;
            statusMonitoramento.placeholder = 'Status do Monitoramento';
            statusMonitoramento.classList = 'textInput';
            statusMonitoramento.value = ''; // Defina o valor padrão aqui se necessário

            let execucaoMonitoramento = document.createElement('input');
            execucaoMonitoramento.type = 'text';
            execucaoMonitoramento.name = `monitoramentos[${cont}][execucaoMonitoramento]`;
            execucaoMonitoramento.placeholder = 'Execução do Monitoramento';
            execucaoMonitoramento.classList = 'textInput';
            execucaoMonitoramento.value = ''; // Defina o valor padrão aqui se necessário

            let monitoramentosDiv = document.getElementById('monitoramentosDiv');
            monitoramentosDiv.appendChild(controleSugerido);
            monitoramentosDiv.appendChild(statusMonitoramento);
            monitoramentosDiv.appendChild(execucaoMonitoramento);
            cont++;
        }
    </script>
</body>
</html>
@endsection
