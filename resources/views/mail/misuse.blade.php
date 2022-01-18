
@component('mail::message')

# Report from the Global CI Calendar


@if( $data['reason'] == __('misuse.not_translated_english'))
A user interested in your event is willing to read an english translation:
Event name: **{{$event->title}}**.
@else
A user have reported this event:
**{{$event->title}}**.

**Reason**
{{$data['reason']}}
@endif

@if(!empty($data['message']))
**Message**
{{$data['message']}}
@endif

@component('mail::button', ['url' => config('app.url').'/events/'.$event->slug])
    Show me the event
@endcomponent

@if( $data['reason'] != __('misuse.not_translated_english'))
@component('mail::button', ['url' => config('app.url').'events/'.$event->id.'/edit'])
    Edit event
@endcomponent
@endif

Thanks,<br>
{{ config('app.name') }}
@endcomponent
