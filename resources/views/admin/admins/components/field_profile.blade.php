<div class="row">
    <div class="col-lg-8 offset-lg-2">
        <div class="row">
            <div class="col-lg-6 mb-3">
                <label class="form-label">{{ __('label.columns.admins.family_name') }}</label>
                <input class="form-control @if($errors->has('family_name')) is-invalid @endif"
                       type="text" name="family_name"
                       value="{{ old('family_name', $admin->family_name) }}">
                @if($errors->has('family_name'))
                    <div class="validation-invalid-label">{{$errors->first('family_name')}}</div>
                @endif
            </div>
            <div class="col-lg-6 mb-3">
                <label class="form-label">{{ __('label.columns.admins.first_name') }}</label>
                <input class="form-control  @if($errors->has('first_name')) is-invalid @endif"
                       type="text" name="first_name"
                       value="{{ old('first_name', $admin->first_name) }}">
                @if($errors->has('first_name'))
                    <div class="validation-invalid-label">{{$errors->first('first_name')}}</div>
                @endif
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label">{{ __('label.columns.admins.gender') }}</label>
            <div>
                @foreach(config('const.gender_types') as $value)
                    <label class="form-check form-check-inline">
                        <input type="radio" class="form-check-input" name="gender"
                               value="{{ $value }}" {{ old('gender', $admin->gender) == $value ? 'checked' : '' }}>
                        <span class="form-check-label">{{ __('const.gender_types.' . $value) }}</span>
                    </label>
                @endforeach
            </div>
        </div>
        <div class="mb-3">
            <div class="form-group">
                <label class="form-label">{{ __('label.columns.admins.email') }}</label>
                <div class="form-control-feedback form-control-feedback-start mb-3">
                    <input type="text"
                           class="form-control @if($errors->has('email')) is-invalid @endif"
                           name="email"
                           aria-describedby="basic-addon1"
                           value="{{ old('email', $admin->email) }}">
                    <div class="form-control-feedback-icon">
                        <i class="ph-identification-card"></i>
                    </div>
                </div>
                @if($errors->has('email'))
                    <div class="validation-invalid-label">{{$errors->first('email')}}</div>
                @endif
            </div>
        </div>
        <div class="mb-3">
            <div class="form-group">
                <label class="form-label">{{ __('label.columns.admins.phone') }}</label>
                <div class="form-control-feedback form-control-feedback-start mb-3">
                    <input type="text"
                           class="form-control @if($errors->has('phone')) is-invalid @endif"
                           name="phone" value="{{ old('phone',$admin->phone) }}">
                    <div class="form-control-feedback-icon">
                        <i class="ph-phone"></i>
                    </div>
                </div>
                @if($errors->has('phone'))
                    <div class="validation-invalid-label">{{$errors->first('phone')}}</div>
                @endif
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label">{{ __('label.columns.admins.avatar_image_path') }}</label>
            <div class="mb-3 {{ $admin->avatar_image_path ?? 'd-none' }}">
                <img id="preview" src="{{ $admin->avatar_image_path ? route('admin.admins.show_avatar', ['admin' => $admin->id]) : '' }}" class="w-64px h-64px" alt="">
            </div>
            <input type="file" class="form-control" name="avatar" id="avatar" onchange="previewFile($('#avatar'))">
            <div class="form-text text-muted">Accepted formats: gif, png, jpg. Max file size 2Mb</div>
        </div>

        <div class="mb-3">
            <label class="form-label">{{ __('label.columns.admins.language') }}</label>
            <div>
                @foreach(config('const.language_codes') as $language)
                    <label class="form-check form-check-inline">
                        <input type="radio" class="form-check-input" name="language"
                               value="{{ $language }}" {{ old('language', $admin->language) == $language ? 'checked' : '' }}>
                        <span class="form-check-label">{{ __('const.language_labels.' . $language) }}</span>
                    </label>
                @endforeach
            </div>
        </div>

        @can('admin:admins')
            <div class="mb-3">
                <div class="form-group">
                    <label for="allowed_ips" class="form-label fw-semibold">許可されたIPアドレス</label>
                    <input name="allowed_ips" id="allowed_ips" type="text"
                           class="form-control tokenfield @if($errors->has('allowed_ips')) is-invalid @endif"
                           value="{{ old('allowed_ips', is_array($admin['allowed_ips']) ? implode(",", $admin['allowed_ips']) : '') }}"
                    >
                    @if($errors->has('allowed_ips'))
                        <div class="validation-invalid-label">{{$errors->first('allowed_ips')}}</div>
                    @endif
                </div>
            </div>
        @endcan
    </div>
</div>
