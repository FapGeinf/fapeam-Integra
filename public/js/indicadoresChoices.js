document.addEventListener('DOMContentLoaded', function () {
    let elementoIndicadores = document.getElementById('indicador_ids');

    if (elementoIndicadores) {
      let choices = new Choices(elementoIndicadores, {
        removeItemButton: true,
        placeholder: true,
        searchEnabled: false,
        itemSelectText: '',
        allowHTML: true
      });
    }
});