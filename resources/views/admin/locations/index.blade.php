@extends('admin.layouts.master')
@section('title')
    {{ __('label.tables.locations') }}
@endsection

@section('page-header')
    @component('admin.components.page-header')
        @slot('hide_title_breadcrumb')@endslot
        @slot('title') {{ __('label.tables.locations') }}{{ __('label.labels.list') }} @endslot
        @slot('subtitle') {{ __('label.tables.locations') }} @endslot
        @slot('button')
            <div class="my-auto ms-auto">
                <a href="{{ route('admin.locations.export_csv') }}" class="btn btn-info">
                    <i class="icon-download me-1"></i>{{ __('label.buttons.export_csv') }}
                </a>
                <a href="{{ route('admin.locations.import_csv') }}" class="btn btn-info">
                    <i class="icon-upload me-1"></i>{{ __('label.buttons.import_csv') }}
                </a>
                <a href="{{ route('admin.locations.create') }}" class="btn btn-info">
                    {{ __('label.buttons.create') }}
                </a>
            </div>
        @endslot
    @endcomponent
@endsection

@section('content')
    <div class="content">
        <div class="col-2 mb-3">
            <div class="form-group mb-2 mr-2">
                <label for="location_group" class="fw-semibold mb-1">{{ __('label.tables.location_groups') }}</label>
                <select name="location_group" id="location_group" class="form-control form-select">
                    <option value="">{{ __('label.labels.all') }}</option>
                    @foreach($location_groups as $key => $location_group)
                        <option value="{{ $location_group->id }}" {{ isset( request()->location_group) && request()->location_group == $location_group->id ? 'selected' : '' }}>{{ $location_group->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <table class="table datatable-selection-single" id="location-table">
                    <thead>
                    <tr>
                        <th>{{ __('label.columns.locations.code') }}</th>
                        <th>{{ __('label.columns.locations.name') }}</th>
                        <th>{{ __('label.columns.locations.contract_number') }}</th>
                        <th>{{ __('label.columns.locations.location_group_name') }}</th>
                        <th>{{ __('label.columns.contracts.post_input') }}</th>
                        <th>{{ __('label.columns.contracts.referral') }}</th>
                        <th>{{ __('label.columns.contracts.direct') }}</th>
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
          tableId: 'location-table',
          ajaxUrl: "{{ route('admin.locations.index') }}",
          columns: [
            {'data': 'code'},
            {'data': 'name'},
            {'data': 'contract_number'},
            {'data': 'location_group_name'},
            {'data': 'post_input'},
            {'data': 'referral'},
            {'data': 'direct'},
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

        const dataTable = initializeDataTable(config);

        $('#location_group').on('change', function() {
          const locationGroup = $(this).val();
          dataTable.ajax.url(config.ajaxUrl + '?location_group=' + locationGroup).load();
        });

        $(document).on('click', '.delete-button', function(event) {
          event.preventDefault();
          const form = $(this).closest('form');
          deleteConfirm(form.attr('action'), form.data('id'), '医療機関を削除');
        });
      });
    </script>
@endsection
