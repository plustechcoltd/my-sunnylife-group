@extends('admin.layouts.master')
@section('title')
    {{ __('label.labels.change_password_admin') }}
@endsection
@section('page-header')
    @component('admin.components.page-header')
        @slot('title') {{ $admin->full_name }} @endslot
        @slot('subtitle') {{ __('label.tables.admins') }} @endslot
    @endcomponent
@endsection

@section('content')
    <div class="content">
        <div class="card">
            <div class="card-body">
                @include('admin.admins.components.nav_tabs')
                <form action="{{ route('admin.admins.update_password', $admin->id) }}" method="POST">
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
