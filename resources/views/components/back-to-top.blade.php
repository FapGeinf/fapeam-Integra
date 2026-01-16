<head>
  <style>
    #btnVoltarTopo {
      display: none;
      position: fixed;
      bottom: 20px;
      right: 20px;
      z-index: 99;
      border: none;
      outline: none;
      background-color: #0d6efd;
      color: white;
      cursor: pointer;
      padding: 2px 7px;
      border-radius: 50%;
      font-size: 14px;
      box-shadow: 0px 2px 6px rgba(0,0,0,0.3);
    }

    #btnVoltarTopo:hover {
      background-color: #0b5ed7;
    }
  </style>

  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>

<div>
  <button id="btnVoltarTopo">
    <i class="bi bi-arrow-up"></i>
  </button>
</div>

<script>
  $(window).on('scroll', function() {
    if ($(this).scrollTop() > 200) {
      $('#btnVoltarTopo').fadeIn();
    } else {
      $('#btnVoltarTopo').fadeOut();
    }
  });

  $('#btnVoltarTopo').on('click', function() {
    $('html, body').animate({ scrollTop: 0 }, 'fast');
  });
</script>