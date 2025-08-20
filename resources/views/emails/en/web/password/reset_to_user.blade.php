<h1>Reset Password Notification</h1>

<p>You are receiving this email because we received a password reset request for your account.</p>

<p>
    <a href="{{ $url }}"
       style="display: inline-block; padding: 10px 20px; font-size: 16px; color: #fff; background-color: #007bff; text-decoration: none; border-radius: 5px;">
        Reset Password
    </a>
</p>

<p>This password reset link will expire in {{ $count }} minutes.</p>

<p>If you did not request a password reset, no further action is required.</p>

<p>Regards,<br>{{ config('app.name') }}</p>

<p>
    If you’re having trouble clicking the "Reset Password" button, copy and paste the URL below into your web
    browser:<br>
    <a href="{{ $url }}">{{ $url }}</a>
</p>
