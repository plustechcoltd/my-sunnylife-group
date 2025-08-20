<div class="sidebar sidebar-secondary sidebar-expand-lg" x-data="chat_sidebar">
    <!-- Sidebar content -->
    <div class="sidebar-content">
        <!-- Start conversation -->
        <div class="sidebar-section">
            <div class="list-group list-group-borderless py-2">
                <div class="list-group-item fw-semibold">{{ __('label.labels.list_room') }}</div>
                <form class="sidebar-section-body" action="#">
                    <div class="form-control-feedback form-control-feedback-end">
                        <input type="search" class="form-control" x-model="searchQuery"
                               placeholder="{{ __('label.labels.search_user_name') }}">
                        <div class="form-control-feedback-icon"><i class="ph-magnifying-glass"></i></div>
                    </div>
                </form>
                <div class="list-room">
                    <template x-for="roomId in $store.chat.sort" :key="roomId">
                        <template x-if="rooms[roomId]">
                            <a :href="getRoomUrl(rooms[roomId])"
                               class="list-group-item list-group-item-action hstack gap-3"
                               :class="{'is-active': isActive(rooms[roomId])}">
                                <div class="status-indicator-container">
                                    <div class="w-40px h-40px rounded-circle bg-size-100"
                                         :style="`background: url(${rooms[roomId].avatar});`">
                                    </div>
                                    <template x-if="unreadCount(rooms[roomId]) > 0">
                                    <span class="badge bg-danger position-absolute top-0 start-100 translate-middle rounded-pill"
                                          x-text="unreadCount(rooms[roomId])"></span>
                                    </template>
                                    <template
                                            x-if="rooms[roomId].type === '{{ \App\Models\ChatRoom::TYPE_SINGULAR }}'">
                                    <span class="status-indicator"
                                          :class="isOnline(rooms[roomId]) ? 'bg-success' : 'bg-warning'"></span>
                                    </template>
                                </div>

                                <div class="flex-fill">
                                    <div class="fw-semibold chat-truncate"
                                         x-html="roomNameMatchesSearchQuery(rooms[roomId])"></div>
                                    <div class="text-muted mw-300 chat-truncate"
                                         :class="unreadCount(rooms[roomId]) ? 'fw-semibold' : ''"
                                         x-html="getLastMessage(rooms[roomId])"></div>
                                    <div class="fs-sm text-muted mt-1">
                                        <div class="time-item"
                                             x-data="chat_time_interval(roomId)"
                                             x-intersect:enter="startUpdate(getLastMessageTime(rooms[roomId]))"
                                             x-intersect:leave="stopUpdate()"
                                             x-text="timeAgo">
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </template>
                    </template>
                </div>
            </div>
        </div>
        <!-- /start conversation -->
    </div>
    <!-- /sidebar content -->
</div>
