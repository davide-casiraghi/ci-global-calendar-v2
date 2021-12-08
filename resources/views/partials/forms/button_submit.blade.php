{{--
    ButtonLink form field

    PARAMETERS:
        - $title: string - the title to show
        - $color: the tailwind color class
        - $icon: svg HTML of the hero icon or others. (Use double quotes for attributes ")
        - $size: 1-5
        - $kind: 'primary', 'secondary', 'white'

        TODO - ADD ALSO THE OUTLINE BUTTON STYLE!!
        https://tailwindcomponents.com/component/tailwind-css-buttons

--}}

@switch($size)
    @case(1)
        @php ($sizeClasses = 'px-2.5 py-1.5 text-xs rounded shadow-sm')
    @break

    @case(2)
        @php ($sizeClasses = 'px-3 py-2 text-sm leading-4 rounded-md shadow-sm')
    @break

    @case(3)
        @php ($sizeClasses = 'px-4 py-2 text-sm rounded-md shadow-sm')
    @break

    @case(4)
        @php ($sizeClasses = 'px-4 py-2 text-base rounded-md shadow-sm')
    @break

    @case(5)
        @php ($sizeClasses = 'px-6 py-3 text-base rounded-md shadow-sm')
    @break

@endswitch

@switch($kind)
    @case('primary')
        @php ($kindClasses = 'border-transparent shadow-sm text-white bg-'.$color.'-600 hover:bg-'.$color.'-700')
    @break

    @case('secondary')
        @php ($kindClasses = 'border-transparent text-'.$color.'-700 bg-'.$color.'-100 hover:bg-'.$color.'-200')
    @break

    @case('white')
        @php ($kindClasses = 'border-gray-300 shadow-sm text-gray-700 bg-white hover:bg-gray-50')
    @break

@endswitch



{{--<a href="{{ $url }}" target="{{$target}}"
   class="">
    {!! $icon !!}
    <div class="inline-block">{{$title}}</div>
</a>--}}

{{-- ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 --}}

<button type="submit" name="btn_submit" class="inline-flex items-center border font-medium focus:outline-none focus:ring-2 focus:ring-offset-2 {{$kindClasses}} {{$sizeClasses}} {{$extraClasses}}">
    {{$title}}
</button>