<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>@yield('title') | {{ $settings['site_title'] ?? config('app.name') }}</title>
<meta name="description" content="@yield('description', $settings['site_description'] ?? '')" />
@hasSection('keywords')
<meta name="keywords" content="@yield('keywords')">
@endif
@hasSection('canonical')
<link rel="canonical" href="@yield('canonical')" />
@endif
<meta name="robots" content="noindex,nofollow">
<link rel="icon" type="image/x-icon"
      href="{{ asset(!empty($settings['favicon']) ? 'storage/'.$settings['favicon'] : 'assets/admin/images/favicon.svg') }}">