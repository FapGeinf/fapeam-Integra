<link rel="stylesheet" href="{{asset('css/buttons.css')}}">

@if(!Request::is('login'))
  <div class="bg-topnav container-fluid fixed-top">
    <ul class="d-flex justify-content-center">

      @if(Auth::check())
        <li class="li-navbar">
          <i class="bi bi-person-workspace i-navbar text-light"></i>
          <span class="a-navbar fw-semibold">Usuário:</span>
          <span class="a-navbar">{{ Auth::user()->name }}</span>
        </li>

        <li class="li-navbar">
          <i class="bi bi-buildings-fill i-navbar text-light"></i>
          <span class="a-navbar fw-semibold">Lotado em:</span>
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
            <a href="{{ route('documentos.intro') }}" class="d-flex li-a a-navbar">
              <i class="bi bi-house i-navbar"></i>
              <span class="a-span">Home</span>
            </a>
          </li>

          <li class="li-navbar2">
            <a href="{{ route('documentos.eixos') }}" class="d-flex li-a a-navbar">
              <i class="bi bi-arrow-left-right i-navbar"></i>
              <span class="a-span">Eixos da Integridade</span>
            </a>
          </li>

          <li class="li-navbar2">
            <a href="{{ route('documentos.historico') }}" class="d-flex li-a a-navbar">
              <i class="bi bi-card-text i-navbar"></i>
              <span class="a-span">Documentos</span>
            </a>
          </li>

          @if(in_array(Auth::user()->usuario_tipo_fk, [1, 4]))
            <li class="li-navbar2">
              <a href="{{ route('relatorios.download') }}" class="d-flex li-a a-navbar">
                <i class="bi bi-archive i-navbar"></i>
                <span class="a-span">Relatório Geral</span>
              </a>
            </li>
          @endif

          @if(Auth::user()->usuario_tipo_fk == 4)
            <li class="li-navbar2">
              <a href="{{ route('usuarios.index') }}" class="d-flex li-a a-navbar">
                <i class="bi bi-people i-navbar"></i>
                <span class="a-span">Usuários</span>
              </a>
            </li>

            <li class="li-navbar2">
              <a href="{{ route('unidades.index') }}" class="d-flex li-a a-navbar">
                <i class="bi bi-building i-navbar"></i>
                <span class="a-span">Unidades</span>
              </a>
            </li>

            <li class="li-navbar2">
              <a href="{{ route('diretorias.index') }}" class="d-flex li-a a-navbar">
                <i class="bi bi-diagram-3 i-navbar"></i>
                <span class="a-span">Diretorias</span>
              </a>
            </li>

            <li class="li-navbar2">
              <a href="{{ route('log-viewer.index') }}" class="d-flex li-a a-navbar" target="_blank">
                <i class="bi bi-journal-text i-navbar"></i>
                <span class="a-span">Logs</span>
              </a>
            </li>
          @endif

          @if(in_array(Auth::user()->usuario_tipo_fk, [1, 2, 4]))
            <li class="li-navbar2">
              <a href="{{ route('respostas.index') }}" class="d-flex li-a a-navbar">
                <i class="bi bi-chat-left-dots i-navbar"></i>
                <span class="a-span">Providências</span>
              </a>
            </li>
          @endif
        </ul>
      @endif
    </div>

    @if(Auth::check())
      <div class="dropdown">
        <button 
          class="highlighted-btn-sm highlight-blue me-3 dropdown-toggle" 
          type="button"
          id="dropdownConta"
          data-bs-toggle="dropdown"
          aria-expanded="false">
          Conta
        </button>

        <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-end" aria-labelledby="dropdownConta">
          <li>
            <a class="dropdown-item a-navbar" href="{{ route('users.password') }}"
              onclick="event.preventDefault(); document.getElementById('alterar-form').submit();">
              <i class="bi bi-key me-2"></i>Alterar Senha
            </a>

            <form id="alterar-form" action="{{ route('users.password') }}" method="GET" class="d-none">
              @csrf
            </form>
          </li>

          <li>
            <a class="dropdown-item a-navbar" href="{{ route('logout') }}"
              onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
              <i class="bi bi-door-open me-2"></i>Sair
            </a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
              @csrf
            </form>
          </li>
        </ul>
      </div>
    @endif
  </nav>
@endif