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
        {{
            $events->appends([
                'title' => $searchParameters['title'] ?? '',
                'event_category_id' => $searchParameters['event_category_id'] ?? '',
                'start_repeat' => $searchParameters['start_repeat'] ?? '',
                'end_repeat' => $searchParameters['end_repeat'] ?? '',
                'is_published' => $searchParameters['is_published'] ?? '',
            ])->links()
    }}
    </div>

@endsection
