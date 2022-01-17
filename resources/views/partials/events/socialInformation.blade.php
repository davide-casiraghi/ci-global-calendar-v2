<div class="border-t border-gray-200 bg-white p-6">
    @if(!empty($event->website_event_link) || !empty($event->facebook_event_link))
        <div class="grid grid-cols-2 gap-2">
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