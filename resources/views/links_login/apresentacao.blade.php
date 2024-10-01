<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="{{ asset('css/documents.css') }}">
  <link rel="shortcut icon" href="{{ asset('img/logoDeconWhiteMin.png') }}">
  <title>Íntegra | Apresentação</title>
</head>
<body>
  
  <header class="cabecalho">
    <div class="cabecalhoDiv">
      <div class="apresentacao">
        <span>Apresentação</span>
      </div>

      <div class="apresentacao2">
        <span class="mainData">
          <div>
            <a href="#" class="tooltip" data-tooltip="Voltar para HOME">
              <img src="{{ asset('img/house-icon-modified3.png') }}" alt="House Icon" style="margin-right: .5rem;">
            </a>
          
            <a href="#" class="tooltip" data-tooltip="Manual do Usuário">
              <img src="{{ asset('img/manual-icon3.png') }}" alt="Manual Icon">
            </a>
          </div>
        </span>
      </div>
    </div>
  </header>

  <div class="central-text">

    <p class="noMB">
      Na administração pública há a necessidade de implantação de mecanismos de Governança, Transparência e Integridade.
    </p>

    <p class="noMT">
      O <span>Programa de Integridade</span> é um conjunto estruturado de medidas institucionais voltadas para prevenção, detecção, punição e remediação de fraudes e atos de corrupção em apoio à boa governança.
    </p>

    <p>
      Nos últimos anos,  a <a href="https://www.fapeam.am.gov.br" target="_blank">Fapeam</a> vem trabalhando na formulação de práticas sistêmicas e na construção de  programas e ferramentas, que  possibilitem o aprimoramento institucional e o fortalecimento do seu sistema de controle interno, implantando rotinas sistêmicas com vistas a maior eficiência e transparência dos seus atos, assim como no fomento de condutas de integridade e de ética de seus colaboradores, além de estabelecer mecanismos que possibilitam a prevenção de eventuais atos de corrupção, desvios de ética e de conduta, seguindo às recomendações das instâncias de controle interno e externo.
    </p>

    <p>
      O <span>Sistema Íntegra</span> é uma dessas ferramentas do Programa de Integridade e compliance para o acompanhamento das rotinas administrativas, com intuito de:  avaliar, direcionar e monitorar os riscos de integridade inerentes diagnosticados na instituição; instituir medidas preventivas de corrupção, fraudes e de quebra de integridade; aprimorar as rotinas  e sistemas de controle interno preventivo e corretivo, no que tange à aplicação da gestão de riscos, buscando assegurar a legalidade, legitimidade, economicidade, eficiência, publicidade e transparência da gestão administrativa, proporcionando apoio à Alta Administração na gestão dos recursos públicos e ao atendimento às legislações vigentes.
    </p>
   
  </div>

  <script>// Função para criar o tooltip
    function showTooltip(event) {
      const tooltipText = event.target.closest('a').getAttribute('data-tooltip');
      
      let tooltip = document.createElement('div');
      tooltip.classList.add('tooltip-container');
      tooltip.textContent = tooltipText;
      document.body.appendChild(tooltip);
    
      // Posiciona o tooltip perto do mouse
      const mouseX = event.pageX;
      const mouseY = event.pageY;
      tooltip.style.left = mouseX + 10 + 'px';  // Ajuste a posição conforme necessário
      tooltip.style.top = mouseY + 10 + 'px';
      
      tooltip.classList.add('show');
      event.target.tooltipElement = tooltip;  // Armazena a referência para uso posterior
    }
    
    // Função para remover o tooltip
    function hideTooltip(event) {
      if (event.target.tooltipElement) {
        event.target.tooltipElement.remove();
        event.target.tooltipElement = null;
      }
    }
    
    // Adiciona os eventos de mouseover e mouseout
    document.querySelectorAll('.tooltip').forEach(function(elem) {
      elem.addEventListener('mouseover', showTooltip);
      elem.addEventListener('mouseout', hideTooltip);
      elem.addEventListener('mousemove', function(event) {
        if (event.target.tooltipElement) {
          const mouseX = event.pageX;
          const mouseY = event.pageY;
          event.target.tooltipElement.style.left = mouseX + 10 + 'px';
          event.target.tooltipElement.style.top = mouseY + 10 + 'px';
        }
      });
    });
    </script>

</body>
</html>
