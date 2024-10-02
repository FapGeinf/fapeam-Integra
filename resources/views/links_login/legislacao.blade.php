<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="{{ asset('css/documents.css') }}">
  <link rel="shortcut icon" href="{{ asset('img/logoDeconWhiteMin.png') }}">
  <title>Íntegra | Legislação</title>
</head>
<body>
  
  <header class="cabecalho">
    <div class="cabecalhoDiv">
      <div class="apresentacao">
        <span>Legislação</span>
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
      1. Portaria da Controladoria Geral da União - CGU N.° 1.089, DE 25 DE ABRIL DE 2018. Estabelece orientações para os órgãos e as entidades da administração pública federal direta, autarquias e fundacional, adotem procedimentos para estruturação, a execução e o monitoramento de seus programas de integridade e dá outras providências.
    </p>

    <p class="noMT">
      2. INSTRUÇÃO NORMATIVA Nº 02, DE 28 DE NOVEMBRO DE 2022. Dispõe sobre as diretrizes a serem observadas na implementação do Programa de Integridade, no âmbito dos órgãos e das entidades da Administração Pública Estadual Direta e Indireta, e dá outras providências.
    </p>

    <p>
      3. INSTRUÇÃO NORMATIVA Nº 03, DE 28 DE NOVEMBRO DE 2022. Disciplina os procedimentos para a implantação do Programa de Integridade de fornecedores, no âmbito do Poder Executivo do Estado do Amazonas e dá outras providências.
    </p>

    <p>
      4. DECRETO N.° 4.849, DE 14 DE OUTUBRO DE 2019. Disciplina a Política de Governança e Gestão do Estado do Amazonas e dá outras providências.
    </p>

    <p>
      5. DECRETO N.° 42.873, DE 14 DE OUTUBRO DE 2020. INSTITUI a Unidade de Controle Interno - UCI, no âmbito da Fundação de Amparo à Pesquisa do Estado do Amazonas - FAPEAM, estabelece diretrizes para sua estruturação e funcionamento e dá outras providências.
    </p>

    <p>
      6. Manual de Condutas Éticas e de Integridade da FAPEAM <a href="https://www.fapeam.am.gov.br/wpcontent/uploads/2024/01/manual_de_conduta_atualizado_08012024.pdf" target="_blank">https://www.fapeam.am.gov.br/wpcontent/uploads/2024/01/manual_de_conduta_atualizado_08012024.pdf</a>
    </p>

    <p>
      7. Manual Prático de Sindicância Disciplinar da FAPEAM <a href="https://www.fapeam.am.gov.br/wp-content/uploads/2024/01/Manual-Pratico-de-Sindicancia-Disciplinar-da-FAPEAM.pdf" target="_blank">https://www.fapeam.am.gov.br/wp-content/uploads/2024/01/Manual-Pratico-de-Sindicancia-Disciplinar-da-FAPEAM.pdf</a>
    </p>

    <p>
      8. Declaração de Posicionamento do Instituto Internacional de Auditores- IIA: As três linhas de defesa. Ano 2013
    </p>

    <p>
      9. Declaração de Posicionamento do Instituto Internacional de Auditores- IIA: As três linhas de defesa: Uma atualização das três linhas. Ano 2020.
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
