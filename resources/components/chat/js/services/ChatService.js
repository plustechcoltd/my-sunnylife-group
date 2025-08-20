import {fetchData, postData} from '../helpers/ajax';
import JSEncrypt from 'jsencrypt';
import { getTranslation } from '../helpers/utils.js';

export default {
    decryptMessage(encryptedMessage, privateKey) {
        const decrypt = new JSEncrypt();
        decrypt.setPrivateKey(privateKey);

        if(Array.isArray(encryptedMessage)) {
            const decryptedChunks = encryptedMessage.map(chunk => {
                    const dec = decrypt.decrypt(chunk);
                    return dec;
                }
            );

            return decryptedChunks.join('');
        }
      
        return decrypt.decrypt(encryptedMessage);
    },

    getMessages: (roomId, start, length) => {
        return fetchData(window.routes['chats.messages'].replace(':chat:', roomId), {start, length});
    },

    sendMessage(roomId, message) {
        return postData(window.routes['chats.messages.store'].replace(':chat:', roomId), {message});
    },

    sendMessageWithFile(roomId, formData) {
        return postData(window.routes['chats.upload_file'].replace(':chat:', roomId), formData);
    },

    markAllMessageAsRead(roomId) {
        return postData(window.routes['chats.mark_as_read'].replace(':chat:', roomId));
    },

    markMessageAsRead(roomId, messageId) {
        return postData(window.routes['chats.mark_as_read'].replace(':chat:', roomId) + '?message_id=' + messageId);
    },

    joinChat(roomId) {
        return postData(window.routes['chats.join'].replace(':chat:', roomId));
    },

    leaveChat(roomId) {
        return postData(window.routes['chats.leave'].replace(':chat:', roomId));
    },

    getRoomUrl(roomId) {
        return window.routes['chats.show'].replace(':chat:', roomId);
    },

    getAllChatUrl() {
        return window.routes['chats.index'];
    },

    generateSystemMessage(message) {
        const extraData = message.extra_data;
        if (extraData && extraData.action) {
            if (extraData.action === window.chat_configs.message_types.status.action.left) {
                return getTranslation('user_left', {name: extraData.user_full_name});
            } else if (extraData.action === window.chat_configs.message_types.status.action.joined) {
                return getTranslation('user_joined', {name: extraData.user_full_name});
            } else if (extraData.action === window.chat_configs.message_types.user_action.action.user_updated) {
                return getTranslation('user_updated', {name: extraData.user_full_name});
            } else if (extraData.action === window.chat_configs.message_types.user_action.action.user_deleted) {
                return getTranslation('user_deleted', {name: extraData.user_full_name});
            }
        }
        return '';
    },

    getLastMessage(lastMessage) {
        switch (lastMessage?.message_type) {
            case window.chat_consts.message_types.text:
                return lastMessage.message;
            case window.chat_consts.message_types.file:
                return getTranslation('last_message_file');
            case window.chat_consts.message_types.status:
                return this.generateSystemMessage(lastMessage);
            case window.chat_consts.message_types.userAction:
                return this.generateSystemMessage(lastMessage);
        
            default:
                break;
        }
    },
};
