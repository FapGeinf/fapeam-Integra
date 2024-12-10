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
            <a href="{{ route('documentos.intro') }}" class="tooltip" data-tooltip="Voltar para HOME">
              <img src="{{ asset('img/house-icon-modified3.png') }}" alt="House Icon" style="margin-right: .5rem;">
            </a>
          
            <a href="{{ route('manual') }}" class="tooltip" data-tooltip="Manual do Sistema">
              <img src="{{ asset('img/manual-icon3.png') }}" alt="Manual Icon">
            </a>
          </div>
        </span>
      </div>
    </div>
  </header>

  <div class="central-text">

    <p>Bem-vindo(a) ao Sistema Íntegra!</p>

    <p class="noMB">
    O Sistema Íntegra é uma ferramenta do Programa de Integridade da Fundação de Amparo à Pesquisa do Estado do Amazonas – FAPEAM.
    Sua finalidade é aprimorar as rotinas e sistemas de controle interno preventivo e corretivo, buscando assegurar a legalidade, legitimidade, economicidade, eficiência, publicidade e transparência da gestão administrativa, proporcionando apoio à Alta Administração na gestão dos recursos públicos e ao atendimento às legislações vigentes.
    </p>

    <p class="noMT">
    Esta ferramenta acompanha as rotinas administrativas, com intuito de direcionar, monitorar e avaliar a efetividade do Programa de Integridade, conforme os eixos estabelecidos:
    </p>

    
    <ul>
        <li>I – Comprometimento e Apoio da Alta Direção;</li>
        <li>II – Institucionalização do Código de Conduta;</li>
        <li>III – Avaliação de Riscos;</li>
        <li>IV – Implementação de Controles Internos;</li>
        <li>V – Comunicação e Treinamentos Periódicos;</li>
        <li>VI – Canais de Denúncia;</li>
        <li>VII – Investigações Internas;</li>
        <li>VIII – Monitoramento Contínuo.</li>
    </ul>
    

    <p>
    Contamos com sua contribuição para prevenir, detectar e remediar fraudes e atos de corrupção em apoio à boa governança.
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
