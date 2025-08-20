	<!-- Navigation -->
	<div class="navbar navbar-sm shadow" id="navigation-nav">
	    <div class="container-fluid">
	        <div class="flex-fill overflow-auto overflow-lg-visible scrollbar-hidden">
	            <ul class="nav gap-1 flex-nowrap flex-lg-wrap">
	                <li class="nav-item">
	                    <a href="{{ route('admin.dashboard') }}" class="navbar-nav-link rounded {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
	                        <i class="ph-house me-2"></i>
	                        Home
	                    </a>
	                </li>
					@can('admin:activity_logs')
						<li class="nav-item">
							<a href="{{ route('admin.activity_logs.index') }}" class="navbar-nav-link rounded {{ request()->routeIs('admin.activity_logs.*') ? 'active' : '' }}">
								<i class="ph-database me-2"></i>
								Activity Logs
							</a>
						</li>
					@endcan
					@can('admin:users')
						<li class="nav-item">
							<a href="{{ route('admin.users.index') }}" class="navbar-nav-link rounded {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
								<i class="ph-user me-2"></i>
								Users
							</a>
						</li>
					@endcan
					@can('admin:admins')
						<li class="nav-item">
							<a href="{{ route('admin.admins.index') }}" class="navbar-nav-link rounded {{ request()->routeIs('admin.admins.*') ? 'active' : '' }}">
								<i class="ph-user-plus me-2"></i>
								Admins
							</a>
						</li>
					@endcan

	                <li class="nav-item">
	                    <a href="#" class="navbar-nav-link dropdown-toggle rounded" data-bs-toggle="dropdown">
	                        <i class="ph-layout me-2"></i>
	                        Page
	                    </a>

	                    <div class="dropdown-menu start-0 end-0 p-3 mx-md-3">
	                        <div class="row">
	                            <div class="col-md-4 mb-3 mb-md-0">
	                                <div class="fw-bold border-bottom pb-2 mb-2">Navbars</div>
	                                <div class="mb-3 mb-md-0">
	                                    <a href="/layout_navbar_fixed" class="dropdown-item rounded">Fixed navbar</a>
	                                    <a href="/layout_navbar_hideable" class="dropdown-item rounded">Hideable navbar</a>
	                                    <a href="/layout_navbar_sticky" class="dropdown-item rounded">Sticky navbar</a>
	                                    <a href="/layout_fixed_footer" class="dropdown-item rounded">Fixed footer</a>
	                                </div>
	                            </div>
	                            <div class="col-md-4 mb-3 mb-md-0">
	                                <div class="fw-bold border-bottom pb-2 mb-2">Sidebars</div>
	                                <div class="mb-3 mb-md-0">
	                                    <a href="/layout_2_sidebars_1_side" class="dropdown-item rounded">2 sidebars on 1 side</a>
	                                    <a href="/layout_2_sidebars_2_sides" class="dropdown-item rounded">2 sidebars on 2 sides</a>
	                                    <a href="/layout_3_sidebars" class="dropdown-item rounded">3 sidebars</a>
	                                </div>
	                            </div>
	                            <div class="col-md-4 mb-3 mb-md-0">
	                                <div class="fw-bold border-bottom pb-2 mb-2">Sections</div>
	                                <div class="mb-3 mb-md-0">
	                                    <a href="/layout_no_header" class="dropdown-item rounded">No header</a>
	                                    <a href="/layout_no_footer" class="dropdown-item rounded">No footer</a>
	                                    <a href="/layout_boxed_page" class="dropdown-item rounded">Boxed page</a>
	                                    <a href="/layout_boxed_content" class="dropdown-item rounded">Boxed content</a>
	                                </div>
	                            </div>
	                        </div>
	                    </div>
	                </li>
	                <li class="nav-item">
	                    <a href="#" class="navbar-nav-link dropdown-toggle rounded" data-bs-toggle="dropdown">
	                        <i class="ph-columns me-2"></i>
	                        Sidebars
	                    </a>

	                    <div class="dropdown-menu start-0 end-0 p-3 mx-md-3">
	                        <div class="row">
	                            <div class="col-md-3 mb-3 mb-md-0">
	                                <div class="fw-bold border-bottom pb-2 mb-2">Main</div>
	                                <div class="mb-3 mb-md-0">
	                                    <a href="sidebar_default_resizable" class="dropdown-item rounded">Resizable</a>
	                                    <a href="sidebar_default_resized" class="dropdown-item rounded">Resized</a>
	                                    <a href="sidebar_default_hideable" class="dropdown-item rounded">Hideable</a>
	                                    <a href="sidebar_default_hidden" class="dropdown-item rounded">Hidden</a>
	                                    <a href="sidebar_default_stretched" class="dropdown-item rounded">Stretched</a>
	                                    <a href="sidebar_default_color_dark" class="dropdown-item rounded">Dark color</a>
	                                </div>
	                            </div>
	                            <div class="col-md-3 mb-3 mb-md-0">
	                                <div class="fw-bold border-bottom pb-2 mb-2">Secondary</div>
	                                <div class="mb-3 mb-md-0">
	                                    <a href="sidebar_secondary_hideable" class="dropdown-item rounded">Hideable</a>
	                                    <a href="sidebar_secondary_hidden" class="dropdown-item rounded">Hidden</a>
	                                    <a href="sidebar_secondary_stretched" class="dropdown-item rounded">Stretched</a>
	                                    <a href="sidebar_secondary_color_dark" class="dropdown-item rounded">Dark color</a>
	                                </div>
	                            </div>
	                            <div class="col-md-3 mb-3 mb-md-0">
	                                <div class="fw-bold border-bottom pb-2 mb-2">Right</div>
	                                <div class="mb-3 mb-md-0">
	                                    <a href="sidebar_right_hideable" class="dropdown-item rounded">Hideable</a>
	                                    <a href="sidebar_right_hidden" class="dropdown-item rounded">Hidden</a>
	                                    <a href="sidebar_right_stretched" class="dropdown-item rounded">Stretched</a>
	                                    <a href="sidebar_right_color_dark" class="dropdown-item rounded">Dark color</a>
	                                </div>
	                            </div>
	                            <div class="col-md-3 mb-3 mb-md-0">
	                                <div class="fw-bold border-bottom pb-2 mb-2">Other</div>
	                                <div class="mb-3 mb-md-0">
	                                    <a href="sidebar_components" class="dropdown-item rounded">Sidebar components</a>
	                                </div>
	                            </div>
	                        </div>
	                    </div>
	                </li>
	                <li class="nav-item">
	                    <a href="#" class="navbar-nav-link dropdown-toggle rounded" data-bs-toggle="dropdown">
	                        <i class="ph-rows me-2"></i>
	                        Navbars
	                    </a>

	                    <div class="dropdown-menu start-0 end-0 p-3 mx-md-3">
	                        <div class="row">
	                            <div class="col-md-3 mb-3 mb-md-0">
	                                <div class="fw-bold border-bottom pb-2 mb-2">Single</div>
	                                <div class="mb-3 mb-md-0">
	                                    <a href="navbar_single_top_static" class="dropdown-item rounded">Top static</a>
	                                    <a href="navbar_single_top_fixed" class="dropdown-item rounded">Top fixed</a>
	                                    <a href="navbar_single_bottom_static" class="dropdown-item rounded">Bottom static</a>
	                                    <a href="navbar_single_bottom_fixed" class="dropdown-item rounded">Bottom fixed</a>
	                                </div>
	                            </div>
	                            <div class="col-md-3 mb-3 mb-md-0">
	                                <div class="fw-bold border-bottom pb-2 mb-2">Multiple</div>
	                                <div class="mb-3 mb-md-0">
	                                    <a href="navbar_multiple_top_static" class="dropdown-item rounded">Top static</a>
	                                    <a href="navbar_multiple_top_fixed" class="dropdown-item rounded">Top fixed</a>
	                                    <a href="navbar_multiple_bottom_static" class="dropdown-item rounded">Bottom static</a>
	                                    <a href="navbar_multiple_bottom_fixed" class="dropdown-item rounded">Bottom fixed</a>
	                                    <a href="navbar_multiple_top_bottom_fixed" class="dropdown-item rounded">Top and bottom fixed</a>
	                                    <a href="navbar_multiple_secondary_sticky" class="dropdown-item rounded">Secondary sticky</a>
	                                </div>
	                            </div>
	                            <div class="col-md-3 mb-3 mb-md-0">
	                                <div class="fw-bold border-bottom pb-2 mb-2">Content</div>
	                                <div class="mb-3 mb-md-0">
	                                    <a href="navbar_component_single" class="dropdown-item rounded">Single</a>
	                                    <a href="navbar_component_multiple" class="dropdown-item rounded">Multiple</a>
	                                </div>
	                            </div>
	                            <div class="col-md-3 mb-3 mb-md-0">
	                                <div class="fw-bold border-bottom pb-2 mb-2">Other</div>
	                                <div class="mb-3 mb-md-0">
	                                    <a href="navbar_colors" class="dropdown-item rounded">Color options</a>
	                                    <a href="navbar_sizes" class="dropdown-item rounded">Sizing options</a>
	                                    <a href="navbar_components" class="dropdown-item rounded">Navbar components</a>
	                                </div>
	                            </div>
	                        </div>
	                    </div>
	                </li>
	                <li class="nav-item">
	                    <a href="#" class="navbar-nav-link dropdown-toggle rounded" data-bs-toggle="dropdown">
	                        <i class="ph-list me-2"></i>
	                        Navigation
	                    </a>

	                    <div class="dropdown-menu start-0 end-0 p-3 mx-md-3">
	                        <div class="row">
	                            <div class="col-md-6 mb-3 mb-md-0">
	                                <div class="fw-bold border-bottom pb-2 mb-2">Vertical</div>
	                                <div class="mb-3 mb-md-0">
	                                    <a href="navigation_vertical_styles" class="dropdown-item rounded">Navigation styles</a>
	                                    <a href="navigation_vertical_collapsible" class="dropdown-item rounded">Collapsible menu</a>
	                                    <a href="navigation_vertical_accordion" class="dropdown-item rounded">Accordion menu</a>
	                                    <a href="navigation_vertical_bordered" class="dropdown-item rounded">Bordered navigation</a>
	                                    <a href="navigation_vertical_right_icons" class="dropdown-item rounded">Right icons</a>
	                                    <a href="navigation_vertical_badges" class="dropdown-item rounded">Badges</a>
	                                    <a href="navigation_vertical_disabled" class="dropdown-item rounded">Disabled items</a>
	                                </div>
	                            </div>
	                            <div class="col-md-6 mb-3 mb-md-0">
	                                <div class="fw-bold border-bottom pb-2 mb-2">Horizontal</div>
	                                <div class="mb-3 mb-md-0">
	                                    <a href="navigation_horizontal_styles" class="dropdown-item rounded">Navigation styles</a>
	                                    <a href="navigation_horizontal_elements" class="dropdown-item rounded">Navigation elements</a>
	                                    <a href="navigation_horizontal_tabs" class="dropdown-item rounded">Tabbed navigation</a>
	                                    <a href="navigation_horizontal_disabled" class="dropdown-item rounded">Disabled items</a>
	                                    <a href="navigation_horizontal_mega" class="dropdown-item rounded">Mega menu</a>
	                                </div>
	                            </div>
	                        </div>
	                    </div>
	                </li>
	                <li class="nav-item nav-item-dropdown-lg dropdown ms-lg-auto">
	                    <a href="#" class="navbar-nav-link dropdown-toggle rounded" data-bs-toggle="dropdown">
	                        <i class="ph-arrows-clockwise me-2"></i>
	                        Switch
	                    </a>

	                    <div class="dropdown-menu dropdown-menu-end">
	                        <div class="dropdown-submenu dropdown-submenu-start">
	                            <a href="#" class="dropdown-item dropdown-toggle">
	                                <i class="ph-swatches me-2"></i>
									{{ __('label.columns.admins.languages') }}
	                            </a>
	                            <div class="dropdown-menu">
	                                <a href="{{ route(\Illuminate\Support\Facades\Route::currentRouteName(), ['lang' => 'en'])}}" class="dropdown-item">
										{{ __('label.columns.admins.english') }}
	                                </a>
	                                <a href="{{ route(\Illuminate\Support\Facades\Route::currentRouteName(), ['lang' => 'ja']) }}" class="dropdown-item">
										{{ __('label.columns.admins.japanese') }}
	                                </a>
	                            </div>
	                        </div>
	                    </div>
	                </li>
	            </ul>
	        </div>
	    </div>
	</div>
	<!-- /navigation -->
