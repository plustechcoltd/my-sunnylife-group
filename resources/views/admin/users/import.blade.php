@extends('admin.layouts.master')
@section('title')
    {{ translateWithLocale('import', 'users') }}
@endsection
@section('page-header')
    @component('admin.components.page-header')
        @slot('title')
            {{ translateWithLocale('import', 'users') }}
        @endslot
        @slot('subtitle')
            {{ __('label.tables.users') }}
        @endslot
    @endcomponent
@endsection

@section('content')
    <div class="content">
        <form action="{{ route('admin.users.upload_csv') }}" method="POST" enctype="multipart/form-data">
            @method('POST')
            @csrf
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-8 offset-lg-2">
                            <div class="fw-bold">
                                <h5>{{ translateWithLocale('import', 'users') }}</h5>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-8 offset-lg-2">
                            <div class="form-group">
                                <label for="csv_file" class="mb-3">{{ __('label.labels.upload_csv_file') }}</label>
                                <input type="file" class="form-control" id="csv_file" name="csv_file" accept=".csv">
                                @if($errors->has('csv_file'))
                                    <div class="validation-invalid-label">{{ $errors->first('csv_file') }}</div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end align-items-center">
                        <button type="submit" class="btn btn-primary ms-3">{{ __('label.buttons.save') }}</button>
                    </div>
                </div>
            </div>

        </form>
    </div>
@endsection
