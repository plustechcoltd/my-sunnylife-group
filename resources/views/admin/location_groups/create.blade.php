@extends('admin.layouts.master')
@section('title')
    {{ __('label.labels.create') }} | {{ __('label.tables.location_groups') }}
@endsection

@section('page-header')
    @component('admin.components.breadcrumb')
        @slot('title'){{ __('label.labels.create') }}@endslot
        @slot('subtitle'){{ __('label.tables.location_groups') }}@endslot
        @slot('subtitle_route') {{ route('admin.location_groups.index') }} @endslot
    @endcomponent
@endsection

@section('content')
    <div class="content">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12 col-xxl-10 offset-xxl-1 mt-3">
                        <div class="fw-bold">
                            <h5>{{ __('label.labels.location_group_info') }}</h5>
                        </div>

                        <form action="{{ route('admin.location_groups.store') }}" method="POST" id="form-store">
                            @csrf
                            @include('admin.location_groups.fields.location_group')
                        </form>
                    </div>
                </div>

                <div class="d-flex justify-content-end align-items-center">
                    <button type="submit" form="form-store" class="btn btn-primary ms-3">{{ __('label.buttons.save') }}</button>
                </div>
            </div>
        </div>
    </div>
@endsection
