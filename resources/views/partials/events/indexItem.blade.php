<li>
    <a href="{{route('events.edit', $event)}}" class="block hover:bg-gray-50">
        <div class="px-4 py-4 sm:px-6 flex items-center justify-between">
            <div>
                <div class="text-sm font-medium text-indigo-600">
                    {{$event->title}}
                </div>
                <div class="mt-2 sm:flex sm:justify-start text-sm text-gray-500">
                    {{-- Country --}}
                    <div class="flex mt-3 sm:mt-0">
                        <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM4.332 8.027a6.012 6.012 0 011.912-2.706C6.512 5.73 6.974 6 7.5 6A1.5 1.5 0 019 7.5V8a2 2 0 004 0 2 2 0 011.523-1.943A5.977 5.977 0 0116 10c0 .34-.028.675-.083 1H15a2 2 0 00-2 2v2.197A5.973 5.973 0 0110 16v-2a2 2 0 00-2-2 2 2 0 01-2-2 2 2 0 00-1.668-1.973z" clip-rule="evenodd"></path></svg>
                        <p>{{$event->venue->country->name}}</p>
                    </div>

                    {{-- Category --}}
                    <div class="flex mt-2 sm:mt-0 sm:ml-2">
                        <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M17.707 9.293a1 1 0 010 1.414l-7 7a1 1 0 01-1.414 0l-7-7A.997.997 0 012 10V5a3 3 0 013-3h5c.256 0 .512.098.707.293l7 7zM5 6a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path></svg>
                        <p>{{$event->category->name}}</p>
                    </div>

                    {{-- Teachers --}}
                    <div class="flex mt-2 sm:mt-0 sm:ml-2">
                        @if($event->teachers->count())
                            <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"></path></svg>
                            <p>{{$event->teachers->implode('full_name', ', ')}}</p>
                        @endif
                    </div>
                </div>
                <div class="mt-0 sm:mt-2 flex justify-start text-sm text-gray-500">
                    {{-- Event date or repetition string --}}
                    <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                    </svg>
                    <div>
                        @php
                            $eventFirstRepetition = $eventRepetitionService->getFirstByEventId($event->id);
                            $repetitionTextString = $eventService->getRepetitionTextString($event, $eventFirstRepetition);
                        @endphp
                        {{$repetitionTextString}}
                    </div>
                </div>
            </div>
            <div>
                @if($event->hasMedia('introimage'))
                    <img class="h-14" src='{{$event->getMedia('introimage')->first()->getUrl('thumb')}}' />
                @endif
            </div>
        </div>
    </a>
</li>
