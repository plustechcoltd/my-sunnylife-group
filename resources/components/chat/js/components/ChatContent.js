import Alpine from 'alpinejs';
import dayjs from 'dayjs';
import relativeTime from 'dayjs/plugin/relativeTime';
import isToday from 'dayjs/plugin/isToday';
import isSame from 'dayjs/plugin/isSameOrBefore';
import ChatService from '../services/ChatService.js';

dayjs.extend(relativeTime)
dayjs.extend(isToday)
dayjs.extend(isSame)

Alpine.data('chat_content', () => ({
    loading: true,
    joinLoading: false,
    showScrollToBottom: false,
    onlineUsers: [],
    isMarkReadAll: false,

    groupMessagesByDay(messages) {
        const groupedMessages = [];

        messages.forEach((message, index) => {
            const messageDate = this.messageDay(message);

            if (index === 0 || messageDate !== this.messageDay(messages[index - 1])) {
                groupedMessages.push({
                    date: messageDate,
                    messages: [message]
                });
            } else {
                groupedMessages[groupedMessages.length - 1].messages.push(message);
            }
        });

        return groupedMessages;
    },

    init() {
        console.log('Chat Content initialized');
        Alpine.effect(async () => {
            if (this.$store.chat.activeRoomNewMessages > 0) {
                if (this.showScrollToBottom) {

                } else {
                    const room = this.$store.chat.activeRoom();
                    if (room) {
                        this.scrollToBottom();
                    }
                }
            }
            this.onlineUsers = Object.values(this.$store.chat.onlineUsers);
        });
    },

    async loadMessages() {
        this.loading = true;
        await this.$store.chat.loadMessages();
        this.loading = false;
    },

    messages() {
        const room = this.$store.chat.activeRoom();
        if (room) {
            return room.messages;
        }
        return [];
    },

    messageIsMine(message) {
        const room = this.$store.chat.activeRoom();
        if (room) {
            return message.member.user_table === room.me.user_table && message.member.user_id === room.me.user_id;
        }
    },

    isGroup(message) {
        const room = this.$store.chat.rooms[message.chat_room_id]
        return room?.type === window.chat_consts.room_types.group;
    },

    singleChatMessageRead(message) {
        if (this.isGroup(message)) {
            return;
        }

        const room = this.$store.chat.rooms[message.chat_room_id];
        if (!room) {
            return;
        }

        const readInfo = message.chat_message_reads[0];
        if (readInfo?.chat_member_id && parseInt(readInfo.chat_member_id) !== parseInt(room.me.id)) {
            if (readInfo?.created_at) {
                return dayjs(readInfo.created_at).format('H:mm');
            }
        }

        return '';
    },

    groupChatMessageRead(message) {
        if (!this.isGroup(message)) {
            return;
        }

        let list = [];
        const room = this.$store.chat.rooms[message.chat_room_id];
        if (!room) {
            return list;
        }

        message.chat_message_reads.filter(user => {
            if (user.chat_member_id !== room.me.id) {
                const readMember = room.members.find(m => m.id === user.chat_member_id);
                list[user.chat_member_id] = {
                    id: user.chat_member_id,
                    avatar: readMember?.avatar,
                    seen_at: dayjs(user.created_at).format('H:mm'),
                    name: readMember?.full_name,
                }
            }
        })

        return list
            .filter(member => member.name && member.name.length > 0)
            .map(member => member.name)
            .join(', ');
    },

    messageOwnerName(message) {
        const room = this.$store.chat.activeRoom();
        if (room) {
            const member = room.members.find(m => m.id === message.chat_member_id);
            if (member) {
                return member.full_name;
            }
        }
        return '';
    },

    messageOwnerAvatar(message) {
        const room = this.$store.chat.activeRoom();
        if (room) {
            const member = room.members.find(m => m.id === message.chat_member_id);
            if (member) {
                return member.avatar;
            }
        }
        return '';
    },

    messageOwnerOnline(message) {
        return this.onlineUsers.some(user => {
            return message.member.user_table + '_' + message.member.user_id == user.id;
        });
    },

    generateSystemMessage(message) {
        return ChatService.generateSystemMessage(message);
    },

    messageContent(message) {
        const content = message?.message || '';
        return content.replace(/\n/g, '<br>');
    },

    handleMarkMessageAsRead(message) {
        if (this.isMarkReadAll) {
            return;
        }
        const me = this.$store.chat.rooms[message.chat_room_id].me;
        const room = this.$store.chat.activeRoom();
        if (message.chat_message_reads.filter(m => m.chat_member_id === me.id).length > 0) {
            return;
        }
        if (message.chat_member_id === me.id) {
            return;
        }

        // decremented unread_count
        this.$store.chat.activeRoomNewMessages--;

        room.privateChannel.whisper('seen', {
            user: room.me.user_table + '_' + room.me.user_id,
            message_id: message.id,
            room_id: room.id,
            chat_member_id: room.me.id,
            read_at: new Date(),
        }, 1000);

        return ChatService.markMessageAsRead(message.chat_room_id, message.id);
    },

    messageDay(message) {
        const time = dayjs(message.created_at);
        return time.format('DD-MM-YYYY');
    },

    isSameDay(message1, message2) {
        return dayjs(message1.created_at).isSame(message2.created_at, 'day');
    },

    getTypingMember() {
        const room = this.$store.chat.activeRoom();
        if (room) {
            const otherMembers = room.members.filter(m => (m.user_table + '_' + m.user_id) !== (room.me.user_table + '_' + room.me.user_id));
            const typingMember = otherMembers.find(m => room.active_members[m.user_table + '_' + m.user_id] && room.active_members[m.user_table + '_' + m.user_id].typing);
            if (typingMember) {
                return typingMember;
            }
        }

        return false;
    },

    typingUserName() {
        const typingMember = this.getTypingMember();
        if (typingMember) {
            return typingMember.full_name;
        }

        return '';
    },

    typingAvatar() {
        const typingMember = this.getTypingMember();
        if (typingMember) {
            return typingMember.avatar;
        }
        return '/images/default_avatar.jpg';
    },

    async markAllMessageAsRead() {
        const room = this.$store.chat.activeRoom();
        if (room && !this.isMarkReadAll) {
            this.isMarkReadAll = true;

            if (this.showScrollToBottom) {
                this.isMarkReadAll = false;
                return;
            }
            if (!this.$store.chat.activeRoomNewMessages && !room.unread_count) {
                this.isMarkReadAll = false;
                return;
            }

            await ChatService.markAllMessageAsRead(room.id);
            this.isMarkReadAll = false;
            room.unread_count = 0;
            this.$store.chat.activeRoomNewMessages = 0;
            this.$store.chat.updateUnreadCount();
        }
    },

    async scrollToBottom() {
        this.$refs.message_stack.scrollTop = this.$refs.message_stack.scrollHeight;
        this.showScrollToBottom = false;
        await this.markAllMessageAsRead();
    },

    onShowedLastMessage() {
        console.log('Show last message');
        this.showScrollToBottom = false;
    },

    onHidedLastMessage() {
        console.log('Hide last message');
        this.showScrollToBottom = true;
    },

    newMessages() {
        if (this.$store.chat.activeRoomNewMessages) {
            let count = this.$store.chat.activeRoomNewMessages + ' ';
            if (this.$store.chat.activeRoomNewMessages > 99) {
                count = '+99 ';
            }
            return count + window.new_message;
        }
    },

    joinChat() {
        this.joinLoading = true;
        ChatService.joinChat(this.$store.chat.activeRoomId).then(response => {
            if (response.data.status === window.chatStatuses.joined) {
                this.$store.chat.activeRoom().me.status = window.chatStatuses.joined;
                this.userChatStatus = window.chatStatuses.joined;
            }
        }).finally(() => {
            this.joinLoading = false;
        });
    },

    confirmLeaveChat() {
        let swalInit = Swal.mixin({
            buttonsStyling: false,
            customClass: {
                confirmButton: 'btn btn-primary',
                cancelButton: 'btn btn-light',
                denyButton: 'btn btn-light',
                input: 'form-control',
            },
        });

        swalInit.fire({
            title: 'Are you sure?',
            text: 'You will leave this chat and won\'t be able to chat anymore!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, just leave!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                this.leaveChat();
            }
        });
    },

    leaveChat() {
        ChatService.leaveChat(this.$store.chat.activeRoomId).then(response => {
            if (response.data.status === window.chatStatuses.left) {
                this.$store.chat.activeRoom().me.status = window.chatStatuses.left;
                this.userChatStatus = window.chatStatuses.left;
            }
        });
    },

    getChatFileUrl(message) {
        return window.routes['chats.show_file'].replace(':message:', message);
    },

    getSeenText(message) {
        if (this.isGroup(message)) {
            return this.getGroupSeenText(message);
        }

        return this.getSingularSeenText(message);
    },

    getSingularSeenText(message) {
        const room = this.$store.chat.rooms[message.chat_room_id];
        if (!room) {
            return;
        }

        const readInfo = message.chat_message_reads ? message.chat_message_reads[0] : null;
        if (readInfo?.chat_member_id && parseInt(readInfo.chat_member_id) !== parseInt(room.me.id)) {
            if (readInfo?.created_at) {
                return dayjs(readInfo.created_at).format('H:mm');
            }
        }
    },

    getGroupSeenText(message) {
        let list = [];
        const room = this.$store.chat.rooms[message.chat_room_id];
        if (!room) {
            return list;
        }

        message.chat_message_reads.filter(user => {
            if (user.chat_member_id !== room.me.id && user.chat_member_id != message.chat_member_id) {
                const readMember = room.members.find(m => m.id === user.chat_member_id);
                list[user.chat_member_id] = {
                    id: user.chat_member_id,
                    avatar: readMember?.avatar,
                    seen_at: dayjs(user.created_at).format('H:mm'),
                    name: readMember?.full_name,
                }
            }
        })

        return list
            .filter(member => member.name && member.name.length > 0)
            .map(member => member.name)
            .join(', ');
    },

    getRoomName() {
        const room = this.$store.chat.activeRoom();
        return room?.name || '';
    },
}));
