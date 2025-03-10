document.addEventListener('DOMContentLoaded', function() {
    CKEDITOR.replace('respostaRisco', {
        extraPlugins: 'wordcount',
        wordcount: {
            showCharCount: true,
            maxCharCount: 4500,
            maxCharCountMsg: 'Você atingiu o limite máximo de caracteres permitidos.',
            charCountMsg: 'Caracteres restantes: {0}'
        }
    });

    document.addEventListener('shown.bs.modal', function(event) {
        const modalId = event.target.id;
        if (modalId === 'editRespostaModal') {
            const respostaId = document.getElementById('editRespostaId').value;
            if (CKEDITOR.instances['editRespostaRisco']) {
                CKEDITOR.instances['editRespostaRisco'].destroy();
            }
            CKEDITOR.replace('editRespostaRisco', {
                extraPlugins: 'wordcount',
                wordcount: {
                    showCharCount: true,
                    maxCharCount: 4500,
                    maxCharCountMsg: 'Você atingiu o limite máximo de caracteres permitidos.',
                    charCountMsg: 'Caracteres restantes: {0}'
                }
            });
        }
    });
});

function editResposta(id, resposta) {
    const form = document.getElementById('editRespostaForm');
    form.action = `/riscos/monitoramentos/respostas/${id}`;
    document.getElementById('editRespostaId').value = id;
    if (CKEDITOR.instances['editRespostaRisco']) {
        CKEDITOR.instances['editRespostaRisco'].destroy();
    }
    CKEDITOR.replace('editRespostaRisco', {
        extraPlugins: 'wordcount',
        wordcount: {
            showCharCount: true,
            maxCharCount: 4500,
            maxCharCountMsg: 'Você atingiu o limite máximo de caracteres permitidos.',
            charCountMsg: 'Caracteres restantes: {0}'
        }
    });
    CKEDITOR.instances['editRespostaRisco'].setData(resposta);


}