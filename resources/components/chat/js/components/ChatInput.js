import Alpine from 'alpinejs';
import ChatService from '../services/ChatService.js';
import {v4 as uuid} from 'uuid';

Alpine.data('chat_input', () => ({
    message: '',
    selectedFile: null,
    filePreview: '',
    typingTimer: null,
    isCurrentlyTyping: false,

    debounce(func, wait) {
        let timeout;
        return function (...args) {
            const context = this;
            clearTimeout(timeout);
            timeout = setTimeout(() => func.apply(context, args), wait);
        };
    },

    init() {
        this.debounceSend = this.debounce(this.send, 100);
    },

    adjustHeight() {
        const input = this.$refs.chatInput;

        // Reset height to calculate actual scroll height
        input.style.height = 'auto';

        // Calculate the height and adjust dynamically
        const scrollHeight = input.scrollHeight;
        input.style.height = `${Math.min(scrollHeight, 120)}px`; // 120px corresponds to 4 lines

        // Show scrollbar only if content height exceeds max height (120px)
        if (scrollHeight > 120) {
            input.style.overflowY = 'auto'; // Show scrollbar
        } else {
            input.style.overflowY = 'hidden'; // Hide scrollbar
        }
    },

    onAddLine() {
        const input = this.$refs.chatInput;
        const startPos = input.selectionStart;
        const endPos = input.selectionEnd;

        this.message = this.message.substring(0, startPos) + '\n' + this.message.substring(endPos);
        const newCursorPosition = startPos + 1;

        this.$nextTick(() => {
            this.adjustHeight();
            input.focus();
            input.setSelectionRange(newCursorPosition, newCursorPosition);

            // Calculate the current line number
            const lines = this.message.substr(0, newCursorPosition).split('\n');
            const currentLineNumber = lines.length;

            // Calculate the target scroll position
            const lineHeight = parseInt(window.getComputedStyle(input).lineHeight);
            const targetScrollTop = (currentLineNumber - 1) * lineHeight;

            // Smoothly scroll to the target position
            this.smoothScroll(input, targetScrollTop);
        });
    },

    smoothScroll(element, targetScrollTop, duration = 300) {
        const start = element.scrollTop;
        const change = targetScrollTop - start;
        const startTime = performance.now();

        function animateScroll(currentTime) {
            const elapsedTime = currentTime - startTime;
            if (elapsedTime > duration) {
                element.scrollTop = targetScrollTop;
            } else {
                const progress = elapsedTime / duration;
                element.scrollTop = start + change * easeInOutQuad(progress);
                requestAnimationFrame(animateScroll);
            }
        }

        function easeInOutQuad(t) {
            return t < 0.5 ? 2 * t * t : -1 + (4 - 2 * t) * t;
        }

        requestAnimationFrame(animateScroll);
    },

    async debounceSend(event) {
        await this.debounceSend(event);
    },

    async send(e) {
        if (!e.ctrlKey && !e.shiftKey) {
            let message = this.message.trim();
            this.message = '';
            this.filePreview = '';
            const activeRoomId = this.$store.chat.activeRoomId;

            if (this.selectedFile) {
                const formData = new FormData();
                formData.append('file', this.selectedFile);
                formData.append('message', message);

                const tempId = uuid()
                // Create a local file message object
                let localMessage = {
                    'id': tempId,
                    'uuid': tempId,
                    'chat_room_id': activeRoomId,
                    'chat_member_id': this.$store.chat.rooms[activeRoomId].me.id,
                    'message_type': window.chat_consts.message_types.file,
                    'message': message,
                    'created_at': new Date().toISOString(),
                    'display_type': window.chat_consts.display_types.all,
                    'chat_message_reads': [],
                    'member': {
                        'user_table': this.$store.chat.rooms[activeRoomId].me.user_table,
                        'user_id': this.$store.chat.rooms[activeRoomId].me.user_id,
                    },
                    'chat_file': {
                        'file_name': this.selectedFile.name,
                        'file_type': this.selectedFile.type,
                    },
                    'upload_failed': false, // Add a flag for upload status
                    'loading': true // Add a loading flag
                };

                // Add the local message to the chat room messages
                this.$store.chat.rooms[activeRoomId].messages.push(localMessage);
                this.$refs.message_stack.scrollTop = this.$refs.message_stack.scrollHeight;

                try {
                    const response = await ChatService.sendMessageWithFile(activeRoomId, formData);
                    const messageId = response.data.message_id;

                    localMessage.id = messageId;
                    localMessage.uuid = messageId;
                    localMessage.loading = false;
                    this.$store.chat.rooms[activeRoomId].messages = this.$store.chat.rooms[activeRoomId].messages.map(msg =>
                        msg.id === localMessage.id ? {...msg, id: messageId, loading: false} : msg
                    );
                } catch (error) {
                    // Mark the message as failed
                    localMessage.upload_failed = true;
                    localMessage.loading = false;
                    // Update the message in the store to trigger reactivity
                    this.$store.chat.rooms[activeRoomId].messages = this.$store.chat.rooms[activeRoomId].messages.map(msg =>
                        msg.id === localMessage.id ? {...msg, upload_failed: true, loading: false} : msg
                    );
                }

                this.selectedFile = null;
            } else if (message.length) {
                const tempId = uuid()
                const dataMessage = {
                    'id': tempId,
                    'uuid': tempId,
                    'chat_room_id': activeRoomId,
                    'chat_member_id': this.$store.chat.rooms[activeRoomId].me.id,
                    'message_type': window.chat_consts.message_types.text,
                    'message': message,
                    'created_at': new Date().toISOString(),
                    'display_type': window.chat_consts.display_types.all,
                    'chat_message_reads': [],
                    'member': {
                        'user_table': this.$store.chat.rooms[activeRoomId].me.user_table,
                        'user_id': this.$store.chat.rooms[activeRoomId].me.user_id,
                    },
                };

                // push message to show real-time
                this.$store.chat.rooms[activeRoomId].messages.push(dataMessage);

                // change uuid of message to id when saved successfully
                ChatService.sendMessage(activeRoomId, message, tempId).then(response => {
                    this.$store.chat.rooms[activeRoomId].messages.map(message => {
                        if (message.uuid === tempId && response?.data?.id) {
                            message.uuid = response.data.id;
                        }

                        return message;
                    })
                });
                // Scroll to bottom
                this.$refs.message_stack.scrollTop = this.$refs.message_stack.scrollHeight;
            }
            this.resetTextareaHeight();
        }
    },

    resetTextareaHeight() {
        const input = this.$refs.chatInput;
        input.style.height = `40px`;
        input.style.overflowY = 'hidden';
    },

    onInputChange(event) {
        const room = this.$store.chat.activeRoom();

        // Clear existing debounce timer
        if (this.typingTimer) {
            clearTimeout(this.typingTimer);
        }

        // Send 'typing: true' immediately if not already typing
        if (!this.isCurrentlyTyping) {
            room.privateChannel.whisper('typing', {
                user: `${room.me.user_table}_${room.me.user_id}`,
                typing: true,
                roomId: room.id
            });
            this.isCurrentlyTyping = true;
        }

        // Debounce 'typing: false'
        this.typingTimer = setTimeout(() => {
            room.privateChannel.whisper('typing', {
                user: `${room.me.user_table}_${room.me.user_id}`,
                typing: false,
                roomId: room.id
            });
            this.isCurrentlyTyping = false;
        }, 1000);
    },

    async uploadFile(event) {
        const file = event.target.files[0];
        if (file) {
            this.selectedFile = file;
            this.filePreview = URL.createObjectURL(file);
        }
    },

    removeFile() {
        this.selectedFile = null;
        this.filePreview = '';
    }
}));