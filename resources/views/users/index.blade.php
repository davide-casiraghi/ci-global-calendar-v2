@extends('layouts.backend')

@section('title')
    @lang('user.users_management')
@endsection

@section('buttons')
    <a href="{{ route('users.create') }}" target="_self" class="blueButton smallButton">
        @lang('views.add_new_user')
    </a>
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
