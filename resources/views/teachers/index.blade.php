@extends((( auth()->user()->isAdmin()) ? 'layouts.backend' : 'layouts.frontend' ))

@section('title')
    @lang('teacher.teachers_management')
@endsection

@section('buttons')
    <a href="{{ route('teachers.create') }}" target="_self" class="blueButton smallButton">
        @lang('views.add_new_teacher')
    </a>
@endsection

@section('content')

    @include('partials.teachers.searchBar')

    {{-- Tailwind Component: https://tailwindui.com/components/application-ui/lists/stacked-lists--}}
    <div class="bg-white shadow overflow-hidden sm:rounded-md">
        <ul class="divide-y divide-gray-200">
            @foreach($teachers as $teacher)
                @include('partials.teachers.indexItem', [
                    'teacher' => $teacher
                ])
            @endforeach
        </ul>
    </div>

    <div class="my-5">
        {{
        $teachers->appends([
                'name' => $searchParameters['name'] ?? '',
                'surname' => $searchParameters['surname'] ?? '',
                'countryId' => $searchParameters['countryId'] ?? '',
            ])->links()
        }}
    </div>
@endsection
