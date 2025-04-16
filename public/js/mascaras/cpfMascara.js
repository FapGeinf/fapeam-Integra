$(document).ready(function () {
    $('.cpf').mask('000.000.000-00');

    $('form').submit(function () {
        $('#cpf').each(function () {
            var cpf = $(this).val().replace(/\D/g, '');
            $(this).val(cpf);
        });
    });
});