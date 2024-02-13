@component('mail::message')
# Stillbroke - Password Changed

Dear {{ $user_name }}<br>

You password has been reset.<br>
Remember to use your new password to login from now.

Cheers,<br>
{{ config('app.name') }}
@endcomponent