{{-- RESULTS of the homepage event search form --}}

<table class="min-w-full divide-y divide-gray-200">
    <tbody>
    @foreach($events as $event)
        <tr class="@if ($loop->iteration % 2 == 0) bg-white @else bg-gray-50 @endif ">
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                <a href="{{route('events.show', $event->id)}}">{{$event->title}}</a>
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