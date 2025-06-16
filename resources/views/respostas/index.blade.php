@extends('layouts.app')
<script src="{{asset('js/jquery-3.6.0.min.js') }}"></script>
<script src="{{ asset('js/dataTables.min.js') }}"></script>
<link rel="stylesheet" href="{{ asset('css/dataTables.dataTables.min.css')}}">
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
<script src="{{ asset('js/respostas/tableRespostas.js') }}"></script>
@section('content')
    <div class="container-fluid pt-5 p-30">
        @if (session('success'))
            <div class="alert alert-success text-center auto-dismiss">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger text-center auto-dismiss">
                {{ session('error') }}
            </div>
        @endif

        <div class="col-12 border main-datatable">
            <div class="container-fluid">
                <div class="row g-3">
                    <div class="text-center my-4">
                        <h3 class="fw-bold mb-2" style="color: #333; text-shadow: 1px 1px 2px #ccc;">Painel de Providências
                        </h3>
                        <div
                            style="width: 120px; height: 4px; background-color: #ff9800; margin: 0 auto; border-radius: 2px;">
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="filter-unidade" class="fw-bold">Unidades:</label>
                        <select name="filter-unidade" id="filter-unidade" class="form-select pointer">
                            <option value="">Selecione uma Unidade</option>
                            @foreach ($unidades as $unidade)
                                <option value="{{ $unidade->unidadeSigla }}">{{ $unidade->unidadeSigla }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="table-responsive">
                    <table id="respostasTable" class="table cust-datatable">
                        <thead>
                            <tr class="text-center fw-bold">
                                <th>Usuário</th>
                                <th>Unidade</th>
                                <th>Providência</th>
                                <th>Status do Controle Sugerido</th>
                                <th>Anexo</th>
                                <th>Homologação da Diretoria</th>
                                <th>Homologação da Presidência</th>
                                <th>Homologação Completa</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($respostas as $resposta)
                                <tr>
                                    <td class="text-center">{{ $resposta->user->name }}</td>
                                    <td class="text-center">{{ $resposta->monitoramento->risco->unidade->unidadeSigla }}</td>
                                    <td class="text-center">{!! $resposta->respostaRisco !!}</td>
                                    <td class="text-center">{{ $resposta->monitoramento->statusMonitoramento }}</td>
                                    <td class="text-center">
                                        @if ($resposta->anexo)
                                            <a href="{{ asset('storage/' . $resposta->anexo) }}" target="_blank">
                                                {{ basename($resposta->anexo) }}
                                            </a>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>{{ $resposta->homologadoDiretoria }}</td>
                                    <td>{{ $resposta->homologadaPresidencia }}</td>
                                    <td>{{ $resposta->homologacaoCompleta ? 'Completa' : 'Incompleta' }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('riscos.respostas', $resposta->monitoramento->id) }}"
                                            class="btn btn-primary btn-md">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection