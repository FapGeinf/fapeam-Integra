@extends('layouts.app')
@section('title') {{ 'Apresentação do Sistema' }} @endsection
@section('content')

<link rel="stylesheet" href="{{asset('css/main.css')}}">
<link rel="stylesheet" href="{{asset('css/buttons.css')}}">

<nav class="navbar navbar-expand-lg border-bottom sticky-top">
  <div class="container">
    <span class="navbar-brand text-white mb-0">Legislação</span>

    <div class="ms-auto d-flex align-items-center gap-2">
      <a href="{{ route('documentos.intro') }}"
        class="highlighted-btn-sm highlight-blue text-decoration-none">
        <img src="{{ asset('img/house-icon-modified3.png') }}" alt="Home" style="height:18px;width:auto;">
        Home
      </a>

      <a href="{{ route('manual') }}"
        class="highlighted-btn-sm highlight-blue text-decoration-none">
        <img src="{{ asset('img/manual-icon3.png') }}" alt="Manual" style="height:18px;width:auto;">
        Manual
      </a>
    </div>
  </div>
</nav>

<main class="container my-4 pt-5">
  <div class="card box-shadow">
    <div class="card-body p-2">
      <h1 class="h5 mb-3">Bem-vindo(a) ao Sistema Íntegra!</h1>

      <p class="mb-3">
        O Sistema Íntegra é uma ferramenta do Programa de Integridade da Fundação de Amparo à Pesquisa do Estado do Amazonas – FAPEAM.
      </p>

      <p class="mb-3">
        Sua finalidade é aprimorar as rotinas e sistemas de controle interno preventivo e corretivo, buscando assegurar a legalidade, legitimidade, economicidade, eficiência, publicidade e transparência da gestão administrativa, proporcionando apoio à Alta Administração na gestão dos recursos públicos e ao atendimento às legislações vigentes.
      </p>

      <p class="mb-3">
        Esta ferramenta acompanha as rotinas administrativas, com intuito de direcionar, monitorar e avaliar a efetividade do Programa de Integridade, conforme os eixos estabelecidos:
      </p>

      <ul class="mb-3 ps-3">
        <li class="mb-1">I – Comprometimento e Apoio da Alta Direção;</li>
        <li class="mb-1">II – Institucionalização do Código de Conduta;</li>
        <li class="mb-1">III – Avaliação de Riscos;</li>
        <li class="mb-1">IV – Implementação de Controles Internos;</li>
        <li class="mb-1">V – Comunicação e Treinamentos Periódicos;</li>
        <li class="mb-1">VI – Canais de Denúncia;</li>
        <li class="mb-1">VII – Investigações Internas;</li>
        <li>VIII – Monitoramento Contínuo.</li>
      </ul>

      <p>
        Contamos com sua contribuição para prevenir, detectar e remediar fraudes e atos de corrupção em apoio à boa governança.
      </p>
    </div>
  </div>
</main>
@endsection