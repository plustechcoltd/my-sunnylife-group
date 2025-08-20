import Alpine from 'alpinejs';
import ChatService from '../services/ChatService.js';

Alpine.data('chat_notification_box', () => ({
    rooms: [],

    init() {
        Alpine.effect(async () => {
            this.rooms = Object.values(this.$store.chat.rooms).filter(room => room.unread_count > 0);
        });
    },

    getRoomUrl(room) {
        return ChatService.getRoomUrl(room.id);
    },

    getLastMessage(room) {
        return ChatService.getLastMessage(this.$store.chat.last_message[room?.id]);
    },

    getLastMessageTime(room) {
        return this.$store.chat.last_message[room.id]?.created_at;
    },

    async getAllChatUrl() {
        await this.$nextTick();
        return ChatService.getAllChatUrl();
    },

    isOnline(room) {
        const roomMembers = room.members;

        const memberIds = roomMembers.map(member => member.user_table + '_' + member.user_id);

        return this.onlineUsers?.some(user => {
            return memberIds.includes(user.id) && user.active_room_id == room.id;
        });
    },
}));
