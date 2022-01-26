@component('mail::message')

# Message from the Global CI Calendar

@if(!empty($user->name))
Hi: <b>{{$user->name}}</b><br>.
@endif
Please click the button below to verify your email address and to complete your member profile.

<a href="{{$verifyUrl}}">Verify Email Address</a>

Regards,<br>
{{ config('app.name') }}

