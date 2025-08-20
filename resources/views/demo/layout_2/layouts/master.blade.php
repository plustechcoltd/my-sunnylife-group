<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Limitless - Responsive Web Application Kit by Themesbrand</title>
    <link rel="icon" type="image/x-icon" href="{{URL::asset('assets/demo/layout_2/images/favicon.svg')}}">

    @include('demo.layout_2.layouts.head-css')

</head>

<body>

    <!-- Page content -->
    <div class="page-content">

        <!-- sidebar -->
        @include('demo.layout_2.layouts.sidebar')

        <!-- Main content -->
        <div class="content-wrapper">

            <!-- navbar -->
            @include('demo.layout_2.layouts.navbar')

            <!-- Inner content -->
            <div class="content-inner">

                @yield('content')

                @include('demo.layout_2.layouts.footer')

            </div>
            <!-- /inner content -->

        </div>
        <!-- /main content -->

    </div>
    <!-- /page content -->

    <!-- notification -->
    @include('demo.layout_2.layouts.notification')

    <!-- right-sidebar content -->
    @include('demo.layout_2.layouts.right-sidebar')

</body>
</html>
