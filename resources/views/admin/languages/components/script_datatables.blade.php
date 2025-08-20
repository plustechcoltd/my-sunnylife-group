<script>
  let dataTableLanguage = @json(trans('datatable'));

  $(document).ready(function() {
    const tableId = 'language-table';
    const config = {
      tableId: tableId,
      ajax: {
        url: "{{ route('admin.languages.index') }}",
        type: "GET",
        beforeSend: function(){
          $(`#${tableId} > tbody`).html(
            `<tr class="odd">
              <td valign="top" colspan="6" class="dataTables_empty">${dataTableLanguage.loadingRecords}</td>
            </tr>`
          );
        },
      },
      columns: [
        {'data': 'id'},
        {'data': 'code'},
        // {'data': 'flag'},
        {
            data: null,
            sortable: false,
            render: function (data) {
                return `<span class="border fi fi-${data.flag}"></span>`;
            },
        },
        {'data': 'label'},
        {'data': 'default_yn'},
        {'data': 'sortno'},
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
      columnDefs: [
        { "orderable": false, "targets": [1, 2, 3, 4, 6] },
      ],
      order: [[5, 'desc']],
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
