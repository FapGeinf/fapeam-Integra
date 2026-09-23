<link rel="stylesheet" href="{{asset('css/buttons.css')}}">
<link rel="stylesheet" href="{{ asset('css/darkMode.css') }}">
<link rel="stylesheet" href="{{ asset('css/toggle-button.css') }}">

@if(!Request::is('login'))
<nav class="navbar navbar-expand-lg navbar-dark bg-sisgep fixed-top p-0">
  <div class="container-fluid">
    <a href="{{ route('documentos.intro') }}" class="navbar-brand fw-semibold d-flex align-items-center ms-md-4">
      <img src="/img/logonav.png" alt="Logo" class="logoNavImg me-2" style="max-height: 40px;">
    </a>

    <button 
      class="navbar-toggler" 
      type="button" 
      data-bs-toggle="collapse" 
      data-bs-target="#navbarNav"
      aria-controls="navbarNav" 
      aria-expanded="false" 
      aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-1">
        @if(Auth::check())
          <li class="nav-item fs-custom">
            <a href="{{ route('documentos.intro') }}" class="nav-link nav-a text-light d-flex align-items-center">
              <i class="bi bi-house me-1"></i>
              <span>Home</span>
            </a>
          </li>

          <li class="nav-item fs-custom">
            <a href="{{ route('documentos.eixos') }}" class="nav-link nav-a text-light d-flex align-items-center">
              <i class="bi bi-arrow-left-right me-1"></i>
              <span>Eixos da Integridade</span>
            </a>
          </li>

          <li class="nav-item fs-custom">
            <a href="{{ route('documentos.historico') }}" class="nav-link nav-a text-light d-flex align-items-center">
              <i class="bi bi-card-text me-1"></i>
              <span>Documentos</span>
            </a>
          </li>

          @if(in_array(Auth::user()->usuario_tipo_fk, [1, 4]))
            <li class="nav-item fs-custom">
              <a href="{{ route('relatorios.download') }}" class="nav-link nav-a text-light d-flex align-items-center">
                <i class="bi bi-archive me-1"></i>
                <span>Relatório Geral</span>
              </a>
            </li>
          @endif

          @if(Auth::user()->usuario_tipo_fk == 4)
            <li class="nav-item fs-custom">
              <a href="{{ route('usuarios.index') }}" class="nav-link nav-a text-light d-flex align-items-center">
                <i class="bi bi-people me-1"></i>
                <span>Usuários</span>
              </a>
            </li>
          @endif

          @if(in_array(Auth::user()->usuario_tipo_fk, [1, 2, 4]))
            <li class="nav-item fs-custom">
              <a href="{{ route('respostas.index') }}" class="nav-link nav-a text-light d-flex align-items-center">
                <i class="bi bi-chat-left-dots me-1"></i>
                <span>Providências</span>
              </a>
            </li>
          @endif

          <li class="nav-item dropdown floating-dropdown ms-lg-2">
            <a class="nav-link dropdown-toggle text-light d-flex align-items-center" 
              href="#" id="perfilDropdown"
              data-bs-toggle="dropdown" aria-expanded="false">
              <i class="bi bi-person-circle me-1" style="font-size: 13px;"></i>
            </a>

            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-dark border-0 shadow" aria-labelledby="perfilDropdown">
              <li class="px-3 py-2">
                <div class="d-flex flex-column">
                  <span class="fw-semibold custom-a">
                    <i class="bi bi-person-circle me-2"></i>
                    {{ Auth::user()->name }}
                  </span>

                  <small class="custom-a d-flex align-items-start text-wrap mt-1">
                    <i class="bi bi-buildings me-2 mt-1"></i>
                    <span>{{ Auth::user()->unidade?->unidadeNome ?? 'FAPEAM' }}</span>
                  </small>
                </div>
              </li>

              <li>
                <hr class="dropdown-divider border-secondary w-100">
              </li>

              <li>
                <a class="dropdown-item custom-a" href="{{ route('users.password') }}">
                  <i class="bi bi-key me-1"></i>
                  Alterar Senha
                </a>
              </li>

              <li onclick="event.stopPropagation();">
                <div class="dropdown-item d-flex align-items-center justify-content-between">
                  <span class="d-flex align-items-center custom-a">
                    <i class="bi bi-circle-half me-2"></i>
                    Tema:
                  </span>
                  
                  <button 
                    id="darkModeToggle"
                    class="dark-toggle mb-0"
                    type="button"
                    title="Alternar modo escuro"
                    aria-label="Alternar modo escuro">
                    <span class="toggle-track">
                      <i class="bi bi-sun-fill toggle-icon sun-icon"></i>
                      <span class="toggle-thumb"></span>
                      <i class="bi bi-moon-fill toggle-icon moon-icon"></i>
                    </span>
                  </button>
                </div>
              </li>

              <li>
                <hr class="dropdown-divider border-secondary w-100">
              </li>

              <li>
                <form method="POST" action="{{ route('logout') }}" class="mb-0">
                  @csrf
                  <button type="submit" class="dropdown-item custom-a">
                    <i class="bi bi-box-arrow-right me-2"></i>
                    Sair
                  </button>
                </form>
              </li>
            </ul>
          </li>
        @endif
      </ul>
    </div>
  </div>
</nav>
@endif

<script src="{{ asset('js/darkMode.js') }}"></script>