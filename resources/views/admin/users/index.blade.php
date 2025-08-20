@extends('admin.layouts.master')
@section('title')
    {{ __('label.tables.users') }}
@endsection
@section('page-header')
    @component('admin.components.page-header')
        @slot('title')
            {{ __('label.tables.users') }} {{ __('label.labels.list') }}
        @endslot
        @slot('subtitle')
            {{ __('label.tables.users') }}
        @endslot
        @slot('button')
            <div class="my-auto ms-auto">
                <a href="{{ route('admin.users.create') }}" class="btn btn-info">
                    {{ __('label.buttons.create') }}
                </a>
            </div>
        @endslot
    @endcomponent
@endsection

@section('center-scripts')
    <script src="{{ asset('assets/admin/js/vendor/tables/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/vendor/tables/datatables/extensions/buttons.min.js') }}"></script>
@endsection

@section('content')
    <div class="content">
        <div class="card">
            <table class="table datatable-selection-single" id="user-table">
                <thead>
                <tr>
                    <th>{{ __('label.columns.common.id') }}</th>
                    <th>{{ __('label.columns.users.family_name') }}</th>
                    <th>{{ __('label.columns.users.first_name') }}</th>
                    <th>{{ __('label.columns.users.email') }}</th>
                    <th>{{ __('label.columns.common.created_at') }}</th>
                    <th class="text-center">{{ __('label.columns.common.actions') }}</th>
                </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('scripts')
    @include('admin.users.components.script_datatables')
    @vite('resources/admin/js/pages/users/index.js')
@endsection
