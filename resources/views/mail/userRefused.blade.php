@component('mail::message')
    # Registration request approved from CI Global Calendar

    @if(!empty($user->name))
        Hi: <b>{{$user->name}}</b>.<br>
    @endif
    Your subscription request to the CI Global Calendar has been refused by an administrator.<br><br>

    If you have any further question you can contact us using the feedback form that you can find in the homepage.<br>

    <br>
    <br>
    Thanks,<br>
    {{ config('app.name') }}

@endcomponent
