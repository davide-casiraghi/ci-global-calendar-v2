<div class="">
    @forelse($events as $event)
        <div class="md:grid md:grid-cols-12 p-1 @if ($loop->iteration % 2 == 0) bg-white @else bg-gray-50 @endif ">

            <div class="md:col-span-1 whitespace-nowrap text-sm text-gray-500">
                <div class="row uppercase h-full flex"> {{--per far andare a capo quando stringo flex-wrap --}}

                    {{-- One day event --}}
                    @if (Carbon\Carbon::parse($event->start_repeat)->format('d-m-Y') == Carbon\Carbon::parse($event->end_repeat)->format('d-m-Y'))
                        <div class='col text-center bg-gray-500 text-white px-2 vcenter flex-grow flex items-center' data-toggle="tooltip" data-placement="top" title="@date($event->start_repeat)">
                            <div class="font-bold w-full">
                                @day($event->start_repeat)<br class="hidden md:block"/>
                                @month($event->start_repeat)
                            </div>
                        </div>
                        {{-- Many days event --}}
                    @else
                        <div class='col text-center bg-gray-500 text-white px-1 mr-1 flex-grow flex-1' data-toggle="tooltip" data-placement="top" title="@date($event->start_repeat)">
                            <div class="table text-center h-full w-full">
                                <div class="font-bold align-middle table-cell">
                                    @day($event->start_repeat)<br class="hidden md:block"/>
                                    @month($event->start_repeat)
                                </div>
                            </div>
                        </div>
                        <div class='col bg-gray-500 text-white px-1 flex-grow flex-1' data-toggle="tooltip" data-placement="top" title="@date($event->end_repeat)">
                            <div class="table text-center h-full w-full">
                                <div class="font-bold align-middle table-cell">
                                    @day($event->end_repeat)<br class="hidden md:block"/>
                                    @month($event->end_repeat)
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <div class="md:col-span-3 px-6 py-4 whitespace-nowrap text-base text-gray-500">
                <a class="textLink" href="{{route('events.show', $event->slug)}}">{{$event->title}}</a>
            </div>
            <div class="md:col-span-3 flex items-center">
                {{-- Teachers --}}
                @if(count($event->teachers))
                    <svg class="flex-shrink-0 mr-1.5 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    <div class="text-sm md:px-4">
                        @foreach ($event->teachers as $key => $teacher)
                            <a class="textLink" href="{{route('teachers.show', $teacher->slug)}}">{{$teacher->name}}</a>@if(!$loop->last),@endif
                        @endforeach
                    </div>
                @endif
            </div>
            <div class="md:col-span-2 flex items-center">
                {{-- Category --}}
                <svg class="flex-shrink-0 mr-1.5 h-5 w-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M17.707 9.293a1 1 0 010 1.414l-7 7a1 1 0 01-1.414 0l-7-7A.997.997 0 012 10V5a3 3 0 013-3h5c.256 0 .512.098.707.293l7 7zM5 6a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path></svg>
                <div>{{$event->category->name}}</div>
            </div>
            <div class="md:col-span-3 flex items-center text-sm">
                {{-- Location --}}
                <svg class="flex-shrink-0 mr-1.5 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                <div>{{$event->venue->name}}  -  {{ $event->venue->address }}, {{ $event->venue->city }}, {{ $event->venue->country->name }} </div>
            </div>
        </div>
    @empty
        @include('partials.contextualFeedback', [
            'message' => 'No results found',
            'color' => 'warning',
            'extraClasses' => 'mb-4 mt-4',
        ])
    @endforelse
</div>