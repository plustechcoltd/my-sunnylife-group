<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="ltr">
<head>
    <script>
        window.AppConfig = {
            currentLanguage: "{{ app()->getLocale() }}"
        }
    </script>
    @include('admin.layouts.meta')
    @include('admin.layouts.head_css')
    @include('admin.layouts.scripts.notification')
    @include('components.chat.script')
</head>

<body>
<!-- navbar -->
@include('admin.layouts.navbar')

<!-- Page content -->
<div class="page-content">

    <!-- sidebar -->
    @include('admin.layouts.sidebar')

    <!-- Main content -->
    <div class="content-wrapper">

        <!-- Inner content -->
        <div class="content-inner">

            <!-- page header -->
            @yield('page-header')

            <!-- content -->
            @yield('content')

            <!-- modals -->
            @yield('modals')

        </div>
        <!-- /inner content -->

    </div>
    <!-- /main content -->

</div>
<!-- /page content -->

{{--@include('admin.layouts.navigation_menu')--}}

<!-- notification -->
@include('admin.components.notification.notification-box')

<!-- footer -->
@include('admin.layouts.footer')

<!-- right-sidebar content -->
@include('admin.layouts.right_sidebar')

<!-- toast message -->
@include('admin.components.flash-message')
</body>
</html>
