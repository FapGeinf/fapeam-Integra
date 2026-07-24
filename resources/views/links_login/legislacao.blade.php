@extends('layouts.app')
@section('title') {{ 'Legislação' }} @endsection
@section('content')

<link rel="stylesheet" href="{{asset('css/main.css')}}">
<link rel="stylesheet" href="{{asset('css/buttons.css')}}">

{{-- <nav class="navbar navbar-expand-lg border-bottom sticky-top">
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
</nav> --}}

<main class="container my-4 pt-5">
  <div class="card box-shadow">
    <div class="card-body p-2">
      <h1 class="h5 mb-3">Normativos e documentos</h1>

      <ol class="mb-0 ps-3">
        <li class="mb-3 intro">
          Portaria da Controladoria Geral da União - CGU N.° 1.089, DE 25 DE ABRIL DE 2018. Estabelece orientações
          para os órgãos e as entidades da administração pública federal direta, autarquias e fundacional, adotem
          procedimentos para estruturação, a execução e o monitoramento de seus programas de integridade e dá outras
          providências.
        </li>

        <li class="mb-3 intro">
          INSTRUÇÃO NORMATIVA Nº 02, DE 28 DE NOVEMBRO DE 2022. Dispõe sobre as diretrizes a serem observadas na
          implementação do Programa de Integridade, no âmbito dos órgãos e das entidades da Administração Pública
          Estadual Direta e Indireta, e dá outras providências.
        </li>

        <li class="mb-3 intro">
          INSTRUÇÃO NORMATIVA Nº 03, DE 28 DE NOVEMBRO DE 2022. Disciplina os procedimentos para a implantação do
          Programa de Integridade de fornecedores, no âmbito do Poder Executivo do Estado do Amazonas e dá outras
          providências.
        </li>

        <li class="mb-3 intro">
          DECRETO N.° 4.849, DE 14 DE OUTUBRO DE 2019. Disciplina a Política de Governança e Gestão do Estado do
          Amazonas e dá outras providências.
        </li>

        <li class="mb-3 intro">
          DECRETO N.° 42.873, DE 14 DE OUTUBRO DE 2020. INSTITUI a Unidade de Controle Interno - UCI, no âmbito da
          Fundação de Amparo à Pesquisa do Estado do Amazonas - FAPEAM, estabelece diretrizes para sua estruturação
          e funcionamento e dá outras providências.
        </li>

        <li class="mb-3 intro">
          Manual de Condutas Éticas e de Integridade da FAPEAM
          <a class="link-primary text-break"
              href="https://www.fapeam.am.gov.br/wpcontent/uploads/2024/01/manual_de_conduta_atualizado_08012024.pdf"
              target="_blank" rel="noopener">
            https://www.fapeam.am.gov.br/wpcontent/uploads/2024/01/manual_de_conduta_atualizado_08012024.pdf
          </a>
        </li>

        <li class="mb-3 intro">
          Manual Prático de Sindicância Disciplinar da FAPEAM
          <a class="link-primary text-break"
              href="https://www.fapeam.am.gov.br/wp-content/uploads/2024/01/Manual-Pratico-de-Sindicancia-Disciplinar-da-FAPEAM.pdf"
              target="_blank" rel="noopener">
            https://www.fapeam.am.gov.br/wp-content/uploads/2024/01/Manual-Pratico-de-Sindicancia-Disciplinar-da-FAPEAM.pdf
          </a>
        </li>

        <li class="mb-3 intro">
          Declaração de Posicionamento do Instituto Internacional de Auditores - IIA: As três linhas de defesa. Ano 2013.
        </li>

        <li class="mb-3 intro">
          Declaração de Posicionamento do Instituto Internacional de Auditores - IIA: As três linhas de defesa: Uma atualização das três linhas. Ano 2020.
        </li>

        <li class="mb-0 intro">
          Decreto n° 50.868, de 12 de dezembro de 2024, que institui o Programa Estadual de Integridade no âmbito da
          Administração Pública Direta e Indireta do Poder Executivo do Estado do Amazonas, e dá outras providências.
        </li>
      </ol>
    </div>
  </div>
</main>

@endsection