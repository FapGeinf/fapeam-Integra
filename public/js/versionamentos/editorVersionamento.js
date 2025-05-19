document.addEventListener('DOMContentLoaded', function () {
    const textareas = document.querySelectorAll('textarea.descricao');
    textareas.forEach((textarea) => {
        CKEDITOR.replace(textarea);
    });
});