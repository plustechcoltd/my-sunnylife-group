<script>
    let dataTableLanguage = @json(trans('datatable'));

    $(document).ready(function () {
        const config = {
            tableId: 'user-table',
            ajaxUrl: "{{ route('admin.users.index') }}",
            columns: [
                {'data': 'id'},
                {'data': 'family_name'},
                {'data': 'first_name'},
                {'data': 'email'},
                {'data': 'created_at'},
                {
                    data: null,
                    sortable: false,
                    render: function (data) {
                        return `<div class="d-inline-flex w-100 justify-content-center">
                <a href="${data.edit_url}"><i class="ph-note-pencil me-2"></i></a>
                <form method="POST" action="${data.destroy_url}" class="delete-form" data-id="${data.id}">
                  @csrf
                        @method('DELETE')
                        <button type="submit" class="dropdown-item delete-button text-danger">
                          <i class="ph-trash"></i>
                        </button>
                      </form>
                      </div>`;
                    },
                },
            ],
            buttons: [
                {
                    text: 'Export CSV',
                    className: 'btn btn-success',
                    action: function (event) {
                        event.preventDefault();
                        $(event.currentTarget).prop('disabled', true);
                        $.ajax({
                            url: @json(route('admin.users.export_csv')),
                            type: "POST",
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            xhrFields: {
                                responseType: 'blob'
                            },
                            success: function (response) {
                                const blob = new Blob([response], {type: 'text/csv'});
                                const url = window.URL.createObjectURL(blob);
                                const a = document.createElement('a');
                                a.style.display = 'none';
                                a.href = url;
                                a.download = '{{ trans('label.tables.users') }}.csv';
                                document.body.appendChild(a);
                                a.click();
                                window.URL.revokeObjectURL(url);
                                $(event.currentTarget).prop('disabled', false);
                            },
                            error: function () {
                                $(event.currentTarget).prop('disabled', false);
                            }
                        });
                    },
                },
                {
                    text: 'Import CSV',
                    className: 'btn btn-primary',
                    action: function () {
                        window.open("{{ route('admin.users.import') }}", '_blank');
                    },
                },
            ],
            language: dataTableLanguage,
        };

        initializeDataTable(config);

        $(document).on('click', '.delete-button', function (event) {
            event.preventDefault();
            const form = $(this).closest('form');
            deleteConfirm(form.attr('action'), form.data('id'));
        });
    });
</script>
