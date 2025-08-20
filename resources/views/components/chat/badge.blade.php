<li class="nav-item nav-item-dropdown-lg dropdown ms-lg-2 chat-badge">
    <a href="#" class="navbar-nav-link navbar-nav-link-icon rounded-pill" data-bs-toggle="dropdown"
       data-bs-auto-close="outside">
        <i class="ph-chats"></i>
        <template x-if="unreadCount" x-data="chat_notification_bell">
            <span x-text="unreadCount"
                  class="badge bg-yellow text-black position-absolute top-0 end-0 translate-middle-top zindex-1 rounded-pill mt-1 me-1">
            </span>
        </template>
    </a>

    <div class="dropdown-menu wmin-lg-350 p-0" x-data="chat_notification_box">
        <div class="d-flex align-items-center p-3">
            <i class="ph-chat transform-scale-x"></i>
            <h6 class="mb-0 ms-1">{{ __('label.labels.new_message') }}
            </h6>
        </div>

        <div class="dropdown-menu-scrollable pb-2 border-top">
            <template x-if="!unreadCount" x-data="chat_notification_bell">
                <div class="py-2 px-3">
                    <div>{{ __('label.labels.badge_no_message') }}</div>
                    <div class="text-center ">
                        <i class="ph-chats font-10em"></i>
                    </div>
                </div>
            </template>

            <template x-for="room in rooms" :key="room.id" class="border-top">
                <a :href="getRoomUrl(room)" class="dropdown-item text-wrap py-2">
                    <div class="status-indicator-container me-3">
                        <div class="w-40px h-40px rounded-circle bg-size-100"
                             :style="`background: url(${room.avatar});`">
                        </div>
                        <template x-if="room.type === '{{ \App\Models\ChatRoom::TYPE_SINGULAR }}'">
                            <span class="status-indicator" :class="isOnline(room) ? 'bg-success' : 'bg-warning'"></span>
                        </template>
                    </div>

                    <div class="flex-fill">
                        <div class="fw-semibold chat-truncate" x-text="room.name"></div>
                        <div class="text-muted chat-truncate mw-300 fw-semibold" x-html="getLastMessage(room)"></div>
                        <div class="text-muted fs-sm time-item"
                             x-data="chat_time_interval(room.id)"
                             x-intersect:enter="startUpdate(getLastMessageTime(room))"
                             x-text="timeAgo">
                        </div>
                    </div>
                </a>
            </template>
        </div>

        <div class="d-flex border-top py-2 px-3">
            <a :href="getAllChatUrl()" class="text-body ms-auto">
                {{ __('label.labels.view_all') }}
                <i class="ph-arrow-circle-right ms-1"></i>
            </a>
        </div>
    </div>
</li>
