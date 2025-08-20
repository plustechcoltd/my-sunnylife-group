import { fetchData, postData } from '../helpers/ajax';

export default {
    getNotifications(start, length) {
        let url = window.routes['notifications.index'];
        url += `?start=${start}&length=${length}`;

        return fetchData(url);
    },

    markAllAsRead() {
        return postData(window.routes['notifications.mark_all_as_read']);
    },

    markAsRead(notificationId) {
        return postData(window.routes['notifications.mark_as_read'].replace(':notification:', notificationId));
    }
};
