@extends('admin.layouts.master')
@section('title')
    {{ __('label.tables.languages') }}
@endsection
@section('page-header')
    @component('admin.components.breadcrumb')
        @slot('hide_title_breadcrumb')@endslot
        @slot('title')
            {{ __('label.tables.languages') }} {{ __('label.labels.list') }}
        @endslot
        @slot('subtitle') {{ __('label.tables.languages') }} @endslot
        @slot('button')
            <div class="my-auto ms-auto">
                <a href="{{ route('admin.languages.create') }}" class="btn btn-info">
                    {{ __('label.buttons.create') }}
                </a>
            </div>
        @endslot
    @endcomponent
@endsection

@section('content')
    <div class="content">
        <!-- Single row selection -->
        <div class="card">
            <table class="table datatable-selection-single responsive" id="language-table" width="100%" height="100%">
                <thead>
                <tr>
                    <th>{{ __('label.columns.common.id') }}</th>
                    <th>{{ __('label.columns.languages.code') }}</th>
                    <th>{{ __('label.columns.languages.flag') }}</th>
                    <th>{{ __('label.columns.languages.label') }}</th>
                    <th>{{ __('label.columns.languages.default_yn') }}</th>
                    <th>{{ __('label.columns.languages.sortno') }}</th>
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
    @include('admin.languages.components.script_datatables')
    @vite(['resources/admin/js/pages/languages/index.js'])
@endsection
