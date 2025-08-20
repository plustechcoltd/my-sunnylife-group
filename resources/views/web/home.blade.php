@extends('web.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('label.labels.dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    @if(auth('user')->check())
                    {{ __('You are logged in!') }}
                    @else
                    {{ __('You are guest!') }}
                    @endif
                    <a href="{{ route('web.contacts.index') }}" type="button" class="btn btn-light">
                        <i class="ph-telegram-logo me-2"></i>
                        Contact Us
                    </a>
                    @if(auth('user')->check())
                    <a href="{{ route('web.chats.index') }}" type="button" class="btn btn-light">
                        <i class="ph-telegram-logo me-2"></i>
                        Chat
                    </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
