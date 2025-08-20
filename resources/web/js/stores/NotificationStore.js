import Alpine from 'alpinejs';
import intersect from '@alpinejs/intersect'
Alpine.plugin(intersect)

import dayjs from "dayjs";
import relativeTime from "dayjs/plugin/relativeTime";
dayjs.extend(relativeTime)

import 'dayjs/locale/ja';
dayjs.locale('ja');

Alpine.store('notification', {
    unread_count: 0,
    all_notifications: [],
    new_notifications: [],
    old_notifications: [],

    init() {
        console.log('Notification Store initialized!!!');
    },

    isNewNotification(notification) {
        const time = dayjs(notification.created_at);
        return time.isAfter(dayjs().subtract(1, 'day'));
    },

    initNotifications(notifications, unreadCount) {
        console.log('initNotifications called')
        for (const notification of notifications) {
            this.all_notifications.push(notification);
            if (this.isNewNotification(notification)) {
                this.new_notifications.push(notification);
            } else {
                this.old_notifications.push(notification);
            }
        }
        this.unread_count = unreadCount;
    },

    loadMoreNotifications(notifications) {
        for (const notification of notifications) {
            if(!this.all_notifications.find(n => n.id == notification.id)){
                this.all_notifications.push(notification);
            }
            if (this.isNewNotification(notification)) {
                if (!this.new_notifications.find(n => n.id === notification.id)) {
                    this.new_notifications.push(notification);
                }
            } else {
                if (!this.old_notifications.find(n => n.id === notification.id)) {
                    this.old_notifications.push(notification);
                }
            }
        }
    },

    addNotification(notification) {
        const existing = this.all_notifications.find(n => n.id === notification.id);
        if (!existing) {
            this.all_notifications.unshift(notification);
        }

        if (this.isNewNotification(notification)) {
            // If the notification is already in the new_notifications array, don't add it again
            // Check unread changes then update the unread count
            const existing = this.new_notifications.find(n => n.id === notification.id);
            if (!existing) {
                this.new_notifications.unshift(notification);
                if (!notification.is_read) {
                    this.unread_count++;
                }
            } else if (notification.is_read && !existing.is_read) {
                existing.is_read = true;
                this.unread_count--;
            }
        } else {
            // If the notification is already in the old_notifications array, don't add it again
            // Check unread changes then update the unread count
            const existing = this.old_notifications.find(n => n.id === notification.id);
            if (!existing) {
                this.old_notifications.unshift(notification);
                if (!notification.is_read) {
                    this.unread_count++;
                }
            } else if (notification.is_read && !existing.is_read) {
                existing.is_read = true;
                this.unread_count--;
            }
        }
    },
});
