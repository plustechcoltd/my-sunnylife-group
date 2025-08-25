@extends('admin.layouts.master')
@section('title')
        {{ $city_group->name }} | {{ __('label.tables.city_groups') }}
@endsection

@section('page-header')
    @component('admin.components.breadcrumb')
        @slot('title'){{ $city_group->name }}@endslot
        @slot('subtitle'){{ __('label.tables.city_groups') }}@endslot
        @slot('subtitle_route') {{ route('admin.city_groups.index') }} @endslot
    @endcomponent
@endsection

@section('content')
    <div class="content">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12 col-xxl-10 offset-xxl-1 mt-3">
                        <div class="fw-bold">
                            <h5>{{ __('label.labels.city_group_info') }}</h5>
                        </div>

                        <form action="{{ route('admin.city_groups.update', $city_group->id) }}" method="POST" id="form-update">
                            @csrf
                            @method('PUT')
                            @include('admin.city_groups.fields.city_group')
                        </form>
                    </div>
                </div>

                <div class="d-flex justify-content-end align-items-center">
                    <button type="submit" form="form-update" class="btn btn-primary ms-3">{{ __('label.buttons.save') }}</button>
                </div>
            </div>
        </div>
    </div>
@endsection
