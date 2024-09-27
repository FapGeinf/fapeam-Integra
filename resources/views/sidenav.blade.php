<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{ asset('css/global.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>

<body>
    <nav class="menu-lateral" id="appSidenav">
        <a class="navbar-brand">
            <div class="logo">
                <img id="" src="{{ asset('img/logoDeconWhiteMin.png') }}" style="height: 60%; object-fit: cover;">
            </div>
        </a>

        <div id="welcome">
            <p>Bem-vindo(a)!</p>
        </div>

        <hr class="spacer">

        <ul class="ulList">
            <li class="item-menu liHover">
                <a href="{{ route('riscos.index') }}" class="{{ Request::routeIs('riscos.index') ? 'active' : '' }}">
                    <i class="bi bi-house icon"></i>
                    <span class="txt-link">Home</span>
                </a>
            </li>

            {{-- <hr class="spacer"> --}}
            <li class="item-menu liHover">
                <a href="{{ route('riscos.implementadas') }}"
                    class="{{ Request::routeIs('riscos.implementadas') ? 'active' : '' }}">
                    <i class="bi bi-check-circle icon"></i>
                    <span class="txt-link">Implementadas</span>
                </a>
            </li>

            {{-- <hr class="spacer"> --}}
            <li class="item-menu liHover">
                <a href="{{ route('riscos.implementadasParcialmente') }}"
                    class="{{ Request::routeIs('riscos.implementadasParcialmente') ? 'active' : '' }}">
                    <i class="bi bi-check-circle icon"></i>
                    <span class="txt-link">Implementadas Parcial.</span>
                </a>
            </li>

            {{-- <hr class="spacer"> --}}
            <li class="item-menu liHover">
                <a href="{{ route('riscos.emImplementacao') }}"
                    class="{{ Request::routeIs('riscos.emImplementacao') ? 'active' : '' }}">
                    <i class="bi bi-hourglass-split icon"></i>
                    <span class="txt-link">Em Implementação</span>
                </a>
            </li>

            {{-- <hr class="spacer"> --}}
            <li class="item-menu liHover">
                <a href="{{ route('riscos.naoImplementada') }}"
                    class="{{ Request::routeIs('riscos.naoImplementada') ? 'active' : '' }}">
                    <i class="bi bi-x-circle icon"></i>
                    <span class="txt-link">Não Implementada</span>
                </a>
            </li>

            <hr class="spacer">

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
