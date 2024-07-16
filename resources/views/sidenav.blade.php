<!DOCTYPE html>
<html>

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="{{asset('css/global.css')}}">
  <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>

<body>
  <nav class="menu-lateral" id="appSidenav">
    <a class="navbar-brand">
      <div class="logo">
        <img id="" src="{{ asset('img/logoDeconWhite-nobg.png') }}" style="height: 47%;  object-fit: cover;">
      </div>
    </a>

    <ul class="ulList">
      <li class="item-menu">
        <a href="{{route('riscos.index')}}" class="{{ Request::routeIs('riscos.index') ? 'active' : '' }}" style="margin-top: 2rem;">
          <i class="bx bi-house icon {{ Request::routeIs('riscos.index') ? 'active-icon' : '' }}"></i>
          <span class="txt-link">Home</span>
          {{-- <i class="bx bi-chevron-down dropdown-icon"></i> --}}
        </a>
        {{-- <ul class="dropdown">
          <li class="dropdown-item">Placeholder 1</li>
          <li class="dropdown-item">Placeholder 2</li>
        </ul> --}}
      </li>

      <li class="item-menu">
        <a href="" class="{{ Request::path() === 'home' ? 'active' : '' }}">
          <i class='bx bi-file-text icon'></i>
          <span class="txt-link">Relatórios</span>
          {{-- <i class="bx bi-chevron-down dropdown-icon"></i> --}}
        </a>
        {{-- <ul class="dropdown">
          <li class="dropdown-item">Placeholder 1</li>
          <li class="dropdown-item">Placeholder 2</li>
        </ul> --}}
      </li>

      <li style="display: none" class="item-menu">
        <a href="{{ route('logout') }}" onclick="event.preventDefault();
        document.getElementById('logout-form').submit();">
          <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
          </form>
          <i class="bx bxs-exit icon"></i>
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

  {{-- <script>
    document.querySelectorAll('.item-menu > a').forEach(item => {
      item.addEventListener('click', function (e) {
        e.preventDefault();
        const dropdown = this.nextElementSibling;
        if (dropdown) {
          dropdown.classList.toggle('show');
        }
      });
    });
  </script> --}}
</body>

</html>
