@extends('layouts.backend')

@section('title')
    @lang('views.background_image_management')
@endsection

@section('buttons')
    @include('partials.forms.button',[
        'title' => 'Add background image',
        'url' => route('backgroundImages.create'),
        'color' => 'indigo',
        'icon' => '',
        'size' => 1,
        'extraClasses' => 'mb-4',
        'kind' => 'primary',
        'target' => '_self',
    ])
@endsection

@section('content')

    @include('partials.backgroundImages.searchBar')

    {{-- Tailwind Component: https://tailwindui.com/components/application-ui/lists/stacked-lists--}}
    <div class="bg-white shadow overflow-hidden sm:rounded-md">
        <ul class="divide-y divide-gray-200">
            @foreach($backgroundImages as $backgroundImage)
                @include('partials.backgroundImages.indexItem', [
                    'backgroundImage' => $backgroundImage
                ])
            @endforeach
        </ul>
    </div>

    <div class="my-5">
        {{ $backgroundImages->links() }}
    </div>


@endsection
