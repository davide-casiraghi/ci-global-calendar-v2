@extends('layouts.backend')

@section('title')
    @lang('views.post_management')
@endsection

@section('buttons')
    @include('partials.forms.button',[
        'title' => 'Add post',
        'url' => route('posts.create'),
        'color' => 'indigo',
        'icon' => '',
        'size' => 1,
        'extraClasses' => 'mb-4',
        'kind' => 'primary',
        'target' => '_self',
    ])

    @include('partials.forms.button',[
         'title' => 'Categories',
         'url' => route('postCategories.index'),
         'color' => 'yellow',
         'icon' => '',
         'size' => 1,
         'extraClasses' => 'mb-4',
         'kind' => 'white',
         'target' => '_self',
     ])

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
