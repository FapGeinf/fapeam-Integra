<link rel="shortcut icon" href="{{ asset('img/logoDeconWhiteMin.png') }}">
<link rel="stylesheet" href="{{asset('css/global.css')}}">
<link rel="stylesheet" href="{{asset('css/topnav.css')}}">
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>{{ config('', 'Íntegra') }} | @yield('title')</title>
@vite(['resources/sass/app.scss', 'resources/js/app.js'])

<style>
  body {
    font-family: 'Poppins', sans-serif;
  }

  .mt-1px {
    margin-top: 1px;
  }
</style>

<body>
	<div id="app">
    @if(!Request::is('login'))

    <div class="bg-topnav container-fluid fixed-top">
      <ul class="d-flex justify-content-center">

        @if(Auth::check())
          <li class="li-navbar">
            <i class="bi bi-person-workspace i-navbar text-light"></i>
            <span class="a-navbar fw-bold">Usuário:</span>
            <span class="a-navbar">{{ Auth::user()->name }}</span>
          </li>

          <li class="li-navbar">
            <i class="bi bi-buildings-fill i-navbar text-light"></i>
            <span class="a-navbar fw-bold">Lotado em:</span>
            <span class="a-navbar">{{ Auth::user()->unidade->unidadeNome}}</span>
          </li>
        @endif

      </ul>
    </div>

    <nav class="navbar" style="{{ Request::routeIs('register') ? 'margin-top: 0;' : '' }}">
      <div>
        @if(Auth::check())
        <a class="navbar-brand" href="{{ route('documentos.intro') }}" style="position: absolute; top: -7px">
          <img src="/img/logonav.png" alt="logo" class="logoNavImg d-inline-block align-text-top">          
        </a>
        @endif
      </div>
      

      <div class="navbar-brand" style="margin-left: 2rem;">
        @if(Auth::check())
        <ul class="d-flex justify-content-center">

          <li class="li-navbar2">
            <a href="{{ route('documentos.intro') }}" class="d-flex li-a a-navbar {{ Request::routeIs('documentos.intro') ? 'li-a-active' : '' }}">
              <i class="bi bi-house i-navbar mt-1px"></i>
              <span class="a-span">Home</span>
            </a>
          </li>
  
          <li class="li-navbar2">
            <a href="{{ route('documentos.eixos') }}" class="d-flex li-a a-navbar {{ Request::routeIs('documentos.eixos') ? 'li-a-active' : '' }}">
              <i class="bi bi-arrow-left-right i-navbar mt-1px"></i>
              <span class="a-span">Eixos da Integridade</span>
            </a>
          </li>
  
          <li class="li-navbar2">
            <a href="{{ route('historico') }}" class="d-flex li-a a-navbar {{ Request::routeIs('historico') ? 'li-a-active' : '' }}">
              <i class="bi bi-card-text i-navbar mt-1px"></i>
              <span class="a-span">Documentos</span>
            </a>
          </li>
  
          @if (Auth::user()->unidade->unidadeTipoFK == 1)
            <li class="li-navbar2">
              <a href="{{ route('relatorios.download') }}" class="d-flex li-a a-navbar">
                <i class="bi bi-archive i-navbar mt-1px"></i>
                <span class="a-span">Relatório Geral</span>
              </a>
            </li>
            <li class="li-navbar2">
                <a href="{{ route('usuarios.index') }}" class="d-flex li-a a-navbar">
                    <i class="bi bi-people i-navbar mt-1px"></i>
                    <span class="a-span">Usuários</span>
                </a>
            </li>
          @endif
        </ul>
      </div>

			<div class="nav-item dropdown">
        <a class="nav-link dropdown-toggle btnSair" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
					<i class="bi bi-person"></i> <span style="margin-right: 5px;">Conta</span>
				</a>

        <ul class="dropdown-menu pb__dropdown dropdown-menu-end" aria-labelledby="userDropdown">
          <li class="mb-1 liDP">
            <i class="bi bi-key" style="color: #22539c; margin-left: 1rem;"></i>

            <a class="btnAltSenha" href="{{ route('users.password') }}" onclick="event.preventDefault(); document.getElementById('alterar-form').submit();">Alterar Senha</a>
            <form id="alterar-form" action="{{route('users.password')}}" method="GET" class="d-none">
              @csrf
            </form>
          </li>

          <li class="liDP">
            <i class="bi bi-door-open" style="color: #22539c; margin-left: 1rem;"></i>

            <a class="btnSair" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
              Sair
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
              @csrf
            </form>
          </li>
        </ul>
    	</div>
    @endif
    </nav>

    <div>
      {{-- @if(!Auth::guest())
		    @include('sidenav')
		  @endif --}}
    </div>
    @endif

		<main class="py-4 appContent">
			<section class="conteudo">
        @yield('content')
      </section>
		</main>
	</div>