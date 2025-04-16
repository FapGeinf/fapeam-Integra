document.addEventListener("DOMContentLoaded", function () {
    const ckeditorConfig = {
        extraPlugins: 'wordcount',
        wordcount: {
            showCharCount: true,
            maxCharCount: 10000,
            charCountMsg: 'Caracteres restantes: {0}',
            maxCharCountMsg: 'Você atingiu o limite máximo de caracteres permitidos.'
        }
    };

    const ckeditorConfig2 = {
        extraPlugins: 'wordcount',
        wordcount: {
            showCharCount: true,
            maxCharCount: 255,
            charCountMsg: 'Caracteres restantes: {0}',
            maxCharCountMsg: 'Você atingiu o limite máximo de caracteres permitidos.'
        }
    };

    const fieldsWithConfig1 = ['atividade_descricao', 'objetivo', 'justificativa'];
    const fieldsWithConfig2 = ['publico_alvo', 'canal_divulgacao'];

    fieldsWithConfig1.forEach(id => {
        const el = document.getElementById(id);
        if (el) CKEDITOR.replace(id, ckeditorConfig);
    });

    fieldsWithConfig2.forEach(id => {
        const el = document.getElementById(id);
        if (el) CKEDITOR.replace(id, ckeditorConfig2);
    });

    ['#data_prevista', '#data_realizada'].forEach(selector => {
        flatpickr(selector, {
            dateFormat: "Y-m-d",
            altInput: true,
            altFormat: "d/m/Y",
        });
    });

    const publicoSelect = document.getElementById('publico_id');
    const outrosInputContainer = document.getElementById('outros-input-container');
    const novoPublicoInput = document.getElementById('novo_publico');

    if (publicoSelect) {
        publicoSelect.addEventListener('change', function () {
            const isOutros = this.value === 'outros';
            outrosInputContainer.style.display = isOutros ? 'block' : 'none';
            novoPublicoInput.required = isOutros;
        });
    }

    mostrarUnidade();
});

function mostrarUnidade() {
    const meta = parseFloat(document.getElementById('meta')?.value || 0);
    const realizado = parseFloat(document.getElementById('realizado')?.value || 0);
    const unidadeContainer = document.getElementById('unidade-container');

    if (!unidadeContainer) return;

    unidadeContainer.style.display = (meta > 0 || realizado > 0) ? 'block' : 'none';
}
