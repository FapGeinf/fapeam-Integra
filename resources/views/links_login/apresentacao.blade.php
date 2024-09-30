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
    <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Dolor tempore soluta nisi tenetur optio impedit suscipit architecto dolore cupiditate nemo iure reprehenderit repudiandae, repellat cumque officia perspiciatis magnam delectus amet. Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptatem quidem iure rerum officiis autem odio impedit, neque voluptatum ipsam ullam molestias nobis sit earum, quibusdam magni laboriosam consequuntur suscipit enim modi ad sed at accusamus nihil</p>
    
    <p>
       perspiciatis. Repudiandae, aliquam quaerat, aperiam id quis nihil vitae soluta blanditiis modi tenetur rem eligendi, fugiat expedita iure autem aspernatur eaque. Repudiandae ut quia dolor, explicabo mollitia facilis nostrum quasi sunt pariatur consequatur atque rerum. Repudiandae laudantium qui quae eius cumque quod exercitationem quidem a! Eveniet, quidem aspernatur! Consequuntur perspiciatis facilis consectetur, iure dolor ratione, mollitia unde eum fugit harum perferendis ipsam, atque aliquid repellat magnam. Distinctio dignissimos, voluptatibus vitae repudiandae nobis iste. Velit sunt, dolor quae reiciendis <strong>vero quas incidunt asperiores quia consequatur et, tenetur cum laboriosam quidem quasi eius consectetur laborum, adipisci repellendus. Vel quod perferendis expedita quas facere veniam dolor maxime esse provident sequi tenetur odio, aliquam corrupti. Rem, libero est accusantium repellendus sequi eos excepturi, accusamus odit minus, iure non at architecto consectetur quas maxime iusto </strong> 
    </p>

    <p>
      suscipit <span style="font-weight: bold; color: #1d3055;">tempore repudiandae?</span> Ipsum ut necessitatibus, dolores deserunt pariatur ipsa inventore quod aliquid ex at? Mollitia similique incidunt et, facere quae vitae necessitatibus suscipit iure maiores porro, eum, at possimus corporis molestiae? Corrupti, quasi. Assumenda dolor itaque quas minus facilis, dolorum quos placeat iste reprehenderit quod laudantium consequatur veniam autem natus perspiciatis beatae magnam similique, aspernatur, illo odit temporibus velit? Asperiores commodi laudantium architecto velit tenetur. Ab consequuntur, ad quae adipisci vel numquam, officia porro tempora nemo est aut iure rem. Veniam nemo, quos voluptatem a soluta neque similique quam non ex praesentium numquam ducimus rem animi facere necessitatibus earum quae aut cumque sequi quisquam sed sapiente. Saepe laboriosam nobis deserunt. Veritatis harum eius ipsam saepe odio iusto, numquam molestias exercitationem voluptatum libero officiis dolor molestiae et sunt sint eligendi mollitia illum laborum quas? lorem40
    </p>
   
  </div>

  <script>
    function showTooltip(event) {
      const tooltipText = event.target.closest('a').getAttribute('data-tooltip');
      
      let tooltip = document.createElement('div');
      tooltip.classList.add('tooltip-container');
      tooltip.textContent = tooltipText;
      document.body.appendChild(tooltip);
    
      // Posiciona o tooltip perto do mouse
      const mouseX = event.pageX;
      const mouseY = event.pageY;
      tooltip.style.left = mouseX + 10 + 'px';
      tooltip.style.top = mouseY + 10 + 'px';
      
      tooltip.classList.add('show');
      event.target.tooltipElement = tooltip;
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
