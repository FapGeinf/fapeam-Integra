document.addEventListener('DOMContentLoaded', function () {
    let elemento = document.getElementById('eixo_ids');

    if (elemento) {
      let choices = new Choices(elemento, {
        removeItemButton: true,
        placeholder: true,
        searchEnabled: false,
        itemSelectText: '',
        allowHTML: true
      });
    }
});