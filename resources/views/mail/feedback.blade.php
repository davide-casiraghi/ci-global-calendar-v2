@component('mail::message')
# Message from the Global CI Calendar

You have received a message from **{{$data['name']}}**.

{{$data['message']}} <br><br>

@component('mail::button', ['url' => 'mailto:'.$data['email']])
Reply to {{$data['name']}}
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
