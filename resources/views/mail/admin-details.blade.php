@component('mail::message')
# Stillbroke - Your account details

Hi {{ $info['first_name'] }}<br>

An account has been created for you on the Stillbroke online store CMS <br>

Your account login details: <br>

<strong>Email:</strong> {{ $info['email']}}<br>
<strong>Password:</strong> {{ $info['password']}}<br>

Thanks,<br>
{{ config('app.name') }}
@endcomponent