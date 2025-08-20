<!-- Footer -->
<div class="navbar navbar-sm navbar-footer border-top {{ $settings['fixed_footer'] == 'y' ? 'fixed-bottom' : ''}}">
    <div class="container-fluid">
        <span>&copy; {{ date('Y') }} <a href="{{ route('web.home') }}">{{ $settings['site_title'] ?? config('app.name') }}</a></span>

        <ul class="nav">
            <li class="nav-item nav-item-dropdown-lg dropdown dropup language-switch">
                <a href="#" class="navbar-nav-link navbar-nav-link-icon rounded-pill" data-bs-toggle="dropdown"
                   aria-expanded="false">
                    <span class="fi fi-{{ \App\Helpers\LocalizationHelper::getLang(App::currentLocale())['flag'] }}"></span>
                    <span class="d-none d-lg-inline-block ms-2 me-1">{{ \App\Helpers\LocalizationHelper::getLang(App::currentLocale())['label'] }}</span>
                </a>
                <div class="dropdown-menu dropdown-menu-end">
                    @foreach(\App\Helpers\LocalizationHelper::getLang() as $key => $item)
                    @php
                        $queries = request()->query();
                        $queries['lang'] = $key;
                        $currentUrl = request()->url() . '?' . http_build_query($queries);
                    @endphp
                    <a href="{{ $currentUrl }}" class="dropdown-item">
                        <span class="fi fi-{{ $item['flag'] }}"></span>
                        <span class="ms-2">{{ $item['label'] }}</span>
                    </a>
                    @endforeach
                </div>
            </li>
        </ul>
    </div>
</div>
<!-- /footer -->
