import Alpine from 'alpinejs';

Alpine.data('chat_notification_bell', () => ({
    unreadCount: 0,

    init() {
        Alpine.effect(async () => {
            this.unreadCount = this.$store.chat.unreadCount > 99 ? '99+' : this.$store.chat.unreadCount;
        });
    },
}));
