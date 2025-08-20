<!-- Notifications -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="notifications" x-data="notification_box">
    <div class="d-flex offcanvas-header py-0 border-bottom">
        <h5 class="offcanvas-title py-3">通知</h5>
        <div>
        <a href="#" x-on:click.prevent="markAllAsRead" class="text-body badge badge-sm bg-light">
            <i class="ph-checks me-1"></i>
            すべて既読にする
        </a>
        <button type="button" class="btn btn-light btn-sm btn-icon border-transparent rounded-pill" data-bs-dismiss="offcanvas">
            <i class="ph-x"></i>
        </button>
        </div>
    </div>

    <div class="offcanvas-body p-0">
        <div class="list-group list-group-flush">
            <template x-for="notification in all_notifications" :key="notification.id">
                @include('web.components.notification.template')
            </template>
        </div>
        <div class="p-1">
            <div class="text-center" x-intersect="loadMore">
                <div class="spinner-border" role="status" x-show="loading">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /notifications -->
