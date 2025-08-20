<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Limitless - Responsive Web Application Kit by Themesbrand</title>
    <link rel="icon" type="image/x-icon" href="{{URL::asset('assets/demo/layout_6/images/favicon.svg')}}">

    @include('demo.layout_6.layouts.head-css')

</head>

<body>
    <!-- navbar -->
    @include('demo.layout_6.layouts.navbar')

    <!-- Page content -->
    <div class="page-content">

        <!-- Main content -->
        <div class="content-wrapper">

            <div class="content-inner">

                @yield('page-header')

                @yield('content')

                @include('demo.layout_6.layouts.footer')

            </div>

        </div>
        <!-- /main content -->

    </div>
    <!-- /page content -->

    <!-- notification -->
    @include('demo.layout_6.layouts.notification')

    <!-- right-sidebar content -->
    @include('demo.layout_6.layouts.right-sidebar')

</body>
</html>
