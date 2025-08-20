@extends('web.layouts.app')
@section('title')
    {{ __('label.labels.contact') }}
@endsection
@section('content')
    <!-- Content area -->
    <div class="content d-flex justify-content-center align-items-center">

        <!-- Login form -->
        <form class="login-form" method="POST" action="{{ route('web.contacts.store') }}">
            @csrf
            <div class="card mb-0">
                <div class="card-body">
                    <div class="mb-3">
                        <label for="email" class="form-label">{{ __('label.columns.contacts.email') }}</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                name="email" value="{{ old('email') }}" required autocomplete="email" autofocus
                                placeholder="john@doe.com">
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="title" class="form-label">{{ __('label.columns.contacts.title') }}</label>
                        <input id="title" type="title" class="form-control @error('title') is-invalid @enderror"
                                name="title" value="{{ old('title') }}" required autocomplete="title">
                        @error('title')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="content" class="form-label">{{ __('label.columns.contacts.content') }}</label>
                        <textarea id="content" type="text"
                                class="form-control @error('content') is-invalid @enderror" name="content" required
                                placeholder=""></textarea>
                        
                        @error('content')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary w-100"> {{ __('label.buttons.submit') }}</button>
                    </div>
                </div>
            </div>
        </form>
        <!-- /login form -->

    </div>
    <!-- /content area -->

@endsection
@include('admin.components.flash-message')