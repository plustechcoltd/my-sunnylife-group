@extends('admin.layouts.master')
@section('title')
    {{ __('label.tables.admins') }}
@endsection
@section('page-header')
    @component('admin.components.page-header')
        @slot('title')
            {{ __('label.tables.admins') }} {{ __('label.labels.list') }}
        @endslot
        @slot('subtitle') {{ __('label.tables.admins') }} @endslot
        @slot('button')
            <div class="my-auto ms-auto">
                <a href="{{ route('admin.admins.create') }}" class="btn btn-info">
                    {{ __('label.buttons.create') }}
                </a>
            </div>
        @endslot
    @endcomponent
@endsection

@section('center-scripts')
    <script src="{{URL::asset('assets/admin/js/vendor/tables/datatables/datatables.min.js')}}"></script>
@endsection

@section('content')
    <div class="content">
        <!-- Single row selection -->
        <div class="card">
            <table class="table datatable-selection-single" id="admin-table">
                <thead>
                <tr>
                    <th>{{ __('label.columns.common.id') }}</th>
                    <th>{{ __('label.columns.admins.full_name') }}</th>
                    <th>{{ __('label.columns.admins.email') }}</th>
                    <th>{{ __('label.columns.admins.phone') }}</th>
                    <th class="text-center">{{ __('label.columns.common.actions') }}</th>
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
    @include('admin.admins.components.script_datatables')
    @vite(['resources/admin/js/pages/admins/index.js'])
@endsection
