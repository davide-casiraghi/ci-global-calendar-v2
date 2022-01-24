@extends('layouts.backend')

@section('title')
    @lang('views.post_management')
@endsection

@section('buttons')

    <a href="{{ route('posts.create') }}" target="_self" class="blueButton smallButton mr-2">
        @lang('views.add_new_post')
    </a>

    <a href="{{ route('postCategories.index') }}" target="_self" class="grayButton smallButton">
        @lang('menu.posts_categories')
    </a>

@endsection

@section('content')

    @include('partials.messages')

    @include('partials.posts.searchBar')

    {{-- Tailwind Component: https://tailwindui.com/components/application-ui/lists/stacked-lists--}}
    <div class="bg-white shadow overflow-hidden sm:rounded-md">
        <ul class="divide-y divide-gray-200">
            @foreach($posts as $post)
                @include('partials.posts.indexItem', [
                    'post' => $post
                ])
            @endforeach
        </ul>
    </div>

    <div class="my-5">
        {{ $posts->links() }}
    </div>


@endsection
