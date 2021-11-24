<div class="text-sm mt-6 mb-10">

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
                <a class="textLink" href="{{route('teachers.show', $teacher->slug)}}">{{$teacher->name}}</a>@if(!$loop->last),@endif
            @endforeach
        </div>
    @endif

    {{-- Organizers --}}
    @if(count($event->organizers))
        <div class="flex mt-2">
            <svg class="flex-shrink-0 mr-1.5 h-5 w-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"></path></svg>
            @foreach ($event->organizers as $key => $organizer)
                <a class="textLink" href="{{route('organizers.show', $organizer->slug)}}">{{$organizer->name}}</a>@if(!$loop->last),@endif
            @endforeach
        </div>
    @endif

    {{-- Repetitions --}}
    @if(!empty($repetitionTextString))
        <div class="flex flex-col md:flex-row mt-3">
            <div class="flex">
                <svg class="flex-shrink-0 mr-1.5 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                <div>{{$repetitionTextString}}</div>
            </div>
        </div>
    @endif

    @if(!empty($event->website_event_link) || !empty($event->facebook_event_link))
        <div class="grid grid-cols-2 gap-2 mt-3">
            <div class="col-span-2 md:col-span-1 flex flex-col md:flex-row">
                @if(!empty($event->website_event_link))
                    <div class="flex">
                        <svg class="flex-shrink-0 h-5 w-5 mr-1.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path>
                        </svg>
                        <a class="textLink" target="_blank" href="{{$event->website_event_link}}">@lang('event.website_event_link')</a>
                    </div>
                @endif
            </div>

            <div class="col-span-2 md:col-span-1 flex flex-col md:flex-row mt-2 md:mt-0">
                @if(!empty($event->facebook_event_link))
                    <div class="flex">
                        <svg class="flex-shrink-0 h-5 w-5 mr-1.5" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" stroke="currentColor">
                            <path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd"></path>
                        </svg>
                        <a class="textLink" target="_blank" href="{{$event->facebook_event_link}}">@lang('event.facebook_event_link')</a>
                    </div>
                @endif
            </div>
        </div>
    @endif


    {{-- Google calendar and iCal links --}}
    @if(isset($calendarLink))
        <div class="grid grid-cols-2 gap-2 mt-3">
            <div class="col-span-2 md:col-span-1 flex flex-col md:flex-row">
                <div class="flex">
                    <svg class="flex-shrink-0 h-5 w-5 mr-1.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                    </svg>
                    <a class="textLink" target="_blank" href="{{$calendarLink->google()}}">@lang('event.add_to_google_calendar')</a>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1 flex flex-col md:flex-row mt-2 md:mt-0">
                <div class="flex">
                    <svg class="flex-shrink-0 h-5 w-5 mr-1.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                    <a class="textLink" target="_blank" href="{{$calendarLink->ics()}}">@lang('event.download_i_calendar_file')</a>
                </div>
            </div>
        </div>
    @endif

</div>
