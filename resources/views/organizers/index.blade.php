@extends('layouts.backend')

@section('title')
    @lang('organizer.organizers_management')
@endsection

@section('buttons')
    @include('partials.forms.button',[
        'title' => 'Add organizer',
        'url' => route('organizers.create'),
        'color' => 'indigo',
        'icon' => '',
        'size' => 1,
        'extraClasses' => 'mb-4',
        'kind' => 'primary',
        'target' => '_self',
    ])
@endsection

@section('content')

    @include('partials.organizers.searchBar')

    {{-- Tailwind Component: https://tailwindui.com/components/application-ui/lists/stacked-lists--}}
    <div class="bg-white shadow overflow-hidden sm:rounded-md">
        <ul class="divide-y divide-gray-200">
            @foreach($organizers as $organizer)
                @include('partials.organizers.indexItem', [
                    'organizer' => $organizer
                ])
            @endforeach
        </ul>
    </div>

    <div class="my-5">
        {{ $organizers->links() }}
    </div>


@endsection
