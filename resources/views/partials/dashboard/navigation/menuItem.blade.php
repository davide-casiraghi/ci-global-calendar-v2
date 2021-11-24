
@if($active)
    @php
        $itemActiveClasses = "bg-gray-900 text-white group flex items-center px-2 py-2 font-medium rounded-md";
        $iconActiveClasses = 'text-gray-300 h-6 w-6';
    @endphp
@else
    @php
        $itemActiveClasses = "text-gray-300 hover:bg-gray-700 hover:text-white group flex items-center px-2 py-2 font-medium rounded-md";
        $iconActiveClasses = 'text-gray-400 group-hover:text-gray-300 h-6 w-6';
    @endphp
@endif

@switch($kind)
    @case('desktop')
        @php
            $itemKindClasses = 'text-sm';
            $iconKindClasses = 'mr-3';
        @endphp
    @break

    @case('mobile')
        @php
            $itemKindClasses = 'text-base';
            $iconKindClasses = 'mr-4';
        @endphp
    @break

@endswitch


<!-- Heroicon name: home -->

<a href="{{$url}}" class="{{$itemActiveClasses}} {{$itemKindClasses}}">
    <svg class="{{$iconActiveClasses}} {{$iconKindClasses}}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
        {!! $heroIconPath !!}
    </svg>
    {{$label}}
</a>
