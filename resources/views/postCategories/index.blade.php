@extends('layouts.backend')

@section('title')
    @lang('views.category_management')
@endsection

@section('buttons')
    @include('partials.forms.button',[
        'title' => 'Add category',
        'url' => route('postCategories.create'),
        'color' => 'indigo',
        'icon' => '',
        'size' => 1,
        'extraClasses' => 'mb-4',
        'kind' => 'primary',
        'target' => '_self',
    ])
@endsection

@section('content')

    {{-- Tailwind Component: https://tailwindui.com/components/application-ui/lists/stacked-lists--}}
    <div class="bg-white shadow overflow-hidden sm:rounded-md">
        <ul class="divide-y divide-gray-200">
            @foreach($postCategories as $postCategory)
                @include('partials.postCategory.indexItem', [
                    'postCategory' => $postCategory
                ])
            @endforeach
        </ul>
    </div>

   {{--<div class="my-5">
        {{ $postsCategories->links() }}
    </div>--}}


@endsection
