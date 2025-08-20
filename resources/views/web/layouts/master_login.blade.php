<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>@yield('title') | {{ $settings['site_title'] ?? config('app.name') }}</title>
    <meta name="description" content="{{ $settings['site_description'] ?? '' }}">
    <link rel="icon" type="image/x-icon" href="{{ URL::asset($settings['favicon'] ? 'storage/'.$settings['favicon'] : 'assets/admin/images/favicon.svg') }}">

    @include('web.layouts.head-css')
    <script>
        window.AppConfig = {
            currentLanguage: "{{ app()->getLocale() }}"
        }
    </script>
</head>
<body>

@if(auth('user')->check())
    @include('web.layouts.navbar')
@else
    @include('web.layouts.auth_navbar')
@endif

<!-- Page content -->
<div class="page-content">

    <!-- Main content -->
    <div class="content-wrapper">

        @yield('content')

    </div>
    <!-- /main content -->

</div>
<!-- /page content -->

@include('web.layouts.footer')

</body>
</html>
