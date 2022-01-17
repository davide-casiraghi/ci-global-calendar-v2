@component('mail::message')

# Message from the Global CI Calendar

You have received a message from **{{$data['name']}}** about your event **{{$event->title}}**

{{$data['message']}}


@component('mail::button', ['url' => 'mailto:'.$data['email']])
    Reply to {{$data['name']}}
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
