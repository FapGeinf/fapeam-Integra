@extends('layouts.app')
@section('title') {{ 'Lista de Diretorias' }} @endsection
@section('content')

<link rel="stylesheet" href="{{ asset('css/show.css') }}">
<link rel="stylesheet" href="{{ asset('css/tables.css') }}">
<link rel="stylesheet" href="{{ asset('css/buttons.css') }}">
<link rel="stylesheet" href="{{ asset('css/dropdown.css') }}">
<script src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>
<script src="{{ asset('js/dataTables.min.js') }}"></script>
<link rel="stylesheet" href="{{ asset('css/dataTables.dataTables.min.css') }}">
<script src="{{ asset('js/diretorias/diretoriasTable.js') }}"></script>
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
      <h5 class="text-center mb-1">Diretorias</h5>
      
      <div class="d-flex justify-content-center">
        <a class="text-decoration-none highlighted-btn-sm highlight-blue"
          href="{{ route('diretorias.create') }}">
          <i class="bi bi-plus-circle me-1"></i>
          Adicionar Diretoria
        </a>
      </div>
    </div>

    <div>
      <table id="diretorias-table" class="table table-bordered table-striped">
        <thead>
          <tr class="text13">
            <th class="text-center text-light">Sigla</th>
            <th class="text-center text-light">Nome da Diretoria</th>
            <th class="text-center text-light">Diretor Responsável</th>
            <th class="text-center text-light">Ações</th>
          </tr>
        </thead>

        <tbody>
          @foreach($diretorias as $diretoria)
            <tr class="text13">
              <td class="text-center">{{ $diretoria->diretoriaSigla }}</td>
              <td class="text-center">{{ $diretoria->diretoriaNome }}</td>
              <td class="text-center">{{ $diretoria->diretor ?? 'Não informado' }}</td>

              <td class="" style="width: 100px;">
                <div class="d-flex justify-content-center">
                  <a href="{{ route('diretorias.edit', $diretoria->id) }}"
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