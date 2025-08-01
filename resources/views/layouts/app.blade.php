<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="shortcut icon" href="{{ asset('img/logoDeconWhiteMin.png') }}">
  <link rel="stylesheet" href="{{asset('css/global.css')}}">
  <link rel="stylesheet" href="{{asset('css/topnav.css')}}">
  <link rel="stylesheet" href="{{asset('css/dropdown-topnav.css')}}">
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
</head>

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
      

      <div class="navbar-brand mt-2" style="margin-left: 2rem;">
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
            <a href="{{ route('documentos.historico') }}" class="d-flex li-a a-navbar {{ Request::routeIs('historico') ? 'li-a-active' : '' }}">
              <i class="bi bi-card-text i-navbar mt-1px"></i>
              <span class="a-span">Documentos</span>
            </a>
          </li>
  
          @if (Auth::user()->unidade->unidadeTipoFK == 1 || Auth::user()->unidade->unidadeTipoFK == 4)
            <li class="li-navbar2">
              <a href="{{ route('relatorios.download') }}" class="d-flex li-a a-navbar">
                <i class="bi bi-archive i-navbar mt-1px"></i>
                <span class="a-span">Relatório Geral</span>
              </a>
            </li>
            @if(Auth::user()->usuario_tipo_fk == 4)
            <li class="li-navbar2">
                <a href="{{ route('usuarios.index') }}" class="d-flex li-a a-navbar">
                    <i class="bi bi-people i-navbar mt-1px"></i>
                    <span class="a-span">Usuários</span>
                </a>
            </li>
            <!-- <li class="li-navbar2">
                <a href="{{ route('logs') }}" class="d-flex li-a a-navbar">
                    <i class="bi bi-clock-history i-navbar mt-1px"></i>
                    <span class="a-span">Logs</span>
                </a>
            </li> -->
            @endif
            @if(Auth::user()->usuario_tipo_fk == 2 || Auth::user()->usuario_tipo_fk == 1 || Auth::user()->usuario_tipo_fk == 4)
              <!-- <li class="li-navbar2">
                  <a href="{{ route('respostas.index') }}" class="d-flex li-a a-navbar">
                      <i class="bi bi-chat-left-dots i-navbar mt-1px"></i>
                      <span class="a-span">Providências</span>
                  </a>
              </li> -->
            @endif
            @if(Auth::user()->usuario_tipo_fk == 4)
              <!-- <li class="li-navbar2">
                  <a href="{{ route('versionamentos.index') }}" class="d-flex li-a a-navbar">
                      <i class="bi bi-files i-navbar mt-1px"></i>
                      <span class="a-span">Versionamentos</span>
                  </a>
              </li> -->
            @endif
          @endif
        </ul>
      </div>

			<div class="custom-actions-wrapper" id="actionsWrapperConta">
        <button type="button" onclick="toggleActionsMenu('Conta')" class="custom-actions-btn-topnav">
            <span>Conta</span>
            <i class="bi bi-caret-down" style="font-size: 11px;"></i>
        </button>
      
        <div class="custom-actions-menu">
          <ul>

            <li>
              <a href="{{ route('users.password') }}" onclick="event.preventDefault(); document.getElementById('alterar-form').submit();">
                <i class="bi bi-key me-2"></i>Alterar Senha
              </a>

              <form id="alterar-form" action="{{ route('users.password') }}" method="GET" class="d-none">
                @csrf
              </form>
            </li>
      
            <li>
              <a href="{{ route('logout') }}" class="" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="bi bi-door-open me-2"></i>Sair
              </a>
              <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
              </form>
            </li>
          </ul>
        </div>
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

  <script>
    function toggleActionsMenu(id) {
      const wrapper = document.getElementById(`actionsWrapper${id}`);
  
      // Alterna o menu atual
      wrapper.classList.toggle('open');
  
      // Fecha os outros menus abertos
      document.querySelectorAll('.custom-actions-wrapper').forEach((el) => {
        if (el.id !== `actionsWrapper${id}`) {
          el.classList.remove('open');
        }
      });
    }
  
    // Fecha o dropdown ao clicar fora
    window.addEventListener('click', function (e) {
      document.querySelectorAll('.custom-actions-wrapper').forEach(wrapper => {
        if (!wrapper.contains(e.target)) {
          wrapper.classList.remove('open');
        }
      });
    });
  </script>
  
</body>

</html>