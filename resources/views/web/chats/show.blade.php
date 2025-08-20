@extends('web.layouts.app')

@section('content')
    <div class="content">
        <div class="page-content">
            @include('components.chat.sidebar')

            <!-- Main content -->
            <div class="content-wrapper">
                <!-- Inner content -->
                <div class="content-inner">
                    <!-- Content area -->
                    <div class="content">
                        @include('components.chat.content')
                    </div>
                    <!-- /content area -->
                </div>
                <!-- /inner content -->
            </div>
            <!-- /main content -->
        </div>
    </div>
@endsection
