<div class="row">
    <div class="col-lg-8 offset-lg-2">
        <div class="mb-3">
            <label class="form-label">{{ __('label.columns.admins.admin_permissions') }}</label>
            <div class="row">
                @foreach ($permissions as $permission)
                    <div class="col-lg-3 mb-2">
                        <label class="form-check cursor-pointer">
                            <input class="form-check-input @if($errors->has('admin_permissions')) is-invalid @endif"
                                   type="checkbox" name="admin_permissions[]"
                                   value="{{ $permission->id }}"
                                    {{ $admin->permissions->contains($permission->id) ? 'checked' : '' }}>
                            <span class="form-check-label">{{ __('const.permissions.' . $permission->name) }}</span>
                        </label>
                    </div>
                @endforeach
            </div>
            @if($errors->has('admin_permissions'))
                <div class="validation-invalid-label">{{$errors->first('admin_permissions')}}</div>
            @endif
        </div>
    </div>
</div>
