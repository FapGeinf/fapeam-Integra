<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
 

	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="shortcut icon" href="{{ asset('/favicon.png') }}">
  <link rel="stylesheet" href="{{asset('css/global.css')}}">
	<!-- CSRF Token -->
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<title>{{ config('app.name', 'SGR') }} | @yield('title')</title>
	<!-- Fonts -->
	<link rel="dns-prefetch" href="//fonts.bunny.net">
	<link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
	<!-- Scripts -->
	@vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body>
	<div id="app">
    @if(!Request::is('login')) <!-- Adicione esta linha -->
    <nav class="navbar navbar-light bg-green">
      @if(Auth::check())
        <a class="navbar-brand {{ Request::path() === '/' ? 'active' : '' }}" href="">
          <img src="/img/logo-lupa-no-background.png" alt="logo" width="29" height="27" class="logoNavImg d-inline-block align-text-top">
          {{-- <span class="appName">MONITORA</span> --}}
        </a>
        @endif
        
      <div class="container-fluid">
        @if(Auth::check())
        <div id="navbarDropdown">
            <div>
                <span class="userTopNav">Usuário: </span>
                <span class="">{{ Auth::user()->name }}</span>
            </div>
          
          {{-- <span class="split">-</span> --}}

            <div>
                <span class="sectorTopNav">Setor: </span>
                <span class="">{{ Auth::user()->unidade->unidadeNome}}</span>
            </div>
    
          
        </div>
      </div>

      {{-- <span class="barExit">|</span> --}}

    <div class="nav-item">
      <a class="btnSair" href="{{ route('logout') }}" onclick="event.preventDefault();
      document.getElementById('logout-form').submit();">
        <i class="bi bi-box-arrow-right"></i>
        Sair
      </a>
      <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
        @csrf
      </form>
    </div>
    
    @endif
    </nav>


    <div>
      @if(!Auth::guest())
		    @include('sidenav')
		  @endif
    </div>
    @endif <!-- Adicione esta linha -->

		<main class="py-4 appContent">
			<section class="conteudo">
              @yield('content')
      </section>
		</main>
	</div>
</body>

</html>
