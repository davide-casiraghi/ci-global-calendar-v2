@extends('layouts.backend')

@section('title')
    @lang('teacher.teachers_management')
@endsection

@section('buttons')
    @include('partials.forms.button',[
        'title' => 'Add teacher',
        'url' => route('teachers.create'),
        'color' => 'indigo',
        'icon' => '',
        'size' => 1,
        'extraClasses' => 'mb-4',
        'kind' => 'primary',
        'target' => '_self',
    ])
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
        {{ $teachers->links() }}
    </div>


@endsection
