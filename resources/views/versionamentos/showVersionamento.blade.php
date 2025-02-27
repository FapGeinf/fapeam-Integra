@extends('layouts.app')

@section('content')
@php
    \Carbon\Carbon::setLocale('pt_BR'); // Define a localidade para português do Brasil
@endphp

<link rel="stylesheet" href="{{ asset('css/detalhesAtividade.css') }}">

@section('title') {{ 'Versionamentos' }} @endsection

<div class="margin-30">
    <div class="box margin-top-4 bg-white border-bottom-none mx-auto">
        <div class="row mt-3">
            <div class="text-center">
                <h3>Últimos Versionamentos</h3>
            </div>
            <div class="col-12 text-center fs-18">
                <table class="table table-bordered table-sm">
                    <thead>
                        <tr>
                            <th scope="col">Título</th>
                            <th scope="col">Descrição</th>
                            <th scope="col">Data</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($versionamentos as $versionamento)
                            <tr>
                                <td>{{ $versionamento->titulo }}</td>
                                <td>{{ $versionamento->descricao }}</td>
                                <td>{{ \Carbon\Carbon::parse($versionamento->created_at)->translatedFormat('d \d\e F \d\e Y') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="text-center mt-4">
        <a href="{{ url()->previous() }}" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Voltar</a>
    </div>
</div>

@endsection
