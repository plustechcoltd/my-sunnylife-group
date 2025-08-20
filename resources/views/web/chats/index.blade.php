@extends('web.layouts.app')

@section('title', 'Chat' . '｜' . config('meta.common_title'))
@section('description', 'Chat system built with ' . config('meta.common_description'))
@section('keywords', 'chat1,chat2,chat3')
@section('canonical', request()->url())
@section('robots', "noindex,nofollow")

@section('content')
    <div class="p-4">
        <div class="text-center">
            <div class="mb-4">
                <h3 class="fw-semibold">No messages yet</h3>
                <p class="text-muted">You can't start a new conversation until you have a message from administrator.</p>
            </div>
        </div>
    </div>
@endsection
