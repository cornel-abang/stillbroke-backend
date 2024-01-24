@component('mail::message')
# Stillbroke - Password Reset

Dear {{ $name }}<br>

Kindly click the link below to set a new password for your account.

<a href="{{ config('app.frontend_pass_reset_url') }}">{{ config('app.frontend_pass_reset_url') }}</a><br/><br/>

Cheers,<br>
{{ config('app.name') }}
@endcomponent
