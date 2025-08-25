@extends('admin.layouts.master')
@section('title')
    {{ __('label.tables.city_groups') }}
@endsection

@section('page-header')
    @component('admin.components.breadcrumb')
        @slot('hide_title_breadcrumb')@endslot
        @slot('title') {{ __('label.tables.city_groups') }}{{ __('label.labels.list') }} @endslot
        @slot('subtitle') {{ __('label.tables.city_groups') }} @endslot
        @slot('button')
            <div class="my-auto ms-auto">
                <a href="{{ route('admin.city_groups.create') }}" class="btn btn-info">
                    {{ __('label.buttons.create') }}
                </a>
            </div>
        @endslot
    @endcomponent
@endsection

@section('content')
    <div class="content">
        <div class="card">
            <div class="card-body">
                <table class="table datatable-selection-single" id="city_group-table">
                    <thead>
                    <tr>
                        <th>{{ __('label.columns.common.id') }}</th>
                        <th>{{ __('label.columns.city_groups.name') }}</th>
                        <th>{{ __('label.columns.city_groups.cities_count') }}</th>
                        <th>{{ __('label.columns.common.sortno') }}</th>
                        <th class="text-center">{{ __('label.columns.common.actions') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- /single row selection -->
    </div>
@endsection

@section('scripts')
    <script>
      let dataTableLanguage = @json(trans('datatable'));
      let editText = '@lang('label.buttons.edit')';
      let deleteText = '@lang('label.buttons.delete')';

      $(document).ready(function() {
        const config = {
          tableId: 'city_group-table',
          ajaxUrl: "{{ route('admin.city_groups.index') }}",
          columns: [
            {'data': 'id'},
            {'data': 'name'},
            {'data': 'cities_count'},
            {'data': 'sortno'},
            {
              data: null,
              render: function(data, type, row) {
                return`<div class="text-center">
                  <div class="d-inline-flex">
                    <div class="dropdown">
                      <a href="#" class="text-body" data-bs-toggle="dropdown">
                        <i class="ph-list"></i>
                      </a>
                      <div class="dropdown-menu dropdown-menu-end">
                        <a href="${data.edit_url}" class="dropdown-item">
                          <i class="ph-note-pencil me-2"></i>
                          ${editText}
                        </a>
                        <form method="POST" action="${data.destroy_url}" class="delete-form" data-id="${data.id}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="dropdown-item delete-button">
                                <i class="ph-trash me-2"></i>${deleteText}
                            </button>
                        </form>
                      </div>
                    </div>
                  </div>
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
          deleteConfirm(form.attr('action'), form.data('id'), '市区町村グループを削除');
        });
      });
    </script>
@endsection
