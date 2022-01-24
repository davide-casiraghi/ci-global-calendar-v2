@component('mail::message')

# Message from the Global CI Calendar

Dear {{$event->user->profile->name}} {{$event->user->profile->surname}},

The event you published on the calendar called **{{$event->title}}**
is going to expire in one week.

If the event is continuing or if you are planning already to do it
in the next season please update the dates.

In this way it will not disappear.


@component('mail::button', ['url' => 'mailto:'.$senderData['emailFrom']])
    Reply to {{$senderData['senderName']}}
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent