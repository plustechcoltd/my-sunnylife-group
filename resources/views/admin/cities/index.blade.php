@extends('admin.layouts.master')
@section('title')
    {{ __('label.tables.cities') }}
@endsection

@section('page-header')
    @component('admin.components.breadcrumb')
        @slot('hide_title_breadcrumb')@endslot
        @slot('title') {{ __('label.tables.cities') }}{{ __('label.labels.list') }} @endslot
        @slot('subtitle') {{ __('label.tables.cities') }} @endslot
    @endcomponent
@endsection

@section('content')
    <div class="content">
        <div class="col-2 mb-3">
            <div class="form-group mb-2 mr-2">
                <label for="city_group" class="fw-semibold mb-1">{{ __('label.tables.city_groups') }}</label>
                <select name="city_group" id="city_group" class="form-control form-select">
                    <option value="">{{ __('label.labels.all') }}</option>
                    @foreach($city_groups as $key => $city_group)
                        <option value="{{ $city_group->id }}" {{ isset( request()->city_group) && request()->city_group == $city_group->id ? 'selected' : '' }}>{{ $city_group->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <table class="table datatable-selection-single" id="city-table">
                    <thead>
                    <tr>
                        <th>{{ __('label.columns.common.id') }}</th>
                        <th>{{ __('label.columns.cities.name') }}</th>
                        <th>{{ __('label.columns.cities.city_group') }}</th>
                        <th>{{ __('label.columns.cities.search_exclusion_yn') }}</th>
                        <th>{{ __('label.columns.cities.prefecture') }}</th>
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
          tableId: 'city-table',
          ajaxUrl: "{{ route('admin.cities.index') }}",
          columns: [
            {'data': 'id'},
            {'data': 'name'},
            {'data': 'city_group_name'},
            {'data': 'search_exclusion'},
            {'data': 'prefecture_name'},
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

        $('#city_group').on('change', function() {
          const cityGroup = $(this).val();
          dataTable.ajax.url(config.ajaxUrl + '?city_group=' + cityGroup).load();
        });
      });
    </script>
@endsection
