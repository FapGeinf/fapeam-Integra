document.addEventListener('DOMContentLoaded',function(){
    const probabilidade = document.getElementById('probabilidade');
    const impacto = document.getElementById('impacto');
    const riscoLabel = document.getElementById('riscoLabel');
    const nivelDeRiscoInput = document.getElementById('nivel_de_risco');

    function calcularNivelDeRisco() {
        const p = parseInt(probabilidade.value) || 0;
        const i = parseInt(impacto.value) || 0;
        const resultado = p * i;

        let texto = '-';
        let cor = '';
        let nivel = '';

        if (resultado >= 15) {
            texto = 'Alto (' + resultado + ')';
            cor = 'red';
            nivel = '3';
        } else if (resultado >= 5) {
            texto = 'Médio (' + resultado + ')';
            cor = 'orange';
            nivel = '2';
        } else if (resultado > 0) {
            texto = 'Baixo (' + resultado + ')';
            cor = 'green';
            nivel = '1';
        }

        riscoLabel.textContent = texto;
        riscoLabel.style.color = cor;
        nivelDeRiscoInput.value = nivel;
    }

    probabilidade.addEventListener('input', calcularNivelDeRisco);
    impacto.addEventListener('input', calcularNivelDeRisco);
})