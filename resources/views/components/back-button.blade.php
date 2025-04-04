<style>
  .back-button {
    border: none;
    color: #fff;
    background-color: #375d84;
    text-decoration: none;
    border-radius: 4px;
    padding: 7px 10px;
    cursor: pointer;
    font-size: 14px;
    transition: background-color 0.3s;
  }

  .back-button:hover {
    background-color: #26425e;
  }
</style>

<div class="text-center mt-4">
  <a class="back-button" href="#" onclick="goBack()">
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
