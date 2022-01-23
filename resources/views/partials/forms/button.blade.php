{{--
    ButtonLink form field

    PARAMETERS:
        - $title: string - the title to show
        - $url: the url to bring to
        - $color: the tailwind color class
        - $icon: svg HTML of the hero icon or others. (Use double quotes for attributes ")
        - $size: 1-5
        - $kind: 'primary', 'secondary', 'white'
        - $target: '_self', '_blank'

        TODO - ADD ALSO THE OUTLINE BUTTON STYLE!!
        https://tailwindcomponents.com/component/tailwind-css-buttons

--}}

@php
    $sizeClasses = match ($size) {
        1 => 'px-2.5 py-1.5 text-xs rounded shadow-sm',
        2 => 'px-3 py-2 text-sm leading-4 rounded-md shadow-sm',
        3 => 'px-4 py-2 text-sm rounded-md shadow-sm',
        4 => 'px-4 py-2 text-base rounded-md shadow-sm',
        5 => 'px-6 py-3 text-base rounded-md shadow-sm',
        default => 'px-2.5 py-1.5 text-xs rounded shadow-sm',
    };

    $kindClasses = match ($kind) {
        'primary' => 'border-transparent shadow-sm text-white bg-'.$color.'-500 hover:bg-'.$color.'-700',
        'secondary' => 'border-transparent text-'.$color.'-700 bg-'.$color.'-100 hover:bg-'.$color.'-200',
        'white' => 'border-gray-300 shadow-sm text-gray-700 bg-white hover:bg-gray-50',

        default => 'border-gray-300 shadow-sm text-gray-700 bg-white hover:bg-gray-50',
    };
@endphp


<a href="{{ $url }}" target="{{$target}}"
   class="inline-flex items-center border font-medium focus:outline-none focus:ring-2 focus:ring-offset-2 {{$kindClasses}} {{$sizeClasses}} {{$extraClasses}}">
    {!! $icon !!}
    <div class="inline-block">{{$title}}</div>
</a>