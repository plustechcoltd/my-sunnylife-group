import Alpine from 'alpinejs';
import ChatService from '../services/ChatService.js';

Alpine.store('chat', {
    rooms: {},
    activeRoomId: null,
    activeRoomNewMessages: 0,
    activeRoomTyping: false,
    unreadCount: 0,
    last_message: {},
    sort: [],
    userType: null,
    onlineUsers: {},

    init() {
        console.log('Chat Store initialized');
    },

    initChat(members, activeRoomId, userType) {
        this.activeRoomId = activeRoomId;
        this.userType = userType;
        this.sort = members.map(member => member.room.id);

        // join in current active room presence channel
        const presenceChannel = window.Echo.join('chats.' + activeRoomId);
        presenceChannel.here((users) => {
            for (const user of users) {
                this.rooms[activeRoomId].active_members[user.user_table + '_' + user.user_id] = user;
            }
        }).joining((user) => {
            console.log('User joined', user);
            if (!this.rooms[activeRoomId].active_members[user.user_table + '_' + user.user_id]) {
                this.rooms[activeRoomId].active_members[user.user_table + '_' + user.user_id] = user;
            }
        }).leaving((user) => {
            console.log('User left', user);
            delete this.rooms[activeRoomId].active_members[user.user_table + '_' + user.user_id];
        });

        // join in current active room presence channel
        const presencePublicChannel = window.Echo.join('online');
        presencePublicChannel.here((users) => {
            // console.log(`online users: `, users);
            for (const user of users) {
                this.onlineUsers[user.user_table + '_' + user.user_id] = user;
            }
        }).joining((user) => {
            console.log('User joined online', user);
            if (!this.onlineUsers[user.user_table + '_' + user.user_id]) {
                this.onlineUsers[user.user_table + '_' + user.user_id] = user;
            }

            console.log(`joining online: `, this.onlineUsers);
        }).leaving((user) => {
            console.log('User offline', user);
            delete this.onlineUsers[user.user_table + '_' + user.user_id];
        }).listen('.chat_room.message', (e) => {
            this.handleNewMessage(e.encryptedMessage, e.roomId);

            // Move room to top of the list
            this.sort = [e.roomId, ...this.sort.filter(id => id != e.roomId)];
        });

        for (const member of members) {
            const me = member.room.members.find(m => m.user_table === member.user_table && m.user_id === member.user_id);
            const roomId = member.room.id;
            this.last_message[roomId] = member.last_message;
            
            this.rooms[roomId] = {
                id: roomId,
                name: member.room.name,
                me,
                members: member.room.members,
                active_members: {},
                last_message: member.last_message,
                messages: [],
                unread_count: member.unread_count,
                created_at: member.room.created_at,
                type: member.room.type,
                avatar: member.room.avatar,
                private_key: member.room.private_key,
                active_room: activeRoomId === member.room.id,
            };

            this.updateUnreadCount();

            if(roomId == activeRoomId) {
                const privateChannel = window.Echo.private('chats.' + roomId);

                privateChannel.listen('.chat_room.seen_all', (e) => {
                    if (parseInt(this.activeRoomId) === parseInt(e.room.id)) {
                        const seenMember = member.room.members.find(member => parseInt(member.user_id) === parseInt(e.user.id) && member.user_table === e.user.user_table)
                        this.rooms[this.activeRoomId].messages.map(message => {
                            message.chat_message_reads.push({
                                'chat_member_id': seenMember.id,
                                'created_at': new Date(),
                            })
    
                            return message;
                        })
                    }
                })

                privateChannel.listen('.chat_room.message', (e) => {
                    const decryptedMessage = this.handleNewMessage(e.encryptedMessage, roomId);
                    const isOwnMessage = decryptedMessage.member?.user_table === me.user_table && decryptedMessage.member?.user_id === me.user_id;
                    if (!isOwnMessage) {
                        if (this.activeRoomId == roomId) {
                            this.activeRoomNewMessages++;
                        }
                    }
                }).listenForWhisper('typing', (e) => {
                    const room = this.rooms[roomId];
                    if (room.active_members[e.user] && this.activeRoomId == e.roomId) {
                        room.active_members[e.user].typing = e.typing;
                        this.activeRoomTyping = Object.values(room.active_members).some(m => m.typing);
                    }
                }).listenForWhisper('seen', (e) => {
                    if (this.rooms[roomId].active_members[e.user] && parseInt(this.activeRoomId) === parseInt(e.room_id)) {
                        this.rooms[this.activeRoomId].messages.map(message => {
                            if (message.id == e.message_id || message.uuid === e.message_id) {
                                message.chat_message_reads.push({
                                    'chat_member_id': e.chat_member_id,
                                    'created_at': e.read_at,
                                })
                            }
                            return message;
                        })
                    }
                });

                this.rooms[roomId].privateChannel = privateChannel;
            }
        }
    },

    handleNewMessage(encryptedMessage, roomId) {
        const me = this.rooms[roomId].me;
        const decryptedMessage = JSON.parse(ChatService.decryptMessage(encryptedMessage, this.rooms[roomId].private_key));
        this.last_message[roomId] = decryptedMessage;
        if (this.rooms[roomId].messages.some(m => m.id === decryptedMessage.id)) {
            // Message already exists, no need to process further
            return;
        }

        const isOwnMessage = decryptedMessage.member?.user_table === me.user_table && decryptedMessage.member?.user_id === me.user_id;
        if (!isOwnMessage) {
            this.rooms[roomId].messages.push(decryptedMessage);
            if (this.activeRoomId != roomId) {
                this.rooms[roomId].unread_count++;
                this.updateUnreadCount();
                this.activeRoomNewMessages++;
            }
        }

        return decryptedMessage;
    },

    updateUnreadCount() {
        this.unreadCount = 0;
        for (const room of Object.values(this.rooms)) {
            this.unreadCount += room.unread_count > 0 ? 1 : 0;
        }
    },

    async loadMessages() {
        const room = this.rooms[this.activeRoomId];
        if (room) {
            const res = await ChatService.getMessages(room.id, room.messages.length, 10);
            for (const message of res.data) {
                if (!room.messages.find(m => m.id === message.id)) {
                    room.messages.unshift(message);
                }
            }
        }
    },

    activeRoom() {
        return this.rooms[this.activeRoomId];
    },

    canViewMessage(message) {
        return message.display_type === window.chat_consts.display_types.all ||
            (message.display_type === window.chat_consts.display_types.admin && this.userType === window.chat_consts.display_types.admin) ||
            (message.display_type === window.chat_consts.display_types.user && this.userType === window.chat_consts.display_types.user);
    },

    isSystemMessage(message) {
        return message.message_type === window.chat_consts.message_types.status ||
            message.message_type === window.chat_consts.message_types.userAction ||
            message.message_type === window.chat_consts.message_types.help;
    },
});
