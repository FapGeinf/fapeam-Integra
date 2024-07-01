<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="shortcut icon" href="{{ asset('img/logoDeconWhiteMin.png') }}">
  <link rel="stylesheet" href="{{asset('css/global.css')}}">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" 
  rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<title>{{ config('', 'ÍNTEGRA') }} | @yield('title')</title>
	@vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body>
	<div id="app">
    @if(!Request::is('login'))
    <nav class="navbar">
      @if(Auth::check())
        <a class="navbar-brand {{ Request::path() === '/' ? 'active' : '' }}" href="{{route('riscos.index')}}">
          {{-- <img src="/img/logoDeconWhiteMin.png" alt="logo" width="21" height="20" class="logoNavImg d-inline-block align-text-top"> --}}
          <i class="bi bi-person-workspace iconPerson"></i>
        </a>
        @endif
        
      <div class="navbar-brand">
        @if(Auth::check())
        <div id="navbarDropdown">
          <div>
            <span class="userTopNav">Usuário: </span>
            <span class="">{{ Auth::user()->name }}</span>
          </div>
    
          <div>
            <span class="sectorTopNav">Setor: </span>
            <span class="">{{ Auth::user()->unidade->unidadeNome}}</span>
          </div>
    
        </div>
      </div>

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
    @endif

		<main class="py-4 appContent">
			<section class="conteudo">
        @yield('content')
      </section>
		</main>
	</div>
  
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
</body>

</html>
