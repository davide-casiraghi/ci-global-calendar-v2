@extends((( Session::get('showBackend')) ? 'layouts.backend' : 'layouts.frontend' ))

@section('title')
    @lang('organizer.organizers_management')
@endsection

@section('buttons')
    <a href="{{ route('organizers.create') }}" target="_self" class="blueButton smallButton">
        @lang('views.add_new_organizer')
    </a>
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
        {{
            $organizers->appends([
                'name' => $searchParameters['name'] ?? '',
                'surname' => $searchParameters['surname'] ?? '',
                'email' => $searchParameters['email'] ?? '',
            ])->links()
         }}
    </div>
@endsection
