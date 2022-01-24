@extends('layouts.backend')

@section('title')
    @lang('views.category_management')
@endsection

@section('buttons')
    <a href="{{ route('postCategories.create') }}" target="_self" class="blueButton smallButton">
        @lang('views.add_new_category')
    </a>
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
