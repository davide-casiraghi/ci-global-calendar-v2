@php
    $backgroundAndTextColors = match ($color) {
        'yellow' => 'bg-yellow-100 text-yellow-700',
        'green' => 'bg-green-100 text-green-700',
        'red' => 'bg-red-100 text-red-700',
        default => 'bg-green-100 text-green-700',
    };

@endphp

<div class="{{$backgroundAndTextColors}} rounded-lg py-5 px-6 text-base {{$extraClasses}}" role="alert">
    {!! $message !!}
</div>



