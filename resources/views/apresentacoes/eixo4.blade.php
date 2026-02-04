@extends('layouts.app')
@section('title') {{ 'Eixo IV - Implementação de Controles Internos' }} @endsection
@section('content')

<link rel="stylesheet" href="{{asset('css/main.css')}}">
<link rel="stylesheet" href="{{asset('css/buttons.css')}}">

<main class="container my-4 pt-5" style="max-width: 800px;">
  <h1 class="h5 mb-3 text-center">Eixo IV - Implementação de Controles Internos</h1>
  
  <div class="card box-shadow" style="margin-bottom: 15px;">
    <div class="card-body p-2">
      <div class="mb-0">
        <p class="lh-lg">
          O controle interno visa assegurar o cumprimento das diretrizes e o fortalecimento da cultura de compliance e integridade, além de agregar valor e contribuir para a melhoria das operações da FAPEAM, auxiliando no alcance dos objetivos e metas institucionais, a partir da abordagem sistemática para avaliar e melhorar a eficácia dos processos de governança e gerenciamento de riscos.
        </p>
      </div>
    </div>
  </div>
</main>

<div class="d-flex justify-content-center gap-2">
  <a href="{{ route('riscos.index') }}">
    <button class="highlighted-btn-sm highlight-blue">
      <i class="bi bi-box-arrow-in-up-right"></i>
      Análise do Risco
    </button>
  </a>

  @if(auth()->user()->unidade->unidadeTipoFK == 1 || auth()->user()->unidade->unidadeTipoFK == 3 || auth()->user()->unidade->unidadeTipoFK == 4)
    <a href="{{ route('relatorios.eixos', ['id' => 4]) }}" 
      class="highlighted-btn-sm highlight-blue text-decoration-none">
      <i class="bi bi-list-columns-reverse"></i>
      Relatório
    </a>    

    <form action="{{ route('atividades.index') }}" method="POST" class="d-inline">
      @csrf
      <input type="hidden" name="eixo_id" value="4">
      <button type="submit" class="highlighted-btn-sm highlight-blue">
        <i class="bi bi-file-text"></i>
        Atividades
      </button>
    </form>
  
    <form action="{{ route('indicadores.index') }}" method="POST" class="d-inline">
      @csrf
      <input type="hidden" name="eixo_id" value="4">
      <button type="submit" class="highlighted-btn-sm highlight-blue">
        <i class="bi bi-reception-4"></i>
        Indicadores
      </button>
    </form>
  @endif
</div>
@endsection