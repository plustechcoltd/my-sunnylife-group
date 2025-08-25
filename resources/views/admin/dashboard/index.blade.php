@extends('admin.layouts.master')
@section('title')
    {{ __('label.labels.dashboard') }}
@endsection
@section('page-header')
    @component('admin.components.page-header')
        @slot('hide_title_breadcrumb')@endslot
        @slot('title') {{ __('label.labels.dashboard') }} @endslot
        @slot('subtitle') {{ __('label.labels.dashboard') }} @endslot
    @endcomponent
@endsection
@section('content')

@endsection
