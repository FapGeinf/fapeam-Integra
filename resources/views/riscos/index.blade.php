@extends('layouts.app')

@section('content')

@section('title') {{'Página Inicial'}} @endsection
<!DOCTYPE html>
<html lang="pt-BR">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="{{ asset('css/home.css')}}">
  <script src="https://code.jquery.com/jquery-3.5.1.js" defer></script>
  <script src="https://cdn.datatables.net/1.11.0/js/jquery.dataTables.min.js" defer></script>
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.14/css/jquery.dataTables.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>

  <div class="container-fluid p-30 pt-5">
    <div class="row">
      <div class="col-md-12 main-datatable">
        <div class="card_body">
          <div class="buttonNewRisk">
            <span class="glyphicon glyphicon-plus"></span>
            <a href="{{route('riscos.create')}}">
              Novo Relatório</a>
            </a>
          </div>

          <div class="container-fluid">
            <div class="overflow-x">
              <table style="width: 100%" id="relatoriosTable" class="table cust-datatable no-footer">
                <thead class="titles">
                  <tr>

                    <th style="min-width:65px;">Ano</th>
                    <th style="min-width:150px;">Unidade<br><span class="subtitles">(Especificidade)</span></th>
                    <th style="min-width:150px;">Responsável</th>
                    <th style="min-width:65px;">Evento de Risco Inerente<br><span class="subtitles">Causas/Consequências</span></th>
                    <th style="min-width:65px;">Classificação de Risco <br><span class="subtitles">RI(PxI)</span></th>
                    <th style="min-width:70px;">Controle Sugerido<br><span class="subtitles">Execução/Status</span></th>   
                    <th style="min-width:95px;">Avaliação<br><span class="subtitles">Recomendação</span></th>   
                       
                  </tr>
                </thead>

                <tbody>

                @foreach ($riscos as $risco)
                <tr>
                  <td>{{$risco->riscoEvento}}</td>
                  <td>{{$risco->riscoCausa}}</td>
                  <td>{{$risco->riscoConsequencia}}</td>
                  <td>{{$risco->riscoAvaliacao}}</td>
                  <td>{{$risco->unidade->unidadeNome}}</td>
                </tr>
                @endforeach

                <tr>
                  <td>2024</td>
                  <td>Unidade de Controle Interno - UCI</td>
                  <td>Luis Felipe dos Santos</td>
                  <td>Lorem, ipsum dolor sit amet consectetur adipisicing elit.</td>
                  <td style="color: red; font-weight:bold;">Alta</td>
                  <td>Lorem ipsum, dolor sit amet consectetur adipisicing elit.</td>
                  <td>Lorem ipsum dolor sit, amet consectetur adipisicing elit.</td>
                </tr>

                <tr>
                  <td>2024</td>
                  <td>Gerência de Informática - GEINF</td>
                  <td>Felipe Andrey</td>
                  <td>Lorem, ipsum dolor sit amet consectetur adipisicing elit.</td>
                  <td style="color: green; font-weight:bold;">Média</td>
                  <td>Lorem ipsum, dolor sit amet consectetur adipisicing elit.</td>
                  <td>Lorem ipsum dolor sit, amet consectetur adipisicing elit.</td>
                </tr>


                </tbody>
              </table>
            </div>
          </div>

        </div>
        
      </div>
      
    </div>
    
  </div>
	
  
  
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.14/js/jquery.dataTables.min.js"></script>
</body>
</html>
@endsection
