@extends('admin.layouts.master')
@section('title')
    {{ __('label.labels.edit_user', ['name' => $user->full_name]) }}
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
                <form action="{{ route('admin.users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                    @include('admin.users.components.field_profile')
                    <div class="d-flex justify-content-end align-items-center">
                        <button type="submit" class="btn btn-primary ms-3">{{ __('label.buttons.save') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
