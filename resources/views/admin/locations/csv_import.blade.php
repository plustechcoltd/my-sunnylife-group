@extends('admin.layouts.master')
@section('title')
    {{ __('label.labels.import') }} | {{ __('label.tables.locations') }}
@endsection

@section('page-header')
    @component('admin.components.breadcrumb')
        @slot('title'){{ __('label.labels.import') }}@endslot
        @slot('subtitle'){{ __('label.tables.locations') }}@endslot
        @slot('subtitle_route') {{ route('admin.locations.index') }} @endslot
    @endcomponent
@endsection

@section('content')
    <div class="content">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12 col-xxl-10 offset-xxl-1 mt-3">
                        <div class="fw-bold">
                            <h5>{{ __('label.labels.import') }}</h5>
                        </div>

                        <form action="{{ route('admin.locations.upload_csv') }}" method="POST" enctype="multipart/form-data" id="form-store">
                            @method('POST')
                            @csrf
                            <div class="form-group">
                                <label for="csv_file" class="form-label fw-semibold label_required">{{ __('label.columns.locations.import_csv') }}</label>
                                <input type="file" class="form-control" id="csv_file" name="import_file" accept=".csv">
                                @if($errors->has('import_file'))
                                    <div class="validation-invalid-label">{{ $errors->first('import_file') }}</div>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>

                <div class="d-flex justify-content-end align-items-center">
                    <button form="form-store" class="btn btn-primary ms-3">
                        <i class="ph-circle-notch spinner me-2 d-none"></i>{{ __('label.buttons.save') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection
