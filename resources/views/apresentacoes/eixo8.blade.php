@extends('layouts.app')
@section('content')

@section('title') {{ 'Monitoramento Contínuo' }}
@endsection

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  @vite(['resources/sass/app.scss', 'resources/js/app.js'])
  <link rel="stylesheet" href="{{ asset('css/eixosPages.css') }}">
</head>

<body>
  <div class="form-wrapper pt-5">
    <div class="form_create border">
      <div class="titleDP text-center fw-bold">
        <span>
          Monitoramento Contínuo
        </span>
      </div>
    </div>
  </div>

  <div class="form-wrapper pt-3">
    <div class="form_create border">
      <div class="textDP text__justify">
        <span>
          Lorem ipsum dolor sit, amet consectetur adipisicing elit. Recusandae quibusdam, nisi, tempore corporis quis possimus dignissimos debitis vero labore voluptatem ducimus consequatur maxime culpa! Officiis aperiam necessitatibus aut iste, exercitationem at voluptatibus eaque provident odit sapiente, illum animi unde repellat et modi asperiores sit est reiciendis ut rerum fuga harum. Nostrum quos quasi obcaecati dolor, enim similique. Expedita, est voluptas. Rerum dolorem, provident cum suscipit expedita exercitationem voluptatum molestias sint, voluptate blanditiis consequatur assumenda cumque non omnis recusandae aspernatur aut vero mollitia vel accusamus. Numquam, tempora laudantium accusamus ea adipisci unde, possimus similique libero nesciunt minus dicta nulla explicabo totam provident consequatur odit voluptates corrupti quasi officiis sapiente. Ducimus veniam corrupti, maxime suscipit fugiat dolor unde cupiditate neque quas veritatis, amet minima! Facilis iure aliquid ad, dicta dignissimos harum similique, perferendis alias obcaecati illo numquam error deserunt fuga. Veniam sequi voluptas alias obcaecati enim mollitia iusto sint cumque similique, voluptate est reiciendis doloremque animi id assumenda cupiditate? Veritatis itaque autem sunt inventore natus veniam quam quo adipisci eligendi dolorum dicta velit corrupti necessitatibus voluptatum non earum beatae debitis esse quas, quos in dolor excepturi illum! Tempora consectetur qui quibusdam dolore? Perspiciatis doloribus odit explicabo aperiam culpa vel, dignissimos molestiae molestias?
        </span>
      </div>
    </div>
  </div>

  <div class="d-flex justify-content-center mt-4">
      <button class="btn__bg btn__bg_color shadow-sm fw-bold">Atividades</button>
  </div>

</body>

</html>

@endsection