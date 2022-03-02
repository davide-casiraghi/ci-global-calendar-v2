<div class="text-base text-gray-600 bg-white p-6">

    {{-- Category --}}
    <div class="flex mt-3">
        <svg class="flex-shrink-0 mr-1.5 h-5 w-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M17.707 9.293a1 1 0 010 1.414l-7 7a1 1 0 01-1.414 0l-7-7A.997.997 0 012 10V5a3 3 0 013-3h5c.256 0 .512.098.707.293l7 7zM5 6a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path></svg>
        <div>{{$event->category->name}}</div>
    </div>

    {{-- Location --}}
    <div class="flex mt-3">
        <svg class="flex-shrink-0 mr-1.5 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
        <div>{{$event->venue->name}}  -  {{ $event->venue->address }}, {{ $event->venue->city }}, {{ $event->venue->country->name }} - <a class="textLink" href="#map" name="map">Show map</a></div>
    </div>

    {{-- Teachers --}}
    @if(count($event->teachers))
        <div class="flex mt-2">
            <svg class="flex-shrink-0 mr-1.5 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
            @foreach ($event->teachers as $key => $teacher)
                <a class="textLink" href="{{route('teachers.show', $teacher->slug)}}">{{$teacher->full_name}}</a>@if(!$loop->last),&nbsp @endif
            @endforeach
        </div>
    @endif

    {{-- Organizers --}}
    @if(count($event->organizers))
        <div class="flex mt-2">
            <svg class="flex-shrink-0 mr-1.5 h-5 w-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"></path></svg>
            @foreach ($event->organizers as $key => $organizer)
                <a class="textLink" href="{{route('organizers.show', $organizer->slug)}}">{{$organizer->full_name}}</a>@if(!$loop->last),&nbsp @endif
            @endforeach
        </div>
    @endif

    {{-- Repetitions --}}
    @if(!empty($repetitionTextString))
        <div class="flex flex-col md:flex-row mt-3">
            <div class="flex items-center">
                <svg class="flex-shrink-0 mr-1.5 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                <div>{{$repetitionTextString}}</div>
            </div>
        </div>
    @endif

    {{-- Time --}}
    <div class="flex items-center mt-3">
        <svg aria-hidden="true" focusable="false" data-prefix="far" data-icon="clock" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="flex-shrink-0 mr-1.5 h-5 w-5"><path fill="currentColor" d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8zm0 448c-110.5 0-200-89.5-200-200S145.5 56 256 56s200 89.5 200 200-89.5 200-200 200zm61.8-104.4l-84.9-61.7c-3.1-2.3-4.9-5.9-4.9-9.7V116c0-6.6 5.4-12 12-12h32c6.6 0 12 5.4 12 12v141.7l66.8 48.6c5.4 3.9 6.5 11.4 2.6 16.8L334.6 349c-3.9 5.3-11.4 6.5-16.8 2.6z" class=""></path></svg>
        <div>
            @lang('general.starts_at') @time_am_pm($eventFirstRepetition['start_repeat']) - @lang('general.ends_at') @time_am_pm($eventFirstRepetition['end_repeat'])
        </div>
    </div>

</div>

