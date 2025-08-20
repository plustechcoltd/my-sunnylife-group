<div class="message-wrapper">
    <template x-if="message.message_type === window.chat_consts.message_types.text || message.message_type === window.chat_consts.message_types.file">
        <div class="hstack gap-3 mr-3"
             :class="messageIsMine(message) ? 'media-chat-item-reverse' : ''">
            <a href="#" class="d-block status-indicator-container">
                <div class="w-40px h-40px rounded-pill bg-size-100"
                     :style="`background: url(${messageOwnerAvatar(message)});`">
                </div>
                <span class="status-indicator"
                      :class="messageOwnerOnline(message) ? 'bg-success' : 'bg-warning'">
                </span>
            </a>

            <div class="flex-grow-1 overflow-hidden">
                <div class="media-chat-message">
                    <div class="fs-sm lh-sm">
                        <span class="fw-semibold" x-text="messageOwnerName(message)"></span>
                        <span class="opacity-50 ms-2"
                              x-data="chat_time_interval"
                              x-intersect:enter="startUpdate(message.created_at)"
                              x-intersect:leave="stopUpdate()"
                              x-text="timeAgo">
                        </span>
                    </div>
                    <template x-if="message.message_type === window.chat_consts.message_types.text">
                        <span class="w-100" x-html="messageContent(message)" x-intersect:enter.once="handleMarkMessageAsRead(message)"></span>
                    </template>
                    <template x-if="message.message_type === window.chat_consts.message_types.file">
                        <div :class="{'border border-danger p-2': message.upload_failed}" x-intersect:enter.once="handleMarkMessageAsRead(message)">
                            <p x-text="message.message"></p>
                            <template x-if="message.chat_file.file_type.startsWith('image/')">
                                <template x-if="!message.loading">
                                    <a :href="getChatFileUrl(message.id)" target="_blank">
                                        <img :src="getChatFileUrl(message.id)" alt="File" class="img-thumbnail mw-300">
                                    </a>
                                </template>
                            </template>
                            <template x-if="!message.chat_file.file_type.startsWith('image/')">
                                <a :href="getChatFileUrl(message.id)" target="_blank" class="btn btn-white">
                                    <i class="ph-paperclip me-2"></i> <span x-text="message.chat_file.file_name"></span>
                                </a>
                            </template>
                            <template x-if="message.upload_failed">
                                <p class="text-white mt-2 text-center">Upload error!</p>
                            </template>
                            <div class="d-block mt-2 text-center">
                                <span x-show="message.loading" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                <span x-show="!message.loading" class="text-success text-dark">
                                    <i class="ph-check-circle"></i>
                                </span>
                            </div>
                        </div>
                    </template>
                </div>
                <template x-if="getSeenText(message)">
                    <div class="text-muted">
                        <i class="ph-checks text-primary"></i>{{ __('label.labels.seen') }}
                        <span x-text="getSeenText(message)"></span>
                    </div>
                </template>
            </div>
        </div>
    </template>

    <template x-if="$store.chat.canViewMessage(message) && $store.chat.isSystemMessage(message)">
        <div class="content-divider justify-content-center text-muted mx-0">
            <span class="px-2" x-html="generateSystemMessage(message)" x-intersect:enter.once="handleMarkMessageAsRead(message)"></span>
        </div>
    </template>
</div>