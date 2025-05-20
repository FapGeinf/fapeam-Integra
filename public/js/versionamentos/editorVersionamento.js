document.addEventListener('DOMContentLoaded', function () {
    if(document.getElementById('descricao')){
        CKEDITOR.replace('descricao');
    }
});