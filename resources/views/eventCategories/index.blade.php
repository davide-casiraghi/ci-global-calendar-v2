@extends('layouts.backend')

@section('content')

    @include('partials.forms.button',[
        'title' => 'Add category',
        'url' => route('eventCategories.create'),
        'color' => 'indigo',
        'icon' => '',
        'size' => 1,
        'extraClasses' => 'mb-4',
        'kind' => 'primary',
        'target' => '_self',
    ])

    {{-- Tailwind Component: https://tailwindui.com/components/application-ui/lists/stacked-lists--}}
    <div class="bg-white shadow overflow-hidden sm:rounded-md">
        <ul class="divide-y divide-gray-200">
            @foreach($eventCategories as $eventCategory)
                @include('partials.eventCategory.indexItem', [
                    'eventCategory' => $eventCategory
                ])
            @endforeach
        </ul>
    </div>

   {{--<div class="my-5">
        {{ $eventsCategories->links() }}
    </div>--}}


@endsection
