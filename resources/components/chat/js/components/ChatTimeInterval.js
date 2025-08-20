import Alpine from 'alpinejs';
import dayjs from 'dayjs';
import isToday from 'dayjs/plugin/isToday';
import localizedFormat from 'dayjs/plugin/localizedFormat';
import relativeTime from 'dayjs/plugin/relativeTime';

dayjs.extend(isToday);
dayjs.extend(localizedFormat);
dayjs.extend(relativeTime);

const currentLanguage = window.AppConfig.currentLanguage || 'ja';

Alpine.data('chat_time_interval', (roomId) => ({
    timeAgo: '',
    updateInterval: null,
    dayjs: dayjs,

    init() {
        this.dayjs?.locale(currentLanguage);

        Alpine.effect(() => {
            const lastMessageTime = this.$store.chat?.last_message?.[roomId]?.created_at;
            if (lastMessageTime) {
                this.startUpdate(lastMessageTime);
            }
        });
    },

    updateTimeAgo(time) {
        this.timeAgo = this.dayjs ? this.dayjs(time).fromNow() : '';
    },

    startUpdate(time) {
        this.stopUpdate();
        this.updateTimeAgo(time);

        // Calculate the time until the next full minute
        const now = new Date();
        const secondsToNextMinute = 60 - now.getSeconds();

        // First update will be at the start of the next minute
        setTimeout(() => {
            this.updateTimeAgo(time);

            // Subsequent updates every 60 seconds
            this.updateInterval = setInterval(() => {
                this.updateTimeAgo(time);
            }, 60000);
        }, secondsToNextMinute * 1000);
    },

    stopUpdate() {
        if (this.updateInterval) {
            clearInterval(this.updateInterval);
            this.updateInterval = null;
        }
    }
}));
