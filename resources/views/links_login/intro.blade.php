@extends('layouts.app')
@section('title', 'Início')
@section('content')

<link rel="stylesheet" href="{{asset('css/main.css')}}">
<link rel="stylesheet" href="{{asset('css/buttons.css')}}">
<link rel="stylesheet" href="{{asset('css/home.css')}}">

<div class="container d-flex flex-column justify-content-center align-items-center"
  style="min-height: 75vh;">

  <img src="{{ asset('img/login/ass-top.png') }}" alt="Logo Integra" class="img-top mt-5">

  <img src="{{ asset('img/login/logo_ajuste1.png') }}" alt="Logo Integra" class="logo-hero mt-5 mb-5">

  <div class="d-flex gap-3 flex-wrap justify-content-center mt-5">
    <a href="{{ route('apresentacao') }}" style="width: 150px;"
      class="highlighted-btn-sm highlight-blue text-center text-decoration-none fs-6">
      Apresentação
    </a>

    <a href="{{ route('legislacao') }}" style="width: 150px;"
      class="highlighted-btn-sm highlight-blue text-center text-decoration-none fs-6">
      Legislação
    </a>

    <a href="{{ route('manual') }}" style="width: 150px;"
      class="highlighted-btn-sm highlight-blue text-center text-decoration-none fs-6">
      Manual
    </a>
  </div>

  <img src="{{ asset('img/login/ass-footer.png') }}" class="img-bottom mt-5">
</div>
@endsection