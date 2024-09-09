@extends('layouts.app')

@section('title') {{'Apresentação'}} @endsection

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="{{asset('css/apresentacao.css')}}">
  <link rel="stylesheet" href="{{asset('css/removeGlobalConfig.css')}}">
</head>

@section('content')
<body>
  <div class="form-wrapper">
    <div class="box-shadow">
      <h1>Apresentação</h1>
    </div>
    
  </div>
</body>
@endsection
</html>