@extends('layouts.app')

@section('title') {{ 'Histórico' }} @endsection

@section('content')

<head>
  <link rel="stylesheet" href="{{ asset('css/historico.css') }}">

  <style>
    .liDP {
          margin-left: 0 !important;
        }
      </style>
</head>

<div class="form-wrapper pt-5">
  <div class="form_create border">
    <h5 class="text-center mb-5">Documentos do Programa de Integridade</h5>

    <div class="dropdown-container">
      <button class="dropdown-button form-select" onclick="toggleDropdown('dropdownMenu1')">
        Memorandos
      </button>
      <div class="dropdown-content1" id="dropdownMenu1">
        <!-- <a class="link" href="#">2019</a> -->
        <!-- <a class="link" href="#">2020</a> -->
        <!-- <a class="link" href="#">2021</a> -->
        <!-- <a class="link" href="#">2022</a> -->
        <a class="link" href="#">2023</a>
        <a class="link" href="#">2024</a>
        <a class="link" href="#">2025</a>
      </div>
    </div>

    <div class="dropdown-container mt-4">
      <button class="dropdown-button form-select" onclick="toggleDropdown('dropdownMenu2')">
        Ofícios
      </button>
      <div class="dropdown-content1" id="dropdownMenu2">
        <!-- <a class="link" href="#">2019</a> -->
        <!-- <a class="link" href="#">2020</a> -->
        <!-- <a class="link" href="#">2021</a> -->
        <!-- <a class="link" href="#">2022</a> -->
        <a class="link" href="#">2023</a>
        <a class="link" href="#">2024</a>
        <a class="link" href="#">2025</a>
      </div>
    </div>

    <div class="dropdown-container mt-4">
      <button class="dropdown-button form-select" onclick="toggleDropdown('dropdownMenu3')">
        Processos
      </button>
      <div class="dropdown-content1" id="dropdownMenu3">
        <!-- <a class="link" href="#">2019</a> -->
        <!-- <a class="link" href="#">2020</a> -->
        <!-- <a class="link" href="#">2021</a> -->
        <!-- <a class="link" href="#">2022</a> -->
        <a class="link" href="#">2023</a>
        <a class="link" href="#">2024</a>
        <a class="link" href="#">2025</a>
      </div>
    </div>

    <div class="dropdown-container mt-4">
      <button class="dropdown-button form-select" onclick="toggleDropdown('dropdownMenu4')">
        Outros
      </button>
      <div class="dropdown-content1" id="dropdownMenu4">
        <!-- <a class="link" href="#">2019</a> -->
        <!-- <a class="link" href="#">2020</a> -->
        <!-- <a class="link" href="#">2021</a> -->
        <!-- <a class="link" href="#">2022</a> -->
        <a class="link" href="#">2023</a>
        <a class="link" href="#">2024</a>
        <a class="link" href="#">2025</a>
      </div>
    </div>
  </div>
</div>

<x-back-button/>

<script>
  function toggleDropdown(menuId) {
    var dropdown = document.getElementById(menuId);
    if (dropdown.classList.contains("show")) {
      dropdown.classList.remove("show");
    } else {
      dropdown.classList.add("show");
    }
  }

  // Fecha todos os dropdowns se o usuário clicar fora
  // window.onclick = function(event) {
  //   if (!event.target.matches('.dropdown-button')) {
  //     var dropdowns = document.getElementsByClassName("dropdown-content1");
  //     for (var i = 0; i < dropdowns.length; i++) {
  //       var openDropdown = dropdowns[i];
  //       if (openDropdown.classList.contains('show')) {
  //         openDropdown.classList.remove('show');
  //       }
  //     }
  //   }
  // }
</script>

@endsection