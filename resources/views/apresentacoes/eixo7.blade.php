@extends('layouts.app')
@section('title') {{ 'Eixo VII -  Investigações Internas' }} @endsection
@section('content')

<link rel="stylesheet" href="{{asset('css/main.css')}}">
<link rel="stylesheet" href="{{asset('css/buttons.css')}}">

<main class="container my-4 pt-5" style="max-width: 800px;">
  <h1 class="h5 mb-3 text-center">Eixo VII -  Investigações Internas</h1>
  
  <div class="card box-shadow" style="margin-bottom: 15px;">
    <div class="card-body p-2">
      <div class="mb-0">
        <p class="lh-lg">
          As investigações internas são indispensáveis para construção de uma cultura de integridade, objetivando
          verificar a ocorrência de materialidade e autoria de casos de conduta ilegal ou contra as políticas da FAPEAM,
          identificar as partes envolvidas e aplicar sanções cabíveis e adotar medidas de remediação para evitar a
          ocorrência de atos similares, em atenção ao disposto na IN N° 02/2022-CGE/AM.
        </p>

        <p class="lh-lg">
          A FAPEAM aprovou, por meio da Resolução 034/2023-CD/FAPEAM, o Manual Prático de Sindicância Disciplinar, que é
          um documento orientador, elaborado com base nos preceitos constitucionais, nas Leis Estaduais Nº 1.762/1986 e
          Nº 8.112/1990 e no Manual de Processo Administrativo Disciplinar da Controladoria Geral da União (CGU, Ed.
          2021).
        </p>
      </div>
    </div>
  </div>
</main>

@if(auth()->user()->unidade->unidadeTipoFK == 1 || auth()->user()->unidade->unidadeTipoFK == 3 || auth()->user()->unidade->unidadeTipoFK == 4)
  <div class="d-flex justify-content-center gap-2">
    <a href="{{ route('relatorios.eixos', ['id' => 7]) }}" 
      class="highlighted-btn-sm highlight-blue text-decoration-none">
      <i class="bi bi-download"></i>
      Relatório
    </a>

    <a href="{{ route('atividades.index', ['eixo_id' => 7]) }}">
      <button class="highlighted-btn-sm highlight-blue">
        <i class="bi bi-file-text"></i>
        Atividades
      </button>
    </a>

    <form action="{{ route('indicadores.index') }}" method="POST" class="d-inline">
      @csrf
      <input type="hidden" name="eixo_id" value="7">
      <button type="submit" class="highlighted-btn-sm highlight-blue">
        <i class="bi bi-reception-4"></i>
        Indicadores
      </button>
    </form>
  </div>
@endif

@endsection