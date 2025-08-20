<ul class="nav nav-tabs mb-4">
    <li class="nav-item">
        <a href="{{ route('admin.admins.edit', $admin->id) }}"
           class="nav-link {{ Route::current()->getName() == 'admin.admins.edit' ? 'active' : '' }}">{{ __('label.labels.basic_info') }}</a>
    </li>
    <li class="nav-item">
        <a href="{{ route('admin.admins.edit_permissions', $admin->id) }}"
           class="nav-link {{ Route::current()->getName() == 'admin.admins.edit_permissions' ? 'active' : '' }}">{{ __('label.labels.permission_setting') }}</a>
    </li>
    <li class="nav-item">
        <a href="{{ route('admin.admins.edit_password', $admin->id) }}"
           class="nav-link  {{ Route::current()->getName() == 'admin.admins.edit_password' ? 'active' : '' }}">{{ __('label.labels.password_setting') }}</a>
    </li>
</ul>
