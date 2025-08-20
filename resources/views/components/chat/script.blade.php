<script type='module'>
    window.chatStatuses = @json($statuses);
    console.log(`start initChat`);
    Alpine.store('chat').initChat(
        @json($members),
        {!! isset($room) ? $room->id : 'null' !!},
        '{{ $userType }}'
    )
    if (window.routes === undefined) window.routes = {};

    @if($userType == config('const.user_types.admin'))
        window.routes['chats.messages'] = '{{ route("admin.chats.messages", ['chat' => ':chat:']) }}';
        window.routes['chats.messages.store'] = '{{ route("admin.chats.messages.store", ['chat' => ':chat:']) }}';
        window.routes['chats.mark_as_read'] = '{{ route("admin.chats.mark_as_read", ['chat' => ':chat:']) }}';
        window.routes['chats.show'] = '{{ route("admin.chats.show", ['chat' => ':chat:']) }}';
        window.routes['chats.upload_file'] = '{{ route("admin.chats.upload_file", ['chat' => ':chat:']) }}';
        window.routes['chats.show_file'] = '{{ route("admin.chats.show_file", ['message' => ':message:']) }}';
        window.routes['chats.index'] = '{{ route("admin.chats.index") }}';
        window.routes['chats.join'] = '{{ route("admin.chats.join", ['chat' => ':chat:']) }}';
        window.routes['chats.leave'] = '{{ route("admin.chats.leave", ['chat' => ':chat:']) }}';
    @else
        window.routes['chats.messages'] = '{{ route("web.chats.messages", ['chat' => ':chat:']) }}';
        window.routes['chats.messages.store'] = '{{ route("web.chats.messages.store", ['chat' => ':chat:']) }}';
        window.routes['chats.mark_as_read'] = '{{ route("web.chats.mark_as_read", ['chat' => ':chat:']) }}';
        window.routes['chats.show'] = '{{ route("web.chats.show", ['chat' => ':chat:']) }}';
        window.routes['chats.upload_file'] = '{{ route("web.chats.upload_file", ['chat' => ':chat:']) }}';
        window.routes['chats.show_file'] = '{{ route("web.chats.show_file", ['message' => ':message:']) }}';
        window.routes['chats.index'] = '{{ route("web.chats.index") }}';
    @endif

    window.translations = {
        user_left: "{{ __('message.user_left') }}",
        user_joined: "{{ __('message.user_joined') }}",
        user_updated: "{{ __('message.user_updated') }}",
        user_deleted: "{{ __('message.user_deleted') }}",
        last_message_file: `{!! __('message.last_message_file') !!}`
    };

    window.chat_configs = @json(config('chat'));
    window.new_message = @json(__('label.labels.new_message'));

    window.chat_consts = {
        display_types: {
            all: '{{ \App\Models\ChatMessage::DISPLAY_TYPE_ALL }}',
            user: '{{ \App\Models\ChatMessage::DISPLAY_TYPE_USER }}',
            admin: '{{ \App\Models\ChatMessage::DISPLAY_TYPE_ADMIN }}',
        },
        message_types: {
            // common
            text: '{{ \App\Models\ChatMessage::MESSAGE_TYPE_TEXT }}',
            file: '{{ \App\Models\ChatMessage::MESSAGE_TYPE_FILE }}',
            // system
            status: '{{ \App\Models\ChatMessage::MESSAGE_TYPE_STATUS }}',
            userAction: '{{ \App\Models\ChatMessage::MESSAGE_TYPE_USER_ACTION }}',
            help: '{{ \App\Models\ChatMessage::MESSAGE_TYPE_HELP }}',
            // to-do
            todo: '{{ \App\Models\ChatMessage::MESSAGE_TYPE_TODO }}',
        },
        room_types: {
            singular: @json(\App\Models\ChatRoom::TYPE_SINGULAR),
            group: @json(\App\Models\ChatRoom::TYPE_GROUP),
        }
    };
</script>
