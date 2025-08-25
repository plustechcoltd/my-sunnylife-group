<!-- Main sidebar -->
<div class="sidebar sidebar-dark sidebar-main sidebar-expand-lg">

    <!-- Sidebar content -->
    <div class="sidebar-content">

        <!-- Sidebar header -->
        <div class="sidebar-section">
            <div class="sidebar-section-body d-flex justify-content-center">
                <h5 class="sidebar-resize-hide flex-grow-1 my-auto">{{ __('label.menus.navigation') }}</h5>

                <div>
                    <button type="button" class="btn btn-flat-white btn-icon btn-sm rounded-pill border-transparent sidebar-control sidebar-main-resize d-none d-lg-inline-flex">
                        <i class="ph-arrows-left-right"></i>
                    </button>

                    <button type="button" class="btn btn-flat-white btn-icon btn-sm rounded-pill border-transparent sidebar-mobile-main-toggle d-lg-none">
                        <i class="ph-x"></i>
                    </button>
                </div>
            </div>
        </div>
        <!-- /sidebar header -->

        <!-- Main navigation -->
        <div class="sidebar-section">
            <ul class="nav nav-sidebar" id="navbar-nav" data-nav-type="accordion">
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}"
                       class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="ph-windows-logo"></i>
                        <span>{{ __('label.menus.dashboard') }}</span>
                    </a>
                </li>

                @canany(['admin:locations','admin:location_groups', 'admin:cities', 'admin:city_groups'])
                    <li class="nav-item nav-item-submenu {{ request()->routeIs('admin.locations.*') || request()->routeIs('admin.location_groups.*') || request()->routeIs('admin.cities.*') || request()->routeIs('admin.city_groups.*') ? 'nav-item-open' : '' }}">
                        <a href="#" class="nav-link">
                            <i class="{{ config('const.icons.locations') }}"></i>
                            <span>{{ __('label.menus.locations') }}</span>
                        </a>
                        <ul class="nav-group-sub collapse {{ request()->routeIs('admin.locations.*') || request()->routeIs('admin.location_groups.*') || request()->routeIs('admin.cities.*') || request()->routeIs('admin.city_groups.*') ? 'show' : '' }}">
                            @can('admin:locations')
                                <li class="nav-item">
                                    <a href="{{ route('admin.locations.index') }}" class="nav-link {{ request()->routeIs('admin.locations.*') ? 'active' : '' }}">
                                        <span>{{ __('label.menus.locations') }}</span>
                                    </a>
                                </li>
                            @endcan
                            @can('admin:location_groups')
                                <li class="nav-item">
                                    <a href="{{ route('admin.location_groups.index') }}" class="nav-link {{ request()->routeIs('admin.location_groups.*') ? 'active' : '' }}">
                                        <span>{{ __('label.menus.location_groups') }}</span>
                                    </a>
                                </li>
                            @endcan
                            @can('admin:cities')
                                <li class="nav-item">
                                    <a href="{{ route('admin.cities.index') }}" class="nav-link {{ request()->routeIs('admin.cities.*') ? 'active' : '' }}">
                                        <span>{{ __('label.menus.cities') }}</span>
                                    </a>
                                </li>
                            @endcan
                            @can('admin:city_groups')
                                <li class="nav-item">
                                    <a href="{{ route('admin.city_groups.index') }}" class="nav-link {{ request()->routeIs('admin.city_groups.*') ? 'active' : '' }}">
                                        <span>{{ __('label.menus.city_groups') }}</span>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcanany

                @can('admin:admins')
                    <li class="nav-item nav-item-submenu {{ request()->routeIs('admin.admins.*') ? 'nav-item-open' : '' }}">
                        <a href="#" class="nav-link">
                            <i class="{{ config('const.icons.admins') }}"></i>
                            <span>{{ __('label.menus.admins') }}</span>
                        </a>
                        <ul class="nav-group-sub collapse {{ request()->routeIs('admin.admins.*') ? 'show' : '' }}">
                            <li class="nav-item">
                                <a href="{{ route('admin.admins.index') }}" class="nav-link {{ request()->routeIs('admin.admins.index') ? 'active' : '' }}">
                                    <span>{{ __('label.menus.admins') }}</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endcan

                @can('admin:activity_logs')
                    <li class="nav-item">
                        <a href="{{ route('admin.activity_logs.index') }}"
                           class="nav-link {{ request()->routeIs('admin.activity_logs.index') ? 'active' : '' }}">
                            <i class="{{ config('const.icons.activity_logs') }}"></i>
                            <span>{{ __('label.menus.activity_logs') }}</span>
                        </a>
                    </li>
                @endcan

            </ul>
        </div>
        <!-- /main navigation -->

    </div>
    <!-- /sidebar content -->

</div>
<!-- /main sidebar -->
