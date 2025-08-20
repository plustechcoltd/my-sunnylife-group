@extends('admin.layouts.master-without-nav')
@section('content')

    <!-- Content area -->
    <div class="content d-flex justify-content-center align-items-center">

        <!-- Container -->
        <div class="flex-fill">

            <!-- Error title -->
            <div class="text-center mb-4">
                <img src="{{URL::asset('assets/admin/images/error_bg.svg')}}" class="img-fluid mb-3" height="230"
                     alt="">
                <h1 class="display-3 fw-semibold lh-1 mb-3">503</h1>
                <h6 class="w-md-25 mx-md-auto">
                    @php
                        $message = "Oops, an error has occurred. <br> The service you requested is not available at this time. Please try again later.";
                        if ($setting =  \App\Models\Setting::where('name', 'maintenance_message')->first()) {
                           $message =  $setting->value;
                        }
                    @endphp
                    {!! $message !!}
                </h6>
            </div>
            <!-- /error title -->

        </div>
        <!-- /container -->

    </div>
    <!-- /content area -->

@endsection
