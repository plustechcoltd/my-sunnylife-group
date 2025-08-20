<!-- Footer -->
<div class="navbar navbar-sm navbar-footer border-top {{ $settings['fixed_footer'] == 'y' ? 'fixed-bottom' : ''}}">
    <div class="container-fluid">
        <span>&copy; {{ date('Y') }} <a href="{{ route('admin.dashboard') }}">{{ $settings['site_title'] ?? config('app.name') }}</a></span>

        <ul class="nav">
            <li class="nav-item nav-item-dropdown-lg dropdown dropup language-switch">
                <a href="#" class="navbar-nav-link navbar-nav-link-icon rounded-pill" data-bs-toggle="dropdown"
                   aria-expanded="false">
                    <img src="{{ URL::asset(config('const.language_icons.' . App::currentLocale())) }}" height="22"
                         alt="">
                    <span class="d-none d-lg-inline-block ms-2 me-1">{{ __('const.language_labels.' . App::currentLocale()) }}</span>
                </a>
                <div class="dropdown-menu dropdown-menu-end">
                    @foreach(config('const.language_codes') as $language_code)
                    @php
                        $queries = request()->query();
                        $queries['lang'] = $language_code;
                        $currentUrl = request()->url() . '?' . http_build_query($queries);
                    @endphp
                    <a href="{{ $currentUrl }}" class="dropdown-item">
                        <img src="{{ URL::asset(config('const.language_icons.' . $language_code)) }}" height="22" alt="">
                        <span class="ms-2">{{ __('const.language_labels.'.$language_code) }}</span>
                    </a>
                    @endforeach
                </div>
            </li>
        </ul>
    </div>
</div>
<!-- /footer -->
