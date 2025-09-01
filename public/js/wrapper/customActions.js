document.addEventListener('DOMContentLoaded', function() {
    function toggleActionsMenu(id) {
        const wrapper = document.getElementById(`actionsWrapper${id}`);
        if (!wrapper) return;  
        
        wrapper.classList.toggle('open');
        
        document.querySelectorAll('.custom-actions-wrapper').forEach((el) => {
            if (el.id !== `actionsWrapper${id}`) {
                el.classList.remove('open');
            }
        });
    }

   
    window.addEventListener('click', function (e) {
        document.querySelectorAll('.custom-actions-wrapper').forEach(wrapper => {
            if (!wrapper.contains(e.target)) {
                wrapper.classList.remove('open');
            }
        });
    });

    document.querySelectorAll('.menu-toggle').forEach(button => {
        button.addEventListener('click', function() {
            const id = button.getAttribute('data-id');
            toggleActionsMenu(id);
        });
    });
});
