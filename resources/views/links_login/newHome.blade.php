<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="{{asset('css/home.css')}}">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <title>Document</title>
</head>

<body class="login-page">

  <div class="grid">
    <div class="order__right centered no__overflow borderRadius">

      <a href="{{ route('documentos.eixos') }}" class="arrowButton">
        <i class="bi bi-arrow-90deg-right"></i> Ir para pagina de Eixos
      </a>
  
      <div class="links">
        <div class="linksChild">
          <a class="fw-bold" href="{{ route('apresentacao') }}" target="_blank">Apresentação</a>
        </div>
        
        <div class="linksChild">
          <a class="fw-bold" href="{{ route('legislacao') }}" target="_blank">Legislação</a>
        </div>
  
        <div class="linksChild">
          <a class="fw-bold" href="{{ route('manual') }}" target="_blank">Manual</a>
        </div>
      </div>
      
    </div>
  </div>

</body>
</html>