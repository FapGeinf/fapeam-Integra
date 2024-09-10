<!DOCTYPE html>
<html>
<head>
    <title>Nova Resposta Criada</title>
</head>
<body>
    <h1>Nova Resposta Criada</h1>
    <p>{{ $notificacao->message }}</p>
    <a href="{{ route('riscos.respostas', ['id' => $monitoramento->id]) }}">Ver Resposta</a>
</body>
</html>
