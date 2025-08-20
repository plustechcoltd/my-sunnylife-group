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

@include('admin.layouts.navigation_menu')

@yield('page-header')

<!-- Page content -->
<div class="page-content pt-0 {{ getContainerClass($settings) }}">

    <!-- Main content -->
    <div class="content-wrapper">

        @yield('content')

    </div>
    <!-- /main content -->

</div>
<!-- /page content -->

<!-- notification -->
@include('admin.components.notification.notification-box')

<!-- footer -->
@if(!empty($settings['display_footer']) && $settings['display_footer'] != 'n')
    @include('admin.layouts.footer')
@endif

<!-- right-sidebar content -->
@include('admin.layouts.right_sidebar')

<!-- toast message -->
@include('admin.components.flash-message')
</body>
</html>
