<div class="notification-template">
    <div @click.prevent="markAsRead(notification.id, notification.redirect_url)" class="bg-light list-group-item d-flex align-items-start cursor-pointer"
            :class="{'bg-light': notification.read_yn == 'y'}">
        <div class="me-3">
            <div class="bg-warning bg-opacity-10 text-warning rounded-pill">
                <i class="ph-warning p-2"></i>
            </div>
        </div>
        <div class="flex-1">
            <span x-html="notification.message"></span>
            <div class="fs-sm text-muted mt-1" x-text="timeAgo(notification.created_at)"></div>
        </div>
    </div>
</div>
