<ul class="nav nav-tabs mb-4">
    <li class="nav-item">
        <a href="{{ route('admin.users.edit', $user->id) }}"
           class="nav-link {{ Route::current()->getName() == 'admin.users.edit' ? 'active' : '' }}">{{ __('label.labels.basic_info') }}</a>
    </li>
    <li class="nav-item">
        <a href="{{ route('admin.users.edit_password', $user->id) }}"
           class="nav-link  {{ Route::current()->getName() == 'admin.users.edit_password' ? 'active' : '' }}">{{ __('label.labels.password_setting') }}</a>
    </li>
    <li class="nav-item">
        <a href="{{ route('admin.users.edit_manager', $user->id) }}"
           class="nav-link  {{ Route::current()->getName() == 'admin.users.edit_manager' ? 'active' : '' }}">{{ __('label.labels.edit_manager') }}</a>
    </li>
</ul>
