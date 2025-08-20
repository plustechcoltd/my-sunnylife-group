<div class="row">
    <div class="col-lg-8 offset-lg-2">
        <div class="mb-3">
            <div class="form-group mb-3">
                <label class="form-label">{{ __('passwords.new_password') }}</label>
                <input name="password" type="password" placeholder="" class="form-control @if($errors->has('password')) is-invalid @endif">
                @if($errors->has('password'))
                    <div class="validation-invalid-label">{{$errors->first('password')}}</div>
                @endif
            </div>

            <div class="form-group">
                <label class="form-label">{{ __('passwords.confirm_password') }}</label>
                <input name="password_confirmation" type="password" placeholder="" class="form-control @if($errors->has('password_confirmation')) is-invalid @endif">
                @if($errors->has('password_confirmation'))
                    <div class="validation-invalid-label">{{$errors->first('password_confirmation')}}</div>
                @endif
            </div>
        </div>
    </div>
</div>
