@extends('layouts.app')
@section('title') {{ 'Lista de Indicadores' }} @endsection
@section('content')

<link rel="stylesheet" href="{{ asset('css/show.css') }}">
<link rel="stylesheet" href="{{ asset('css/tables.css') }}">
<link rel="stylesheet" href="{{ asset('css/buttons.css') }}">
<link rel="stylesheet" href="{{ asset('css/dropdown.css') }}">
<script src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>
<script src="{{ asset('js/dataTables.min.js') }}"></script>
<link rel="stylesheet" href="{{ asset('css/dataTables.dataTables.min.css') }}">
<script src="{{ asset('js/indicadores/indicadoresTable.js') }}"></script>
<script src="{{ asset('js/actionsDropdown.js') }}"></script>

<style>
  div.dt-container div.dt-layout-row {
    font-size: 13px;
  }
</style>

<div class="container-xxl pt-5">
  <div class="col-12 border box-shadow">
    <div class="justify-content-center">
      <h5 class="text-center mb-1">Indicadores</h5>
      
      <div class="d-flex justify-content-center">
        <a class="text-decoration-none highlighted-btn-sm highlight-blue"
          href="{{ route('indicadores.create') }}">
          <i class="bi bi-plus-circle me-1"></i>
          Adicionar Indicador
        </a>
      </div>

    </div>

    <div>
      <table id="indicadores-table" class="table table-bordered table-striped">
        <thead>
          <tr class="text13">
            <th class="text-center text-light">N°</th>
            <th class="text-center text-light">Nome</th>
            <th class="text-center text-light">Objetivo do Indicador</th>
            <th class="text-center text-light">Eixo</th>
            <th class="text-center text-light">Ações</th>
          </tr>
        </thead>

        <tbody>
          @foreach($indicadores as $indicador)
            <tr class="text13">
              <td class="text-center">{{ $indicador->id }}</td>
              <td class="text-center">{{ $indicador->nomeIndicador }}</td>
              <td class="text-center">{!!$indicador->descricaoIndicador!!}</td>
              <td class="text-center">EIXO {{$indicador->eixo->id}} - {{ $indicador->eixo->nome}}</td>

              <td class="" style="width: 100px;">
                <div class="d-flex justify-content-center">
                  <a href="{{ route('indicadores.edit', $indicador->id) }}"
                    class="highlighted-btn-sm highlight-warning text-decoration-none">
                    <i class="bi bi-pencil"></i>
                  </a>                  
                </div>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>

<x-back-button/>
@endsection