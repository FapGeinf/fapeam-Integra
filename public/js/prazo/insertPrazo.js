document.addEventListener('DOMContentLoaded', function () {
    const prazoElement = document.getElementById('prazo');
    if (!prazoElement) return;

    const prazoText = prazoElement.innerText.trim(); // pega o texto da div
    const prazoDate = new Date(prazoText);
    const today = new Date();

    const diffTime = prazoDate - today;
    const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

    prazoElement.classList.remove('bg-success', 'bg-warning', 'bg-danger');

    if (diffDays < 0) {
        prazoElement.classList.add('bg-danger');
    } else if (diffDays <= 7) {
        prazoElement.classList.add('bg-warning');
    } else {
        prazoElement.classList.add('bg-success');
    }
});
