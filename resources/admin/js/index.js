/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

import axios from 'axios';
import Alpine from 'alpinejs';
import '../css/flag-icons.css';

// Initialize Axios
window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

// Initialize Alpine.js
window.Alpine = Alpine;
Alpine.start();

// Initialize DataTable
import { initializeDataTable } from './helpers/datatable';
window.initializeDataTable = initializeDataTable;

// Initialize Utils
import { previewFile } from './helpers/utils';
window.previewFile = previewFile;

// Notifications
import './stores/NotificationStore.js';
import './components/notifications/NotificationBell.js';
import './components/notifications/NotificationBox.js';

// Chats
import '../../components/chat/js/stores/ChatStore.js';
import '../../components/chat/js/components/ChatSidebar.js';
import '../../components/chat/js/components/ChatContent.js';
import '../../components/chat/js/components/ChatInput.js';
import '../../components/chat/js/components/ChatTimeInterval.js';

import '../../components/chat/js/components/ChatNotificationBell.js';
import '../../components/chat/js/components/ChatNotificationBox.js';

import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: import.meta.env.VITE_PUSHER_APP_KEY,
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
    forceTLS: true,
    encrypted: true,
    auth: {
        headers: {
            'X-Active-Room-Id': `${window.activeRoomId}`
        }
    }
});

// Initialize Noty
Noty.overrideDefaults({
    theme: 'limitless',
    layout: 'topRight',
    type: 'alert',
    timeout: 2500,
});

// Initialize SweetAlert2
export let swalInit = Swal.mixin({
    buttonsStyling: false,
    customClass: {
        confirmButton: 'btn btn-primary',
        cancelButton: 'btn btn-light',
        denyButton: 'btn btn-light',
        input: 'form-control',
    },
});
