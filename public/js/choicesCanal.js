document.addEventListener('DOMContentLoaded', function () {
    let elemento = document.getElementById('canal_id');

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