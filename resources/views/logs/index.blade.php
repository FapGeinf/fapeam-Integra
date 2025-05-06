@extends('layouts.app')

<script src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>
<script src="{{ asset('js/dataTables.min.js') }}"></script>
<link rel="stylesheet" href="{{ asset('css/dataTables.dataTables.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
<link rel="stylesheet" href="{{ asset('css/atividades.css') }}">
<script src="{{ asset('js/logs/logsTable.js') }}"></script>

@section('title') {{ 'Lista de Logs' }} @endsection

@section('content')
    <div class="alert-container mt-5">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @elseif (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
    </div>

    <div class="container-fluid px__custom pt-4">
        <div class="col-12 border main-datatable">
            <div class="d-flex justify-content-center text-center p-2" style="flex-direction: column;">
                <span style="font-size:22px;">Lista de Logs</span>
            </div>
        </div>
    </div>

    <div class="container-fluid p-30">
        <div class="col-12 border main-datatable">
            <div class="container-fluid">

                <form action="{{ route('logs.relatorioPorDia') }}" method="POST" class="row g-3 align-items-end mb-4">
                    @csrf
                    <div class="col-md-4">
                        <label for="created_at" class="form-label">Selecione uma data:</label>
                        <input type="date" name="created_at" id="created_at" class="form-control" required>
                        @error('created_at')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary">Gerar Relatório</button>
                    </div>
                </form>

                <div class="row">
                    <div class="table-responsive">
                        <table id="logsTable" class="table cust-datatable mb-5">
                            <thead>
                                <tr>
                                    <th>Ação</th>
                                    <th>Descrição</th>
                                    <th>Usuário</th>
                                    <th>Data</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($logs as $log)
                                    <tr>
                                        <td>{{ $log->acao }}</td>
                                        <td>{{ $log->descricao }}</td>
                                        <td>{{ $log->user->name }}</td>
                                        <td>{{ $log->created_at->format('d/m/Y H:i') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
