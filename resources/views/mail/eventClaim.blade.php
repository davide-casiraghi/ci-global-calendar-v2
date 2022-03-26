@component('mail::message')

# Event claim from the CI Global Calendar

**{{$user->profile->name}} {{$user->profile->surname}}** is claiming the ownership about this event: <br>
**{{$event->title}}**

{{$data['message']}}


Check out the event:
@component('mail::button', ['url' => config('app.name')."/events/".$event->slug ])
    Open event
@endcomponent

@component('mail::button', ['url' => 'mailto:'.$user->email])
    Reply to {{$user->profile->name}} {{$user->profile->surname}}
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
