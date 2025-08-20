<ul class="nav nav-tabs mb-4">
    <li class="nav-item">
        <a href="{{ route('admin.profile.edit') }}"
           class="nav-link {{ Route::current()->getName() == 'admin.profile.edit' ? 'active' : '' }}">{{ __('label.labels.basic_info') }}</a>
    </li>
    <li class="nav-item">
        <a href="{{ route('admin.profile.edit_permissions') }}"
           class="nav-link {{ Route::current()->getName() == 'admin.profile.edit_permissions' ? 'active' : '' }}">{{ __('label.labels.permission_setting') }}</a>
    </li>
    <li class="nav-item">
        <a href="{{ route('admin.profile.edit_password') }}"
           class="nav-link  {{ Route::current()->getName() == 'admin.profile.edit_password' ? 'active' : '' }}">{{ __('label.labels.password_setting') }}</a>
    </li>
</ul>
