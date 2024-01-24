@component('mail::message')
# Stillbroke - Email verification

Dear {{ auth()->user()->last_name }} {{ auth()->user()->first_name }}<br>

Thank you for shopping with Stillbroke <span style='font-size:20px;'>&#128522;</span><br>

Kindly verify your email address by clicking the link below

<a href="{{
    sprintf(
        config('app.frontend_verify_url'), 
        $verifyCode['code'],
        $verifyCode['user_id'], 
        $verifyCode['email']
    )
}}">
{{
    sprintf(
        config('app.frontend_verify_url'), 
        $verifyCode['code'],
        $verifyCode['user_id'], 
        $verifyCode['email']
    )
}}</a><br/><br/>

Thanks,<br>
{{ config('app.name') }}
@endcomponent
