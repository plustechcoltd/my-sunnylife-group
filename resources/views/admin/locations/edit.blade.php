@extends('admin.layouts.master')
@section('title')
    {{ $location->name }} | {{ __('label.tables.locations') }}
@endsection

@section('page-header')
    @component('admin.components.breadcrumb')
        @slot('title'){{ $location->name }}@endslot
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
                            <h5>{{ __('label.labels.location_info') }}</h5>
                        </div>

                        <form class="mo-tab_content location-form" id="form-update-location" method="POST"
                              action="{{route('admin.locations.update', $location->id)}}">
                            @csrf
                            @method('PUT')
                            @include('admin.locations.fields.form')
                        </form>
                    </div>
                </div>

                <div class="d-flex justify-content-end align-items-center">
                    <button id="submit-form" class="btn btn-primary ms-3">
                        <i class="ph-circle-notch spinner me-2 d-none"></i>{{ __('label.buttons.save') }}
                    </button>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        @include('admin.components.memo', [
                           'admin_memos' => $admin_memos,
                           'record_model' => config('mo.model.location.model_name'),
                           'record_id' => $location->id
                           ])
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('modals')
    @include('admin.locations.components.modal-stations')
    @include('admin.locations.components.modal-contracts')
@endsection

@section('scripts')
    <script>
      $(function() {
        $('#submit-form').on('click', function(e) {
          e.preventDefault();
          $('.text-error').text('');
          $('.is-invalid').removeClass('is-invalid');
          let form_location = $('form#form-update-location');
          $('.spinner').removeClass('d-none');
          submitFormAjax(form_location).then((res) => {
            window.location.href = `{{ route('admin.locations.edit', [$location->id]) }}`
          }).catch((res) => {
            $('div.mo-alert').remove();
            showErrorMessage(form_location, res);
            $('.spinner').addClass('d-none');
          });
        });
      });
    </script>
    @include('admin.locations.components.js_location')
    @include('admin.components.js_cities')
    @include('admin.components.js_train_station')
    <script src="{{URL::asset('assets/admin/js/vendor/pickers/datepicker.min.js')}}"></script>
    <script src="{{URL::asset('assets/admin/js/picker_date.js')}}"></script>
@endsection
