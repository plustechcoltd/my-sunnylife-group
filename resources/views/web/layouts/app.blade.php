<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="ltr">
<head>
    @include('web.layouts.meta')
    @include('web.layouts.head-css')
    @if(auth('user')->check())
        @include('web.layouts.scripts.notification')
        @include('components.chat.script')
    @endif
    <script>
        window.AppConfig = {
            currentLanguage: "{{ app()->getLocale() }}"
        }
    </script>
</head>

<body>
    <!-- navbar -->
    @if(auth('user')->check())
    @include('web.layouts.navbar')
    @else
    @include('web.layouts.auth_navbar')
    @endif

    @yield('page-header')

    <!-- Page content -->
    <div class="page-content">

        <!-- Main content -->
        <div class="content-wrapper">

            @yield('content')

        </div>
        <!-- /main content -->

    </div>
    <!-- /page content -->

    <!-- notification -->
    @if(auth('user')->check())
        @include('web.components.notification.notification-box')
    @endif

    @include('web.layouts.footer')

    <!-- toast message -->
    @include('web.components.flash-message')
</body>
</html>
