<!-- Main navbar -->
<div class="navbar navbar-dark navbar-static py-2">
    <div class="container-fluid">
        <div class="navbar-brand">
            <a href="{{ route('admin.login') }}" class="d-inline-flex align-items-center">
                <img src="{{ URL::asset($settings['logo'] ? 'storage/'.$settings['logo'] : 'assets/admin/images/logo_icon.svg') }}" alt="">
                <img src="{{URL::asset($settings['light_logo'] ? 'storage/'.$settings['light_logo'] : 'assets/admin/images/logo_text_light.svg')}}"
                     class="d-none d-sm-inline-block h-16px ms-3" alt="">
            </a>
        </div>

        <div class="d-flex justify-content-end align-items-center ms-auto">
            <ul class="nav flex-row justify-content-end order-1 order-lg-2">
                <li class="nav-item">
                    <a href="#" class="navbar-nav-link navbar-nav-link-icon rounded ms-1">
                        <div class="d-flex align-items-center mx-md-1">
                            <i class="ph-lifebuoy"></i>
                            <span class="d-none d-md-inline-block ms-2">Support</span>
                        </div>
                    </a>
                </li>
                @if (Route::has('admin.register'))
                <li class="nav-item">
                    <a href="{{ route('admin.register') }}" class="navbar-nav-link navbar-nav-link-icon rounded ms-1">
                        <div class="d-flex align-items-center mx-md-1">
                            <i class="ph-user-circle-plus"></i>
                            <span class="d-none d-md-inline-block ms-2">{{ __('Register') }}</span>
                        </div>
                    </a>
                </li>
                @endif
                @if (Route::has('admin.login'))
                <li class="nav-item">
                    <a href="{{ route('admin.login') }}" class="navbar-nav-link navbar-nav-link-icon rounded ms-1">
                        <div class="d-flex align-items-center mx-md-1">
                            <i class="ph-user-circle"></i>
                            <span class="d-none d-md-inline-block ms-2">{{ __('Login') }}</span>
                        </div>
                    </a>
                </li>
                @endif
            </ul>
        </div>
    </div>
</div>
<!-- /main navbar -->
