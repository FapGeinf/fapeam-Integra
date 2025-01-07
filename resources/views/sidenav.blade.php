
<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{ asset('css/global.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <!-- O CSS ESTÁ DESATIVADA A PEDIDO DE RESPONSÁVEL MAIOR. FAVOR, NÃO APAGAR! -->
    {{-- <style>
        /* Defina a largura inicial da sidenav para garantir que ela carregue fechada */
        #appSidenav {
            width: 4rem;
            /* Inicia recolhida */
            transition: width 0.3s ease;
            /* Animação suave para abertura/fechamento */
            overflow: hidden;
            /* Para esconder o conteúdo quando a sidenav está recolhida */
        }

        .appContent,
        #toggleSidenav {
            /* margin-left: 4rem;  O conteúdo também deve iniciar deslocado */
            transition: margin-left 0.3s;
            /* Animação suave */
        }

        .hide-sidenav #appSidenav {
            display: none; /* Esconde completamente a sidenav */
        }

        .hide-sidenav .appContent {
            margin-left: 0; /* Remove o deslocamento do conteúdo */
        }

    </style> --}}
</head>

<!-- A FUNÇÃO ESTÁ DESATIVADA A PEDIDO DE RESPONSÁVEL MAIOR. FAVOR, NÃO APAGAR! -->
{{-- <script>
    document.addEventListener('DOMContentLoaded', function () {
        const bodyClass = document.body.classList.contains('page-with-filters');
        const removeSNItens = document.body.classList.contains('changePassword');
        const sidenav = document.getElementById("appSidenav");
        const imgElement = document.querySelectorAll('#logoMin');
        const fullLogoElement = document.querySelectorAll('#logoMax');
        const appContent = document.getElementsByClassName('appContent')[0];
        const marginLeft1 = document.querySelector('.marginLeft1');
        const textFilter = document.querySelector('.textFilter');
        const searchDivs = document.querySelectorAll('#searchDiv');
        const toggleButton = document.querySelector("#toggleSidenav");
        const welcomeDiv = document.getElementById('welcome'); // Seleciona a div #welcome

        

        // Configuração inicial
        if (bodyClass) {
            sidenav.style.width = "255px";
            appContent.style.marginLeft = "255px";
            imgElement.forEach(img => img.style.display = "none");
            fullLogoElement.forEach(img => img.style.display = "block");
            // Removido: toggleButton.style.left = "200px";

            if (marginLeft1) {
                marginLeft1.style.marginLeft = '15px';
            }
        } else {
            sidenav.style.width = "4rem";
            appContent.style.marginLeft = '4rem';
            imgElement.forEach(img => img.style.display = "block");
            fullLogoElement.forEach(img => img.style.display = "none");
            // Removido: toggleButton.style.left = "10px";

            if (marginLeft1) {
                marginLeft1.style.marginLeft = '0px';
            }

            if (welcomeDiv) {
                welcomeDiv.style.display = 'none'; // Esconde a div #welcome ao carregar com a sidenav fechada
            }

            if (textFilter) textFilter.style.visibility = 'visible';
            searchDivs.forEach(div => div.style.visibility = 'visible');
        }

        if (removeSNItens) {
            if (sidenav) {
                sidenav.style.display = 'none'; // Oculta toda a sidenav
            }
        }

        function toggleNav() {
            const sidenavWidth = parseInt(sidenav.style.width) || 0;

            if (sidenavWidth === 255) { // Caso a sidenav esteja expandida
                sidenav.style.width = "4rem";
                appContent.style.marginLeft = '4rem';
                imgElement.forEach(img => img.style.display = "block");
                fullLogoElement.forEach(img => img.style.display = "none");
                toggleButton.style.left = "15px";
                if (marginLeft1) marginLeft1.style.marginLeft = '0px';

                if (welcomeDiv) {
                    welcomeDiv.style.display = 'none'; // Esconde a div #welcome ao recolher
                }

                if (textFilter) textFilter.style.visibility = 'hidden';
                searchDivs.forEach(div => div.style.visibility = 'hidden');
            } else { // Caso esteja recolhida
                sidenav.style.width = "255px";
                appContent.style.marginLeft = "255px";
                imgElement.forEach(img => img.style.display = "none");
                fullLogoElement.forEach(img => img.style.display = "block");
                toggleButton.style.left = "200px";
                if (marginLeft1) marginLeft1.style.marginLeft = '15px';

                if (welcomeDiv) {
                    welcomeDiv.style.display = 'block'; // Mostra a div #welcome ao expandir
                }

                if (textFilter) textFilter.style.visibility = 'visible';
                searchDivs.forEach(div => div.style.visibility = 'visible');
            }
        }

        toggleButton.addEventListener("click", toggleNav);
    });
</script> --}}


