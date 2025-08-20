@extends('admin.layouts.master')
@section('title')
    {{ translateWithLocale('edit', 'languages') }}
@endsection
@section('page-header')
    @component('admin.components.breadcrumb')
        @slot('title')
            {{ translateWithLocale('edit', 'cars') }}
        @endslot
        @slot('subtitle')
            {{ __('label.tables.languages') }}
        @endslot
        @slot('subtitle_route') {{ route('admin.languages.index') }} @endslot
    @endcomponent
@endsection

@section('content')
<div class="content">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-lg-8 offset-lg-2">
                    <div class="fw-bold">
                        <h5>{{ __('label.labels.language') }}</h5>
                    </div>
                    <form action="{{ route('admin.languages.update', $language->id) }}" method="POST" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        @include('admin.languages.components.field_language')

                        <div class="d-flex justify-content-end align-items-center">
                            <button type="submit" class="btn btn-primary ms-3">{{ __('label.buttons.save') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection