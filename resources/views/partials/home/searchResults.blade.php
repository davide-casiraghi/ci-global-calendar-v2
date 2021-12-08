{{-- RESULTS of the homepage event search form --}}

<table class="divide-y divide-gray-200 table-fixed box-content mx-10">
    <tbody>
    @foreach($events as $event)
        <tr class="@if ($loop->iteration % 2 == 0) bg-white @else bg-gray-50 @endif ">
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 w-3/12">
                <a class="textLink" href="{{route('events.show', $event->id)}}">{{$event->title}}</a>
            </td>
            <td class="w-3/12">
                {{-- Teachers --}}
                @if(count($event->teachers))
                    <div class="flex mt-2">
                        <svg class="flex-shrink-0 mr-1.5 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        @foreach ($event->teachers as $key => $teacher)
                            <a class="textLink" href="{{route('teachers.show', $teacher->slug)}}">{{$teacher->name}}</a>@if(!$loop->last),@endif
                        @endforeach
                    </div>
                @endif
            </td>
            <td class="w-3/12">
                {{-- Category --}}
                <div class="flex">
                    <svg class="flex-shrink-0 mr-1.5 h-5 w-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M17.707 9.293a1 1 0 010 1.414l-7 7a1 1 0 01-1.414 0l-7-7A.997.997 0 012 10V5a3 3 0 013-3h5c.256 0 .512.098.707.293l7 7zM5 6a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path></svg>
                    <div>{{$event->category->name}}</div>
                </div>
            </td>
            <td class="w-3/12">
                {{-- Location --}}
                <div class="flex text-sm">
                    <svg class="flex-shrink-0 mr-1.5 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    <div>{{$event->venue->name}}  -  {{ $event->venue->address }}, {{ $event->venue->city }}, {{ $event->venue->country->name }} </div>
                </div>

            </td>
        </tr>
    @endforeach
    </tbody>
</table>

{{-- Paginator --}}
@if(count($events)>0)
    <div class="my-5">
        {{ $events->links() }}
    </div>
@endif