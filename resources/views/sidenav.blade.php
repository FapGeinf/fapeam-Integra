<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{ asset('css/global.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <style>
        /* Defina a largura inicial da sidenav para garantir que ela carregue fechada */
        #appSidenav {
            width: 4rem; /* Inicia recolhida */
            transition: width 0.3s ease; /* Animação suave para abertura/fechamento */
            overflow: hidden; /* Para esconder o conteúdo quando a sidenav está recolhida */
        }

        .appContent,
        #toggleSidenav {
           /* margin-left: 4rem;  O conteúdo também deve iniciar deslocado */
            transition: margin-left 0.3s; /* Animação suave */
        }
    </style>
</head>

<script>
    document.addEventListener('DOMContentLoaded', function() {
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
</script>


<body>
    <nav class="menu-lateral" id="appSidenav">
        <button id="toggleSidenav" class="btn-toggle" style="transition: .3s">
            <i class="bi bi-list"></i>
        </button>
        
        <a class="navbar-brand">
            <div class="logo">
                <img id="" src="{{ asset('img/logoDeconWhiteMin.png') }}" style="height: 60%; object-fit: cover; margin-top: 8rem;">
            </div>
        </a>

        {{-- <div id="welcome">
            <p>Bem-vindo(a)!</p>
        </div> --}}

        <hr class="spacer" style="margin-top: 4rem;">

        <ul class="ulList">
            <li class="item-menu liHover">
                <a href="{{ route('documentos.eixos') }}" class="{{ Request::routeIs('documentos.eixos') ? 'active-icon' : '' }}">
                    <i class="bi bi-house icon"></i>
                    <span class="txt-link">Home</span>
                </a>
            </li>

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
						<hr class="spacer">
            <li class="item-menu liHover">
                <a href="{{ route('historico') }}" >
								<i class="bi bi-card-text icon"></i>
                    <span class="txt-link">Documentos</span>
                </a>
            </li>
            <li class="item-menu liHover">
                <a href="{{ route('riscos.naoImplementada') }}" >
								<i class="bi bi-archive icon"></i>
                    <span class="txt-link">Relatórios</span>
                </a>
            </li>

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
