<link rel="stylesheet" href="{{ asset('css/buttons.css') }}">

<div class="text-center mt-4">
  <a class="highlighted-btn-sm highlight-blue text-decoration-none" 
    href="#" onclick="goBack()">
    <i class="bi bi-arrow-left"></i>
    Voltar para página anterior
  </a>
</div>

<script>
  function goBack() {
    if (window.history.length > 1) {
      window.history.back();
    } else {
      window.location.href = '/'; // ou outra página específica
    }
  }
</script>
