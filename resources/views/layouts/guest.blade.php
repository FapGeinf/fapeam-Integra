<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
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
</head>

<body>
    <div id="app">
        <div>
            {{-- @if(!Auth::guest())
		    @include('sidenav')
		  @endif --}}
        </div>

        <main class="py-4 appContent">
            <section class="conteudo">
                @yield('content')
            </section>
        </main>
    </div>
</body>

</html>