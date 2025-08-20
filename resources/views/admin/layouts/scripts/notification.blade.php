<script type='module'>
    var channel = window.Echo.private('{{str_replace('{id}', auth()->user()->id, config('notification.notification_channels.admin')) }}');
    var notificationSound = new Audio('{{ asset('assets/admin/sounds/notification-blip.mp3') }}');
    channel.listen('.{{ config('notification.notification_events.admin.web_notification') }}', function(e) {
        Alpine.store('notification').addNotification(e.notification);
        notificationSound.play();
    });

    Alpine.store('notification').initNotifications(
        @json(auth()->user()->getLatestSimplifiedNotifications(10)),
        {!! auth()->user()->unreadNotifications()->count() !!}
    )
    if (window.routes === undefined) window.routes = {};
    window.routes['notifications.index'] = '{{ route('admin.notifications.index') }}';
    window.routes['notifications.mark_all_as_read'] = '{{ route('admin.notifications.mark_all_as_read') }}';
    window.routes['notifications.mark_as_read'] = '{{ route('admin.notifications.mark_as_read', ['notification' => ':notification:']) }}';
</script>
