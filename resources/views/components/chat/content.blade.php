@php
    $chatRoomId = request()->route('chat')->id;
    $userChatStatus = getUserChatStatus($chatRoomId);
@endphp

<div class="card" x-data="{ userChatStatus: '{{ $userChatStatus }}', ...chat_content() }" x-intersect="markAllMessageAsRead">
    <div class="card-header">
        <h5 class="mb-0 float-start chat-truncate" x-text="getRoomName()"></h5>
        <template x-if="$store.chat.userType === 'admin' && userChatStatus === '{{ $statuses['joined'] }}'">
            <div class="dropdown float-end">
                <a href="#" class="text-body" data-bs-toggle="dropdown">
                    <i class="ph-dots-three-vertical"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-end">
                    <a href="#" class="dropdown-item" @click="confirmLeaveChat">
                        <i class="ph-arrow-right me-2"></i>
                        {{ __('label.labels.leave_chat') }}
                    </a>
                </div>
            </div>
        </template>
    </div>

    <div class="card-body">
        <template x-if="userChatStatus === '{{ $statuses['pending'] }}'">
            @include('components.chat.join')
        </template>
        <template x-if="userChatStatus !== '{{ $statuses['pending'] }}'">
            <div class="media-chat-scrollable mb-3" :class="{'opacity-50': userChatStatus === '{{ $statuses['left'] }}'}" x-ref="message_stack">
                <div class="media-chat-item hstack align-items-start gap-3 mt-3 min-h-40px">
                    <a href="#" class="status-indicator-container" x-show="$store.chat.activeRoomTyping">
                        <div class="w-40px h-40px rounded-pill bg-size-100"
                             :style="`background: url(${typingAvatar()});`">
                        </div>
                        <span class="status-indicator bg-success"></span>
                    </a>
                    <div class="align-self-center" x-show="$store.chat.activeRoomTyping">
                        <span class="fw-semibold" x-text="typingUserName()"></span>{{ __('label.labels.is_typing') }}
                        <div class="typing-indicator">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                    </div>
                </div>
                <div class="media-chat position-relative">
                    <template x-for="(day, dayIndex) in groupMessagesByDay(messages())" :key="dayIndex">
                        <div class="day-message-group vstack gap-2">
                            <div class="date-separator" x-text="day.date"></div>
                            
                            <template x-for="(message, messageIndex) in day.messages" :key="message.id">
                                @include('components.chat.messages.text')
                            </template>
                        </div>
                    </template>
                    <div class="media-chat-read-area"
                         x-intersect:enter="onShowedLastMessage()"
                         x-intersect:leave="onHidedLastMessage()">
                    </div>
                    <div class="media-chat-scroll-icon">
                        <div class="cursor-pointer" x-show="showScrollToBottom" x-on:click="scrollToBottom()">
                            <span x-show="$store.chat.activeRoomNewMessages > 0" x-text="newMessages()"></span>
                            <i class="ph-arrow-down"></i>
                        </div>
                    </div>
                </div>
                    <div class="text-center pt-4" x-intersect="loadMessages">
                        <div class="spinner-border" role="status" x-show="loading">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
            </div>
        </template>

        <template x-if="userChatStatus === '{{ $statuses['left'] }}'">
            @include('components.chat.join')
        </template>

        <template x-if="userChatStatus === '{{ $statuses['joined'] }}'">
            @include('components.chat.input')
        </template>
    </div>
</div>
