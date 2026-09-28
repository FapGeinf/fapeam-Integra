document.addEventListener('DOMContentLoaded', function () {
    const elements = document.querySelectorAll('.js-choice');
    elements.forEach(function (element) {
        new Choices(element, {
            removeItemButton: true,
            searchEnabled: true,
            itemSelectText: 'Pressione para selecionar',
            noResultsText: 'Nenhum resultado encontrado',
            noChoicesText: 'Não há opções disponíveis',
        });
    });
});