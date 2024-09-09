@extends('layouts.app')

@section('title') {{'Apresentação'}} @endsection

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="{{asset('css/apresentacao.css')}}">
  <link rel="stylesheet" href="{{asset('css/removeGlobalConfig.css')}}">
</head>

@section('content')
<body>
  <div class="form-wrapper">
    <div class="box-shadow">

      <div class="textCenter pBottom1">
        <h2>Apresentação</h2>
      </div>

      <div class="textJustify pBottomHalf p1">
        Na administração pública há a necessidade de implantação de mecanismos de Governança, Transparência e Integridade. O Programa de Integridade é um conjunto estruturado de medidas institucionais voltadas para prevenção, detecção, punição e remediação de fraudes e atos de corrupção em apoio à boa governança.
      </div>

      <div class="textJustify pBottomHalf p2">
        Nos últimos anos,  a FAPEAM vem trabalhando na formulação de práticas sistêmicas e na construção de  programas e ferramentas, que  possibilitem o aprimoramento institucional e o fortalecimento do seu sistema de controle interno, implantando rotinas sistêmicas com vistas a maior eficiência e transparência dos seus atos.
      </div>

      <div class="textJustify pBottomHalf p3">
        Assim como no fomento de condutas de integridade e de ética de seus colaboradores, além de estabelecer mecanismos que possibilitam a prevenção de eventuais atos de corrupção, desvios de ética e de conduta, seguindo às recomendações das instâncias de controle interno e externo.
      </div>

      <div class="textJustify p4">
        O Sistema Íntegra é uma dessas ferramentas do Programa de Integridade e compliance para o acompanhamento das rotinas administrativas, com intuito de:  avaliar, direcionar e monitorar os riscos de integridade inerentes diagnosticados na instituição; instituir medidas preventivas de corrupção, fraudes e de quebra de integridade; aprimorar as rotinas  e sistemas de controle interno preventivo e corretivo, no que tange à aplicação da gestão de riscos, buscando assegurar a legalidade, legitimidade, economicidade, eficiência, publicidade e transparência da gestão administrativa, proporcionando apoio à Alta Administração na gestão dos recursos públicos e ao atendimento às legislações vigentes.
      </div>
      
    </div>
  </div>
</body>
@endsection
</html>