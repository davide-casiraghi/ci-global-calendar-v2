
@component('mail::message')

# Report from the Global CI Calendar

A user have reported this event:
**{{$event->title}}**.

A user interested in your event is willing to read an english translation:
Event name: **{{$event->title}}**.

**Reason**
{{$data['reason']}}

@if(!empty($data['message']))
**Message**
{{$data['message']}}
@endif

@component('mail::button', ['url' => config('app.url').'events/'.$event->id])
    Show me the event
@endcomponent
@component('mail::button', ['url' => config('app.url').'events/'.$event->id.'/edit'])
    Edit event
@endcomponent
{{--
@component('mail::button', ['url' => 'mailto:'.$sender_email])
Reply to {{$sender_name}}
@endcomponent--}}

Thanks,<br>
{{ config('app.name') }}
@endcomponent
