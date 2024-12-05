<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"> <!-- Font Awesome CDN -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <title>Home</title>
</head>

<body class="banner">
    <a href="{{ route('documentos.eixos') }}" class="loginButtons arrowButton">
        <i class="fas fa-arrow-right"></i> Ir para pagina de Eixos
    </a>
    <div class="container">
        <div class="button-container">
            <a href="{{ route('apresentacao') }}" target="_blank" class="loginButtons">
                <i class="fas fa-tv"></i> Apresentação
            </a>
            <a href="{{ route('legislacao') }}" target="_blank" class="loginButtons">
                <i class="fas fa-balance-scale"></i> Legislação
            </a>
            <a href="{{ route('manual') }}" target="_blank" class="loginButtons">
                <i class="fas fa-book"></i> Manual
            </a>
        </div>
    </div>
</body>

</html>