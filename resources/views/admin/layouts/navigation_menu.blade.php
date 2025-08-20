	<!-- Navigation -->
    <div class="navbar navbar-sm shadow"
         id="navigation-nav" {{ !empty($settings['navbar_background_color']) ? 'style=background-color:'.$settings['navbar_background_color'] : '' }}>
	    <div class="{{ getContainerClass($settings) }}">
	        <div class="flex-fill overflow-auto overflow-lg-visible scrollbar-hidden">
	            <ul class="nav gap-1 flex-nowrap flex-lg-wrap">
	                <li class="nav-item">
	                    <a href="{{ route('admin.dashboard') }}" class="navbar-nav-link rounded {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
	                        <i class="ph-house me-2"></i>
							{{ __('label.menus.home') }}
	                    </a>
	                </li>

					<li class="nav-item">
						<a href="#" class="navbar-nav-link dropdown-toggle rounded" data-bs-toggle="dropdown" aria-expanded="false">
							<i class="ph-layout me-2"></i>
							{{ __('label.menus.pages') }}
						</a>

						<div class="dropdown-menu start-0 end-0 p-3 mx-md-3">
							<div class="row">
								<div class="col-md-4 mb-3 mb-md-0">
									<div class="fw-bold border-bottom pb-2 mb-2">{{ __('label.menus.users') }}</div>
									<div class="mb-3 mb-md-0">
										@can('admin:users')
											<a href="{{ route('admin.users.index') }}" class="dropdown-item rounded {{ request()->routeIs('admin.users.index') ? 'active' : '' }}">
												<i class="{{ config('const.icons.users') }} me-2"></i>												{{ __('label.menus.users') }}
											</a>
											<a href="{{ route('admin.users.create') }}" class="dropdown-item rounded {{ request()->routeIs('admin.users.create') ? 'active' : '' }}">
{{--												<i class="ph-user me-2"></i>--}}
												{{ __('label.menus.create_user') }}
											</a>
										@endcan
									</div>
								</div>
								<div class="col-md-4 mb-3 mb-md-0">
									<div class="fw-bold border-bottom pb-2 mb-2">{{ __('label.menus.admins') }}</div>
									<div class="mb-3 mb-md-0">
										@can('admin:admins')
											<a href="{{ route('admin.admins.index') }}" class="dropdown-item rounded {{ request()->routeIs('admin.admins.index') ? 'active' : '' }}">
												<i class="{{ config('const.icons.admins') }} me-2"></i>
												{{ __('label.menus.admins') }}
											</a>
											<a href="{{ route('admin.admins.create') }}" class="dropdown-item rounded {{ request()->routeIs('admin.admins.create') ? 'active' : '' }}">
												{{--												<i class="ph-user me-2"></i>--}}
												{{ __('label.menus.create_admin') }}
											</a>
										@endcan
									</div>
								</div>
								<div class="col-md-4 mb-3 mb-md-0">
									<div class="fw-bold border-bottom pb-2 mb-2">{{ __('label.menus.activity_logs') }}</div>
									<div class="mb-3 mb-md-0">
										@can('admin:activity_logs')
											<a href="{{ route('admin.activity_logs.index') }}" class="dropdown-item rounded {{ request()->routeIs('admin.activity_logs.index') ? 'active' : '' }}">
												<i class="{{ config('const.icons.activity_logs') }} me-2"></i>
												{{ __('label.menus.activity_logs') }}
											</a>
										@endcan
									</div>
								</div>
							</div>
						</div>
					</li>

					@can('admin:settings')
						<li class="nav-item">
							<a href="{{ route('admin.settings.index') }}" class="navbar-nav-link rounded {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
								<i class="{{ config('const.icons.settings') }} me-2"></i>
								{{ __('label.menus.settings') }}
							</a>
						</li>
					@endcan

					@if(config('app.lang_driver') == 'database')
					@can('admin:languages')
						<li class="nav-item">
							<a href="{{ route('admin.languages.index') }}" class="navbar-nav-link rounded {{ request()->routeIs('admin.languages.*') ? 'active' : '' }}">
								<i class="{{ config('const.icons.languages') }} me-2"></i>
								{{ __('label.menus.languages') }}
							</a>
						</li>
					@endcan
					@endif
	            </ul>
	        </div>
	    </div>
	</div>
	<!-- /navigation -->
<style>
	@if(isset($settings['navbar_text_color']))
	.navbar-nav-link {
		{{ $settings['navbar_text_color'] ? 'color:'.$settings['navbar_text_color'] : '' }};
	}
	.dropdown-menu {
		{{ $settings['navbar_text_color'] ? 'color:'.$settings['navbar_text_color'] : '' }};
	}
	.dropdown-item {
		{{ $settings['navbar_text_color'] ? 'color:'.$settings['navbar_text_color'] : '' }};
	}
	@endif
	@if(isset($settings['navbar_background_color']))
	.dropdown-menu {
		{{ $settings['navbar_background_color'] ? 'background-color:'.$settings['navbar_background_color'] : '' }};
	}
	@endif
</style>