{{-- <body class="{{ Request::routeIs('documentos.eixos') ? 'hide-sidenav' : '' }}"> --}}
<body>

    <nav class="menu-lateral" id="appSidenav">
        {{-- <button id="toggleSidenav" class="btn-toggle" style="transition: .3s">
            <i class="bi bi-list"></i>
        </button>--}}

        <hr class="spacer" style="margin-top: 1.5rem; color: #22539c;"> 

        <ul class="ulList">
            <li class="item-menu liHover" >
                <a href="{{ route('documentos.intro') }}"
                    class="{{ Request::routeIs('documentos.intro') ? 'active-icon' : '' }}">
                    <i class="bi bi-house icon"></i>
                    <span class="txt-link">Home</span>
                </a>
            </li>

            <li class="item-menu liHover" style="{{ Request::routeIs('documentos.intro') ? 'display: none;' : '' }}">

                <a href="{{ route('documentos.intro') }}" class="{{ Request::routeIs('documentos.intro') ? 'active-icon' : '' }}">
                    <i class="bi bi-question-circle icon"></i>
                    <span class="txt-link">Apresentação</span>
                </a>
            </li>
            

            <li class="item-menu liHover">
                <a href="{{ route('documentos.eixos') }}" class="{{ Request::routeIs('documentos.eixos') ? 'active-icon' : '' }}">
                    <i class="bi bi-arrow-left-right icon"></i>
                    <span class="txt-link">Eixos da Integridade</span>
                </a>
            </li>

            <!--
            <li class="item-menu liHover">
                <a href="{{ route('riscos.implementadas') }}" class="{{ Request::routeIs('riscos.implementadas') ? 'active-icon' : '' }}">
                    <i class="bi bi-check-circle icon"></i>
                    <span class="txt-link">Implementadas</span>
                </a>
            </li>

            <li class="item-menu liHover">
                <a href="{{ route('riscos.implementadasParcialmente') }}" class="{{ Request::routeIs('riscos.implementadasParcialmente') ? 'active-icon' : '' }}">
                    <i class="bi bi-circle-half icon"></i>
                    <span class="txt-link">Implementadas Parcial.</span>
                </a>
            </li>

            <li class="item-menu liHover">
                <a href="{{ route('riscos.emImplementacao') }}" class="{{ Request::routeIs('riscos.emImplementacao') ? 'active-icon' : '' }}">
                    <i class="bi bi-clock-history icon"></i>
                    <span class="txt-link">Em Implementação</span>
                </a>
            </li>

            <li class="item-menu liHover">
                <a href="{{ route('riscos.naoImplementada') }}" class="{{ Request::routeIs('riscos.naoImplementada') ? 'active-icon' : '' }}">
                    <i class="bi bi-x-circle icon"></i>
                    <span class="txt-link">Não Implementada</span>
                </a>
            </li>
            -->

            <hr class="spacer">

            <li class="item-menu liHover">
                <a href="{{ route('historico') }}" class="{{ Request::routeIs('historico') ? 'active-icon' : '' }}">
                    <i class="bi bi-card-text icon"></i>
                    <span class="txt-link">Documentos</span>
                </a>
            </li>

            @if (Auth::user()->unidade->unidadeTipoFK == 1)
                <li class="item-menu liHover">
                    <a href="{{ route('relatorios.download') }}">
                        <i class="bi bi-archive icon"></i>
                        <span class="txt-link">Relatório Geral</span>
                    </a>
                </li>
            @endif

            <!-- <hr class="spacer"> -->

            <li style="display: none" class="item-menu">
                <a href="{{ route('logout') }}"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                    <i class="bi bi-door-open icon"></i>
                    <span class="txt-link">Sair</span>
                </a>
            </li>

            <a href="https://www.fapeam.am.gov.br" target="_blank">
                <div class="logo bottom">
                    <img id="logoMax" src="{{ asset('img/fapeamLogoMono.png') }}" class="logoImg" alt="Logo">
                </div>
            </a>
        </ul>
    </nav>

</body>

</html>