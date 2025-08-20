@extends('admin.layouts.master')
@section('title')
    {{ __('label.labels.change_password_user') }}
@endsection
@section('page-header')
    @component('admin.components.page-header')
        @slot('title')
            {{ $user->full_name }}
        @endslot
        @slot('subtitle')
            {{ __('label.tables.users') }}
        @endslot
    @endcomponent
@endsection

@section('content')
    <div class="content">
        <div class="card">
            <div class="card-body">
                @include('admin.users.components.nav_tabs')
                <form action="{{ route('admin.users.update_password', $user->id) }}" method="POST">
                    @method('PUT')
                    @csrf
                    @include('admin.users.components.field_password')
                    <div class="d-flex justify-content-end align-items-center">
                        <button type="submit" class="btn btn-primary ms-3">{{ __('label.buttons.save') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
