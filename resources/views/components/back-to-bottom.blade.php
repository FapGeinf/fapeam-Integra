<style>
  #btnIrFim {
    display: none;
    position: fixed;
    bottom: 20px;
    right: 57px;
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

  #btnIrFim:hover {
    background-color: #0b5ed7;
  }
</style>

<div>
  <button id="btnIrFim">
    <i class="bi bi-arrow-down"></i>
  </button>
</div>

<script>
  $(window).on('scroll', function () {
    if ($(this).scrollTop() > 200) {
      $('#btnIrFim').fadeIn();
    } else {
      $('#btnIrFim').fadeOut();
    }
  });

  $('#btnIrFim').on('click', function () {
    $('html, body').animate({ scrollTop: $(document).height() }, 'fast');
  });
</script>
