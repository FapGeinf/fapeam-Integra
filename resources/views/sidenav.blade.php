<!DOCTYPE html>
<html>

<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
	<link rel="stylesheet" href="{{asset('css/global.css')}}">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

	<script defer>
		function toggleNav() {
			const sidenav = document.getElementById("appSidenav");
			const main = document.getElementById("main");
			const sidenavStyle = window.getComputedStyle(sidenav);
			const imgElement = document.querySelectorAll('#logoMin');
			const fullLogoElement = document.querySelectorAll('#logoMax');
			const appContent = document.getElementsByClassName('appContent')[0];

			if (sidenavStyle.width === "170px") {
				sidenav.style.width = "3rem";
				appContent.style.marginLeft = '3rem';
				imgElement.forEach(img => img.style.display = "block");
				fullLogoElement.forEach(img => img.style.display = "none");
			} else {
				sidenav.style.width = "170px";
				appContent.style.marginLeft = "170px";
				imgElement.forEach(img => img.style.display = "none");
				fullLogoElement.forEach(img => img.style.display = "block");
			}
		}
	</script>


</head>

<body>
	<nav class="menu-lateral" id="appSidenav">

		<div class="btn-expandir">
			<span style="font-size:30px;cursor:pointer" class="openSideNavButton" onclick="toggleNav()"><i class="bi bi-list" id="btn-expand"></i></span>
		</div>

		<a class="navbar-brand {{ Request::path() === '/' ? 'active' : '' }}" href="">
			<div class="logo">
				<img id="logoMin" src="{{ asset('img/logo-lupa-no-background2.png') }}" style="height: 27%; object-fit: cover;">
				<img id="logoMax" src="{{ asset('img/logo-cortada.png')}}" style="display: none;" class="logoImg" alt="Logo">
			</div>
		</a>

		<ul class="ulList">
			<li class="item-menu">
				<a href="" class="{{ Request::path() === '/' ? 'active' : '' }}">
					<i class="bx bi-house icon"></i>
					<span class="txt-link">Home</span>
				</a>
			</li>

			<li class="item-menu">
				<!--Precisa ser adicionada uma rota-->
				<a href="" class="{{ Request::path() === 'home' ? 'active' : '' }}">
					<i class='bx bi-file-text icon'></i>
					<span class="txt-link">Relatórios</span>
				</a>


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
					<img id="logoMin" src="{{ asset('img/logoPic.png') }}" style="height: 25%; object-fit: cover;">
					<img id="logoMax" src="{{ asset('img/fapeamLogoMono.png') }}" style="display: none;" class="logoImg" alt="Logo">
				</div>
			</a>

		</ul>
		</div>
	</nav>
</body>

</html>