@extends('layouts.app')
@section('content')

@section('title') {{ 'Investigações Internas' }}
@endsection

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  @vite(['resources/sass/app.scss', 'resources/js/app.js'])
  <link rel="stylesheet" href="{{ asset('css/eixosPages.css') }}">

  <style>
    .pb__dropdown {
      padding-bottom: 4rem;
    }

    .bi-key,
    .bi-door-open {
      margin-left: 0 !important;
    }
  </style>
</head>

<body>
  <div class="form-wrapper pt-5">
    <div class="form_create border">
      <div class="titleDP text-center fw-bold">
        <span>
          Eixo VII - Investigações Internas
        </span>
      </div>
    </div>
  </div>

  <div class="form-wrapper pt-3">
    <div class="form_create border">
      <div class="textDP text__justify">
			<span>
  			<p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Recusandae quibusdam, nisi, tempore corporis quis possimus dignissimos debitis vero labore voluptatem ducimus consequatur maxime culpa! Officiis aperiam necessitatibus aut iste, exercitationem at voluptatibus eaque provident odit sapiente, illum animi unde repellat et modi asperiores sit est reiciendis ut rerum fuga harum.</p>
  			<p>Nostrum quos quasi obcaecati dolor, enim similique. Expedita, est voluptas. Rerum dolorem, provident cum suscipit expedita exercitationem voluptatum molestias sint, voluptate blanditiis consequatur assumenda cumque non omnis recusandae aspernatur aut vero mollitia vel accusamus. Numquam, tempora laudantium accusamus ea adipisci unde, possimus similique libero nesciunt minus dicta nulla explicabo totam provident consequatur odit voluptates corrupti quasi officiis sapiente.</p>
  			<p>Ducimus veniam corrupti, maxime suscipit fugiat dolor unde cupiditate neque quas veritatis, amet minima! Facilis iure aliquid ad, dicta dignissimos harum similique, perferendis alias obcaecati illo numquam error deserunt fuga.</p>
  			<p>Veniam sequi voluptas alias obcaecati enim mollitia iusto sint cumque similique, voluptate est reiciendis doloremque animi id assumenda cupiditate? Veritatis itaque autem sunt inventore natus veniam quam quo adipisci eligendi dolorum dicta velit corrupti necessitatibus voluptatum non earum beatae debitis esse quas, quos in dolor excepturi illum!</p>
  			<p>Tempora consectetur qui quibusdam dolore? Perspiciatis doloribus odit explicabo aperiam culpa vel, dignissimos molestiae molestias?</p>
			</span>
      </div>
    </div>
  </div>

  <!-- <div class="d-flex justify-content-center mt-4">
    <a href="{{ route('atividades.index', ['eixo_id' => 7]) }}">
      <button class="btn__bg btn__bg_color shadow-sm fw-bold text-decoration-none text-center">Atividades</button>
    </a>
  </div> -->

</body>

</html>

@endsection