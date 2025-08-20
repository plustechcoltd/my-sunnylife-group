import Alpine from 'alpinejs';
import intersect from '@alpinejs/intersect'
Alpine.plugin(intersect)

import dayjs from "dayjs";
import relativeTime from "dayjs/plugin/relativeTime";
import timezone from 'dayjs/plugin/timezone';
import utc from 'dayjs/plugin/utc';
import NotificationService from "../../services/NotificationService.js";
dayjs.extend(relativeTime)
dayjs.extend(timezone);
dayjs.extend(utc);

import 'dayjs/locale/ja';
dayjs.locale('ja');

Alpine.data('notification_box', () => ({
    all_notifications: {},
    new_notifications: {},
    old_notifications: {},
    loading: false,

    init() {
        console.log('Notification Box initialized');
        this.all_notifications = Alpine.store('notification').all_notifications;
        this.new_notifications = Alpine.store('notification').new_notifications;
        this.old_notifications = Alpine.store('notification').old_notifications;
    },

    timeAgo(time) {
        return dayjs(time).fromNow();
    },

    async loadMore() {
        this.loading = true;
        const notifications = await NotificationService.getNotifications(
            this.old_notifications.length + this.new_notifications.length,
            10,
        );
        Alpine.store('notification').loadMoreNotifications(notifications.data);
        this.loading = false;
    },

    async markAllAsRead() {
        await NotificationService.markAllAsRead();
        Alpine.store('notification').unread_count = 0;
        Alpine.store('notification').all_notifications.forEach(notification => notification.read_yn = 'y');
        Alpine.store('notification').new_notifications.forEach(notification => notification.read_yn = 'y');
        Alpine.store('notification').old_notifications.forEach(notification => notification.read_yn = 'y');
    },

    async markAsRead(notificationId, redirectUrl) {
        await NotificationService.markAsRead(notificationId);
        Alpine.store('notification').unread_count--;
        Alpine.store('notification').all_notifications.forEach(notification => {
            if (notification.id === notificationId) {
                notification.read_yn = 'y';
            }
        });
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
