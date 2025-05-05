@extends('layouts.app')

<script src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>
<script src="{{ asset('js/dataTables.min.js') }}"></script>
<link rel="stylesheet" href="{{ asset('css/dataTables.dataTables.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
<link rel="stylesheet" href="{{ asset('css/atividades.css') }}">

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
                <div class="row g-3 align-items-end">
                    <div class="table-responsive">
                        <table id="logsTable" class="table cust-datatable mb-5">
                            <thead>
                                <tr>
                                    <th>Acao</th>
                                    <th>Descricao</th>
                                    <th>Usuario</th>
                                    <th>Data</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($logs as $log)
                                    <tr>
                                        <td>{{ $log->acao }}</td>
                                        <td>{{ $log->descricao }}</td>
                                        <td>{{ $log->user->name }}</td>
                                        <!-- Assuming you have a relationship to the User model -->
                                        <td>{{ $log->created_at->format('d/m/Y H:i') }}</td>
                                        <!-- Assuming created_at is available -->
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            $('#logsTable').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.11.5/i18n/pt_br.json" // Adjust the language if necessary
                }
            });
        });
    </script>
@endsection