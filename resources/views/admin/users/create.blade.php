@extends('admin.layouts.master')
@section('title')
    {{ translateWithLocale('create', 'users') }}
@endsection
@section('page-header')
    @component('admin.components.page-header')
        @slot('title')
            {{ translateWithLocale('create', 'users') }}
        @endslot
        @slot('subtitle')
            {{ __('label.tables.users') }}
        @endslot
    @endcomponent
@endsection

@section('content')
    <div class="content">
        <form action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data">
            @method('POST')
            @csrf
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-8 offset-lg-2">
                            <div class="fw-bold">
                                <h5>{{ __('label.labels.basic_info') }}</h5>
                            </div>
                        </div>
                    </div>
                    @include('admin.users.components.field_profile')

                    <div class="row">
                        <div class="col-lg-8 offset-lg-2">
                            <div class="fw-bold">
                                <h5>{{ __('label.labels.password_setting') }}</h5>
                            </div>
                        </div>
                    </div>
                    @include('admin.users.components.field_password')

                    <div class="d-flex justify-content-end align-items-center">
                        <button type="submit" class="btn btn-primary ms-3">{{ __('label.buttons.create') }}</button>
                    </div>
                </div>
            </div>

        </form>
    </div>
@endsection
