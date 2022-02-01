@php
    $backgroundAndTextColors = match ($color) {
        'warning' => 'bg-yellow-100 text-yellow-700',
        'success' => 'bg-green-100 text-green-700',
        'danger' => 'bg-red-100 text-red-700',
        'gray' => 'bg-gray-100 text-gray-700',
        default => 'bg-green-100 text-green-700',
    };

@endphp

<div class="{{$backgroundAndTextColors}} rounded-lg py-5 px-6 text-base {{$extraClasses}}" role="alert">
    {!! $message !!}
</div>



