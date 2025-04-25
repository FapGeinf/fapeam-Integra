@extends('layouts.guest')
@section('content')
  <link href="{{ asset('css/dataTables.dataTables.min.css') }}" rel="stylesheet" />
  <script src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>
  <script src="{{ asset('js/dataTables.min.js') }}"></script>
  <link rel="stylesheet" href="{{ asset('css/index.css') }}">
  <script src="{{ asset('js/versionamentos/showVersionamentos.js') }}"></script>
  <style>
    ul {
    list-style-type: disc;
    }

    ul li {
    margin-bottom: 3px;
    }
  </style>
  @section('title') {{'Changelog'}} @endsection

  <div class="d-flex align-items-center justify-content-center mt-5 mb-5">
    <div class="row justify-content-center" style="max-width: 900px;">

    <div class="col-md-12">
      <div class="card shadow-sm border-1"
      style="border-bottom-left-radius: 0 !important; border-bottom-right-radius: 0 !important;">

      <div class="card-header">
        <h2 class="fw-bold text-center p-2">Lançamentos do sistema</h2>
      </div>

      {{-- <div class="row g-3 gap-3 px-3 py-2 mb-4">
        <div class="col-md-6">
        <label for="filter-data" class="fw-bold">Ordenar por Data Prevista</label>
        <select name="filter-data" id="filter-data" class="form-select pointer">
          <option value="asc">Mais Antiga</option>
          <option value="desc">Mais Recente</option>
        </select>
        </div>
      </div> --}}

      <div class="ms-5">
        @if (session('warning'))
      <div class="alert alert-warning">
      {{ session('warning') }}
      </div>
    @endif

        @if ($errors->any())
      <div class="alert alert-danger">
      <ul>
        @foreach ($errors->all() as $error)
      <li>{{ $error }}</li>
    @endforeach
      </ul>
      </div>
    @endif

        @if (session('success'))
      <div class="alert alert-success">
      {{ session('success') }}
      </div>
    @endif

        <ul class=" mt-3 mb-3" id="versionamentosList">
        {{-- @foreach ($versionamentos as $versionamento) --}}
        <h4>Mudanças de Março, 2025</h4>
        {{-- <h4>{{ $versionamento->titulo }}</h4>--}}
        {{-- <span>{{ \Carbon\Carbon::parse($versionamento->created_at)->format('d/m/Y') }}</span> --}}

        {{--<li class="ms-3">
          <p>{!! $versionamento->descricao !!}</p>
        </li>--}}

        <li class="ms-3">
          Lorem, ipsum dolor sit amet consectetur adipisicing elit. Sequi, quaerat!
        </li>

        <li class="ms-3">Lorem ipsum dolor sit amet consectetur adipisicing elit. Placeat recusandae assumenda
          debitis ab quasi in!</li>

        <li class="ms-3">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nemo a quae molestias quia
          deleniti pariatur laudantium aspernatur nam. Esse, illum?</li>
        {{-- @endforeach --}}
        </ul>
      </div>
      </div>
    </div>

    <x-back-button />

    </div>
  </div>
@endsection