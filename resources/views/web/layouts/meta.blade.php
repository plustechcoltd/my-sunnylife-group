<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title>@yield('title', $settings['site_title'] ?? config('app.name'))</title>
<meta name="description" content="@yield('description', $settings['site_description'] ?? '')" />
@hasSection('keywords')
<meta name="keywords" content="@yield('keywords')">
@endif
@hasSection('canonical')
<link rel="canonical" href="@yield('canonical')" />
@endif
@if(config('app.env') != 'production'){{-- 本番環境以外はnoindex,nofollow --}}
<meta name="robots" content="noindex,nofollow">
@else
@hasSection('robots')<meta name="robots" content="@yield('robots')">@endif
@endif
<link rel="icon" type="image/x-icon" href="{{URL::asset('user/admin/images/favicon.svg')}}">