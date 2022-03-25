@component('mail::message')

# Message from the Global CI Calendar

**{{$data['name']}}** is claiming the ownership about this event: <br>
**{{$event->title}}**

{{$data['message']}}


Check out the event:
@component('mail::button', ['url' => config('app.name')."/events/".$event->slug ])
    Open event
@endcomponent

@component('mail::button', ['url' => 'mailto:'.$data['email']])
    Reply to {{$data['name']}}
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
