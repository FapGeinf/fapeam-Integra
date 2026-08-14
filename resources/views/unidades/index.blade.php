@extends('layouts.app')
@section('title') {{ 'Lista de Unidades' }} @endsection
@section('content')

<link rel="stylesheet" href="{{ asset('css/show.css') }}">
<link rel="stylesheet" href="{{ asset('css/tables.css') }}">
<link rel="stylesheet" href="{{ asset('css/buttons.css') }}">
<link rel="stylesheet" href="{{ asset('css/dropdown.css') }}">
<script src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>
<script src="{{ asset('js/dataTables.min.js') }}"></script>
<link rel="stylesheet" href="{{ asset('css/dataTables.dataTables.min.css') }}">
<script src="{{ asset('js/unidades/unidadesTable.js') }}"></script>
<script src="{{ asset('js/actionsDropdown.js') }}"></script>

<style>
  div.dt-container div.dt-layout-row {
    font-size: 13px;
  }
</style>

<x-alert-toast/>

<div class="container-xxl pt-5">
  <div class="col-12 border box-shadow">
    <div class="justify-content-center">
      <h5 class="text-center mb-1">Unidades</h5>
      
      <div class="d-flex justify-content-center mb-4">
        <a class="text-decoration-none highlighted-btn-sm highlight-blue"
          href="{{ route('unidades.create') }}">
          <i class="bi bi-plus-circle me-1"></i>
          Adicionar Unidade
        </a>
      </div>

      <div class="row justify-content-center mb-4">
        <div class="col-md-4">
          <label for="filter-tipo" class="form-label small fw-semibold text-secondary">Filtrar por Tipo de Unidade:</label>
          <select id="filter-tipo" class="form-select input-enabled border-grey pointer form-select-sm">
            <option value="">Todos os Tipos</option>
            @foreach($unidadesTipos as $tipo)
              <option value="{{ $tipo->unidadeTipoNome }}">{{ $tipo->unidadeTipoNome }}</option>
            @endforeach
          </select>
        </div>
      </div>

    </div>

    <div>
      <table id="unidades-table" class="table table-bordered table-striped">
        <thead>
          <tr class="text13">
            <th class="text-center text-light">Nome</th>
            <th class="text-center text-light">Sigla</th>
            <th class="text-center text-light">E-mail</th>
            <th class="text-center text-light">Tipo de Unidade</th>
            <th class="text-center text-light">Ações</th>
          </tr>
        </thead>

        <tbody>
          @foreach($unidades as $unidade)
            <tr class="text13">
              <td class="text-center">{{ $unidade->unidadeNome }}</td>
              <td class="text-center">{{ $unidade->unidadeSigla }}</td>
              <td class="text-center">{{ $unidade->unidadeEmail }}</td>
              <td class="text-center">{{ $unidade->unidadeTipo?->unidadeTipoNome ?? 'Não Informado' }}</td>

              <td class="" style="width: 100px;">
                <div class="d-flex justify-content-center">
                  <a href="{{ route('unidades.edit', $unidade->id) }}"
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