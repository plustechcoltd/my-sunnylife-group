<script>
  let dataTableLanguage = @json(trans('datatable'));

  $(document).ready(function() {
    const config = {
      tableId: 'admin-table',
      ajaxUrl: "{{ route('admin.admins.index') }}",
      columns: [
        {'data': 'id'},
        {'data': 'full_name'},
        {'data': 'email'},
        {'data': 'phone'},
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
      language: dataTableLanguage,
    };

    initializeDataTable(config);

    $(document).on('click', '.delete-button', function(event) {
      event.preventDefault();
      const form = $(this).closest('form');
      deleteConfirm(form.attr('action'), form.data('id'));
    });
  });
</script>
