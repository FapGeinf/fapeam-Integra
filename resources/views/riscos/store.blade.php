@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<script src="/ckeditor/ckeditor.js" ></script>
	<link rel="stylesheet" href="{{ asset('css/store.css') }}">
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
                            <label for="probabilidade_risco">Probabilidade de Risco:</label>
                            <select name="probabilidade_risco" id="probabilidade_risco" required onchange="calculateRiscoAvaliacao()">
                                <option value="1">Baixo</option>
                                <option value="3">Médio</option>
                                <option value="5">Alto</option>
                            </select>
                        </div>
                    </div>

                    <div class="row g-3 mt-1">
                        <div class="col-sm-12 col-md-8">
                            <label for="impacto_risco">Impacto do Risco:</label>
                            <select name="impacto_risco" id="impacto_risco" required onchange="calculateRiscoAvaliacao()">
                                <option value="1">Baixo</option>
                                <option value="3">Médio</option>
                                <option value="5">Alto</option>
                            </select>
                        </div>
                    </div>

                    <input type="hidden" name="riscoAvaliacao" id="riscoAvaliacao">



				<div id="monitoramentosDiv" class="monitoramento"></div>
				<input type="button" onclick="addMonitoramentos()" value="Adicionar Monitoramento"></input>
				<input type="submit" value="Salvar">

        </form>
      </div><!-- boxForm end -->
		</div>
	</div>

	<script>
		CKEDITOR.replace('riscoEvento');
		CKEDITOR.replace('riscoCausa');
		CKEDITOR.replace('riscoConsequencia');
	</script>

	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <script>
        let cont = 0;

        function addMonitoramentos() {
            let monitoramentosDiv = document.getElementById('monitoramentosDiv');

            let controleSugerido = document.createElement('textarea');
            controleSugerido.name = `monitoramentos[${cont}][monitoramentoControleSugerido]`;
            controleSugerido.placeholder = 'Monitoramento';
            controleSugerido.classList = 'textInput';
            controleSugerido.id = `monitoramentoControleSugerido${cont}`;

            let statusMonitoramento = document.createElement('input');
            statusMonitoramento.type = 'text';
            statusMonitoramento.name = `monitoramentos[${cont}][statusMonitoramento]`;
            statusMonitoramento.placeholder = 'Status do Monitoramento';
            statusMonitoramento.classList = 'textInput';

            let execucaoMonitoramento = document.createElement('input');
            execucaoMonitoramento.type = 'text';
            execucaoMonitoramento.name = `monitoramentos[${cont}][execucaoMonitoramento]`;
            execucaoMonitoramento.placeholder = 'Execução do Monitoramento';
            execucaoMonitoramento.classList = 'textInput';

            monitoramentosDiv.appendChild(controleSugerido);
            monitoramentosDiv.appendChild(statusMonitoramento);
            monitoramentosDiv.appendChild(execucaoMonitoramento);

            CKEDITOR.replace(`monitoramentoControleSugerido${cont}`);
            cont++;
        }

        function calculateRiscoAvaliacao() {
            const probabilidade = document.getElementById('probabilidade_risco').value;
            const impacto = document.getElementById('impacto_risco').value;
            const avaliacao = probabilidade * impacto;
            document.getElementById('riscoAvaliacao').value = avaliacao;
        }

    </script>
</body>
</html>
@endsection
