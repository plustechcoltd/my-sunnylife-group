@extends('admin.layouts.master')
@section('title')
    {{ __('label.labels.change_password') }}
@endsection
@section('page-header')
    @component('admin.components.page-header')
        @slot('title')
            {{ __('label.labels.edit_profile') }}
        @endslot
        @slot('subtitle')
            {{ __('label.labels.my_profile') }}
        @endslot
    @endcomponent
@endsection

@section('content')
    <div class="content">
        <div class="card">
            <div class="card-body">
                @include('admin.profile.components.nav_tabs')
                <form action="{{ route('admin.profile.update_password') }}" method="POST">
                    @method('PUT')
                    @csrf
                    @include('admin.admins.components.field_password')
                    <div class="d-flex justify-content-end align-items-center">
                        <button type="submit" class="btn btn-primary ms-3">{{ __('label.buttons.save') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
