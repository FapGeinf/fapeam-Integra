document.addEventListener('DOMContentLoaded', function () {
    flatpickr("#created_at", {
        dateFormat: "Y-m-d",
        altInput: true,
        altFormat: "d/m/Y",
        locale: "pt"
    });
});