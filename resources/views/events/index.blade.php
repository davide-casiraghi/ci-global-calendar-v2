@extends((( auth()->user()->isAdmin()) ? 'layouts.backend' : 'layouts.frontend' ))

@section('title')
    @lang('event.events_management')
@endsection

@section('buttons')

    <a href="{{ route('events.create') }}" target="_self" class="blueButton smallButton mr-2">
        @lang('event.add_new_event')
    </a>

    <a href="{{ route('eventCategories.index') }}" target="_self" class="grayButton smallButton mr-2">
        @lang('menu.event_categories')
    </a>

    {{--
    <a href="{{ route('teachers.index') }}" target="_self" class="orangeButton smallButton mr-2">
        @lang('general.teachers')
    </a>

    <a href="{{ route('organizers.index') }}" target="_self" class="orangeButton smallButton mr-2">
        @lang('general.organizers')
    </a>

    <a href="{{ route('venues.index') }}" target="_self" class="orangeButton smallButton">
        @lang('general.venues')
    </a>
    --}}
@endsection

@section('content')

    @include('partials.events.searchBar')

    {{-- Tailwind Component: https://tailwindui.com/components/application-ui/lists/stacked-lists--}}
    <div class="bg-white shadow overflow-hidden sm:rounded-md">
        <ul class="divide-y divide-gray-200">
            @foreach($events as $event)
                @include('partials.events.indexItem', [
                    'event' => $event
                ])
            @endforeach
        </ul>
    </div>

    <div class="my-5">
        {{ $events->links() }}
    </div>


@endsection
