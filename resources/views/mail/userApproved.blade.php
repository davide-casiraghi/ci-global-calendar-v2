@component('mail::message')
    # Registration request approved from CI Global Calendar

    @if(!empty($user->name))
        Hi: <b>{{$user->name}}</b>.<br>
    @endif
    Your subscription request to the CI Global Calendar system has been approved by an administrator.<br>
    You can now login to the portal and fully access to all the services.<br><br>

    <br>
    <br>
    Thanks,<br>
    {{ config('app.name') }}

@endcomponent
