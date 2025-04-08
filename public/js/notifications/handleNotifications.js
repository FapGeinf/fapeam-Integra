document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('notificationModal').addEventListener('show.bs.modal', function () {
        const notificationBadge = document.getElementById('notificationBadge');
        const unreadCount = parseInt(notificationBadge.dataset.count, 10);
        notificationBadge.textContent = unreadCount;
        notificationBadge.dataset.count = unreadCount;
    });

    document.getElementById('showMoreUnread')?.addEventListener('click', function () {
        const notifications = document.getElementById('unreadNotifications');
        notifications.classList.toggle('expanded');
        this.textContent = notifications.classList.contains('expanded') ? 'Mostrar menos' :
            'Mostrar mais';
    });

    document.getElementById('showMoreRead')?.addEventListener('click', function () {
        const notifications = document.getElementById('readNotifications');
        notifications.classList.toggle('expanded');
        this.textContent = notifications.classList.contains('expanded') ? 'Mostrar menos' :
            'Mostrar mais';
    });
});