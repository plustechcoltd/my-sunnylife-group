import Alpine from 'alpinejs';
import NotificationService from "../../services/NotificationService.js";

Alpine.data('notification_bell', () => ({
    async markAllAsRead() {
        await NotificationService.markAllAsRead();
        Alpine.store('notification').unread_count = 0;
        Alpine.store('notification').new_notifications.forEach(notification => notification.read_yn = 'y');
        Alpine.store('notification').old_notifications.forEach(notification => notification.read_yn = 'y');
    },
    async markAsRead(notificationId, redirectUrl) {
        await NotificationService.markAsRead(notificationId);
        Alpine.store('notification').unread_count--;
        Alpine.store('notification').new_notifications.forEach(notification => {
            if (notification.id === notificationId) {
                notification.read_yn = 'y';
            }
        });
        Alpine.store('notification').old_notifications.forEach(notification => {
            if (notification.id === notificationId) {
                notification.read_yn = 'y';
            }
        });
        if(redirectUrl) {
            window.location.href = redirectUrl;
        }
    },
}));
