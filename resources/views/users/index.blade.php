@extends('layouts.backend')

@section('title')
    @lang('user.users_management')
@endsection

@section('buttons')
    @include('partials.forms.button',[
        'title' => 'Add user',
        'url' => route('users.create'),
        'color' => 'indigo',
        'icon' => '',
        'size' => 1,
        'extraClasses' => 'mb-4',
        'kind' => 'primary',
        'target' => '_self',
    ])
@endsection

@section('content')

    @include('partials.users.searchBar')

    {{-- Tailwind Component: https://tailwindui.com/components/application-ui/lists/stacked-lists--}}
    <div class="bg-white shadow overflow-hidden sm:rounded-md">
        <ul class="divide-y divide-gray-200">
            @foreach($users as $user)
                @include('partials.users.indexItem')
            @endforeach
        </ul>
    </div>

    <div class="my-5">
        {{ $users->links() }}
    </div>


@endsection
