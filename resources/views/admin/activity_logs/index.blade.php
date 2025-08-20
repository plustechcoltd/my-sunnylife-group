@extends('admin.layouts.master')
@section('title')
    {{ __('label.tables.activity_logs') }}
@endsection
@section('page-header')
    @component('admin.components.page-header')
        @slot('title')
            {{ __('label.tables.activity_logs') }} {{ __('label.labels.list') }}
        @endslot
        @slot('subtitle') {{ __('label.tables.activity_logs') }} @endslot
    @endcomponent
@endsection

@section('center-scripts')
    <script src="{{URL::asset('assets/admin/js/vendor/tables/datatables/datatables.min.js')}}"></script>
@endsection

@section('content')
    <div class="content">
        <!-- Single row selection -->
        <div class="card">
            <table class="table datatable-selection-single" id="activity-log-table">
                <thead>
                <tr>
                    <th width="5%">{{ __('label.columns.common.id') }}</th>
                    <th width="15%">{{ __('label.columns.activity_logs.record') }}</th>
                    <th width="15%">{{ __('label.columns.activity_logs.action') }}</th>
                    <th width="25%">{{ __('label.columns.activity_logs.description') }}</th>
                    <th width="15%">{{ __('label.columns.activity_logs.ip_address') }}</th>
                    <th width="25%">{{ __('label.columns.activity_logs.user_agent') }}</th>
                </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
        <!-- /single row selection -->
    </div>
@endsection

@section('scripts')
    <script>
      let dataTableLanguage = @json(trans('datatable'));
      let icons = @json(config('const.icons'));
      let models = @json(trans('label.tables'));
      let action = @json(trans('activity_log.actions'));
      $(document).ready(function() {
        const config = {
          tableId: 'activity-log-table',
          ajaxUrl: "{{ route('admin.activity_logs.index') }}",
          columns: [
            {'data': 'id'},
            {
              'data': 'record_table',
              'render': function(data, type, row) {
                return icons.hasOwnProperty(data) ? `<i class="${icons[data]}"></i> ${models[data]}` : data;
              },
            },
            {
              'data': 'action',
              'render': function(data, type, row) {
                return action.hasOwnProperty(data) ? action[data] : data;
              },
            },
            {'data': 'description'},
            {'data': 'ip_address'},
            {'data': 'user_agent'},
          ],
          language: dataTableLanguage,
        };

        initializeDataTable(config);
      });
    </script>
@endsection
