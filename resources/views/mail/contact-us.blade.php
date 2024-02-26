@component('mail::message')
# Stillbroke - User Contact

Hey Admin<br>

A user has just sent a message through the contact us form on the website.
Details below: <br><br>
<strong>Name:</strong> {{ $info['name'] }}<br><br>
<strong>Message:</strong> <blockquote><p>{{ $info['message'] }} </p></blockquote> <br>

Kindly login to check more detail

Cheers,<br>
{{ config('app.name') }}
@endcomponent