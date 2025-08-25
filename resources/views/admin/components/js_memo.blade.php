<script>
    $(document).ready(function (e) {
        $(document).on('click', '.mo-remove_icon_card_admin_note', function () {
            const memo_id = $(this).data('memo_id')
            const url = $(this).data('url')

            $.ajax({
                url: url,
                method: 'DELETE',
                data: {
                    '_token': "{{ csrf_token() }}",
                },
                success: (data) => {
                    $('#memo-' + memo_id).remove()
                }
            })
        });

        function submitAjaxMemo() {
            const memo_description = $('#memo-description').val();
            const url = $('#form-admin_memos').data('url')
            const record_model = $('#form-admin_memos').data('record_model')
            const record_id = $('#form-admin_memos').data('record_id')

            if (memo_description && record_id) {
                $.ajax({
                    url: url,
                    method: 'POST',
                    data: {
                        record_model: record_model,
                        record_id: record_id,
                        memo_description: memo_description,
                        "_token": "{{ csrf_token() }}"
                    },
                    success: (data) => {
                        $('#list-memo').append(`
                        <div class="d-flex align-items-start mb-3" id="memo-${data.data.id}">
                            <a href="#" class="me-3">
                                 {!! Auth::guard('admin')->user()->renderAvatar() !!}
                            </a>
                            <div class="flex-fill">
                                <span>${data.data.description}</span>
                                <div class="fs-sm text-muted mt-1">
                                    <span>{{ \Carbon\Carbon::parse(now())->diffForHumans() . '　' . \Illuminate\Support\Facades\Auth::user()->full_name }}</span>
                                    <a class="cursor-pointer link-teal float-end me-3 mo-remove_icon_card_admin_note" data-memo_id="${data.data.id}" data-url="{{ url('/admin/admin_memos') }}/${data.data.id}">削除</a>
                                </div>
                                </div>
                            </div>
                        `)
                        $("#list-memo").scrollTop($("#list-memo")[0].scrollHeight);
                    }
                })
                $('#memo-description').val("");
            }
        }

        $('#btn-add_memo').on('click', function (e) {
            e.preventDefault()
            submitAjaxMemo()
        });

        // Submit when shift enter
        $("#memo-description").keydown(function (e) {
            // Enter was pressed without shift key
            if (e.key == 'Enter' && e.shiftKey) {
                e.preventDefault();
                submitAjaxMemo()
            }
        });

        $("#list-memo").scrollTop($("#list-memo")[0].scrollHeight);
    });
</script>
