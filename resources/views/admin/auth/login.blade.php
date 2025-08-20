@extends('admin.layouts.master_login')
@section('title')
    {{ __('label.labels.login') }}
@endsection
@section('content')
    <!-- Content area -->
    <div class="content d-flex justify-content-center align-items-center">

        <!-- Login form -->
        <form class="login-form" method="POST" action="{{ route('admin.login') }}">
            @csrf
            <div class="card mb-0">
                <div class="card-body">
                    <div class="text-center mb-3">
                        <div class="d-inline-flex align-items-center justify-content-center mb-4 mt-2">
                        <img src="{{ URL::asset($settings['logo_login'] ? 'storage/'.$settings['logo_login'] : 'assets/admin/images/logo_icon.svg') }}" class="h-48px" alt="">
                        </div>
                        <h5 class="mb-0">{{ __('auth.login.title') }}</h5>
                        <span class="d-block text-muted">{{ __('auth.login.sub_title') }}</span>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">{{ __('auth.login.email_address') }}</label>
                        <div class="form-control-feedback form-control-feedback-start">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                   name="email" value="{{ old('email') }}" required autocomplete="email" autofocus
                                   placeholder="john@doe.com">
                            <div class="form-control-feedback-icon">
                                <i class="ph-user-circle text-muted"></i>
                            </div>
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">{{ __('auth.login.password') }}</label>
                        <div class="form-control-feedback form-control-feedback-start">
                            <input id="password" type="password"
                                   class="form-control @error('password') is-invalid @enderror" name="password" required
                                   autocomplete="current-password" placeholder="•••••••••••">
                            <div class="form-control-feedback-icon">
                                <i class="ph-lock text-muted"></i>
                            </div>
                            @error('password')
                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember"
                                   id="remember" {{ old('remember') ? 'checked' : '' }}>

                            <label class="form-check-label" for="remember">
                                {{ __('auth.login.remember_me') }}
                            </label>
                        </div>
                    </div>

                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary w-100"> {{ __('label.buttons.login') }}</button>
                    </div>

                    <div class="text-center">
                        @if (Route::has('admin.password.request'))
                            <a href="{{ route('admin.password.request') }}">
                                {{ __('auth.login.forgot_password') }}
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </form>
        <!-- /login form -->

    </div>
    <!-- /content area -->

@endsection
