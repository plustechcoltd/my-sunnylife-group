import Alpine from 'alpinejs';
import ChatService from '../services/ChatService.js';

Alpine.data('chat_sidebar', () => ({
    rooms: [],
    searchQuery: '',
    roomSort: [],
    onlineUsers: [],

    init() {
        Alpine.effect(() => {
            if (this.searchQuery) {
                this.rooms = Object.fromEntries(
                    Object.values(this.$store.chat.rooms)
                        .filter(room =>
                            (room.name || '').toLowerCase().includes((this.searchQuery || '').toLowerCase())
                        )
                        .map(room => [room.id, room])
                );
            } else {
                this.rooms = this.$store.chat.rooms;
            }

            this.onlineUsers = Object.values(this.$store.chat.onlineUsers);
        });
    },

    roomNameMatchesSearchQuery(room) {
        if (!room || !room.name) {
            return '';
        }

        const roomNameLowercase = room.name.toLowerCase().trim();
        const searchQueryLowercase = this.searchQuery.toLowerCase().trim();
        if (searchQueryLowercase) {
            const regex = new RegExp(`(${searchQueryLowercase})`, 'gi');

            if (roomNameLowercase.includes(searchQueryLowercase)) {
                return room.name.replace(regex, match =>
                    `<span class="text-danger">${match}</span>`
                );
            }
        }

        return room.name;
    },

    unreadCount(room) {
        if (!room) return 0;
        return room.unread_count > 99 ? '99+' : room.unread_count;
    },

    getRoomUrl(room) {
        return ChatService.getRoomUrl(room?.id);
    },

    getLastMessage(room) {
        return ChatService.getLastMessage(this.$store.chat.last_message[room?.id]);
    },

    getLastMessageTime(room) {
        return this.$store.chat.last_message[room?.id]?.created_at || room.created_at;
    },

    isActive(room) {
        return !!room?.active_room;
    },

    isOnline(room) {
        if(!room) {
            return;
        }
        const roomMembers = room.members;
        const memberIds = roomMembers.map(member => member.user_table + '_' + member.user_id);

        return this.onlineUsers.filter(user => user.id != room.me.user_table + '_' + room.me.user_id).some(user => {
            return memberIds.includes(user.id);
        });
    },
}));
