document.addEventListener("DOMContentLoaded", function () {
    let ckeditorConfig = {
        extraPlugins: 'wordcount',
        wordcount: {
            showCharCount: true,
            maxCharCount: 10000,
            charCountMsg: 'Caracteres restantes: {0}',
            maxCharCountMsg: 'Você atingiu o limite máximo de caracteres permitidos.'
        }
    };

    let ckeditorConfigMenor = {
        extraPlugins: 'wordcount',
        wordcount: {
            showCharCount: true,
            maxCharCount: 2000,
            charCountMsg: 'Caracteres restantes: {0}',
            maxCharCountMsg: 'Você atingiu o limite máximo de caracteres permitidos.'
        }
    };

    if (document.getElementById('objetivo')) {
        CKEDITOR.replace('objetivo', ckeditorConfig);
    }

    if (document.getElementById('descricao_acao')) {
        CKEDITOR.replace('descricao_acao', ckeditorConfig);
    }

    if (document.getElementById('procedimentos')) {
        CKEDITOR.replace('procedimentos', ckeditorConfigMenor);
    }
});