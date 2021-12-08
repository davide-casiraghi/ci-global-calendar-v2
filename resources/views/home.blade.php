
@extends('layouts.app')

@section('jumbotron')
    {{--@include('partials.pages.home.video_embed')--}}
    {{--@include('partials.pages.home.jumboIntro')--}}
@endsection

@section('fb-tags')
    <x-social-meta
            :title="__('general.website_name')"
            :description="__('general.website_description')"
            :image="asset('images/static_pages/hp-intro-image.jpg')"
    />
    <meta property="fb:app_id" content="188241685231123" />
@endsection

@section('content')

    aaa

    <div class="relative flex-grow-0 flex-shrink-0 px-4 w-full max-w-full tracking-tight leading-6 text-center text-gray-900 box-border"
            style="flex-basis: 100%;">
        <h1 class="mx-0 mt-20 mb-4 text-4xl font-medium text-center text-white box-border" style="line-height: 1.2;">
            Contact Improvisation
        </h1>
        <h4 class="mt-0 mb-2 font-sans text-2xl font-semibold tracking-normal text-gray-500 uppercase box-border" style="line-height: 1.125;">
            <strong class="leading-7 uppercase box-border" style="font-weight: bolder;"
            >- Global Calendar -</strong
            >
        </h4>
        <p class="mt-0 mb-4 leading-6 text-white box-border">
            Find information about Contact Improvisation events worldwide (classes,
            jams, workshops, festivals and more)<br class="text-center box-border" />
        </p>
        <p class="mt-0 mb-4 leading-6 text-gray-900 box-border"></p>
        <p class="mt-12 mb-4 leading-6 text-white box-border">
            Use one or more search criteria
        </p>
    </div>

    <form class="mb-10">
        <div class="md:grid md:grid-cols-6 md:gap-4 max-w-4xl m-auto">
            <div class="md:col-span-2">
                <b>What</b>
                @include('partials.forms.select', [
                                'label' => "",
                                'name' => 'event_category_id',
                                'placeholder' => __('views.select_category'),
                                'records' => $eventCategories,
                                'selected' => old('event_category_id'),
                                'required' => TRUE,
                                'extraClasses' => '',
                            ])

                <div class="mt-4">
                    <b>Who</b>
                    @include('partials.forms.select', [
                                    'label' => "",
                                    'name' => 'teacher_id',
                                    'placeholder' => __('homepage-search.teacher_name'),
                                    'records' => $teachers,
                                    'selected' => old('teacher_id'),
                                    'required' => TRUE,
                                    'extraClasses' => '',
                                ])
                </div>
            </div>
            <div class="md:col-span-2 mt-5 md:mt-0">
                <b>Where</b>

                @livewire('continent-country-region')
            </div>
            <div class="md:col-span-2 mt-5 md:mt-0">
                <b>When</b>

                @include('partials.forms.inputFlatPickrDatePicker', [
                                'class' => 'flatpickr date future',
                                'label' => "",
                                'placeholder' => __('views.select_date'),
                                'name' => 'startDate',
                                'value' => old('startDate'),
                                'required' => true,
                                'disabled' => false,
                            ])

                <div class="mt-4">
                    @include('partials.forms.inputDatePicker',[
                                        'class' => 'flatpickr date future',
                                        'label' => "",
                                        'placeholder' => __('views.select_date'),
                                        'name' => 'endDate',
                                        'value' => old('endDate'),
                                        'required' => true,
                                        'disabled' => false,
                                    ])
                </div>
            </div>
        </div>

        {{-- Search / Reset buttons

        md:col-span-2 lg:col-span-1 flex items-end justify-end mt-4 md:mt-0 mb-2
        --}}
        <div class="max-w-4xl flex items-end justify-end m-auto mt-4">

            @include('partials.forms.button_submit',[
                     'title' => __('general.search'),
                     'color' => 'indigo',
                     'icon' => '',
                     'size' => 2,
                     'extraClasses' => 'mr-2',
                     'kind' => 'primary',
                 ])

            @include('partials.forms.button',[
                 'title' => 'Reset',
                 'url' => route('home'),
                 'color' => 'yellow',
                 'icon' => '',
                 'size' => 2,
                 'extraClasses' => '',
                 'kind' => 'white',
                 'target' => '_self',
             ])
        </div>
    </form>



    {{-- RESULTS --}}

    <table class="min-w-full divide-y divide-gray-200">
        <tbody>


        @foreach($events as $event)
            {{--@if ($loop->iteration % 2 == 0) bg-white @else bg-gray-50 @endif
                <tr class="bg-white">
            @else
                <tr class="bg-gray-50">
            @endif--}}
            <tr class="@if ($loop->iteration % 2 == 0) bg-white @else bg-gray-50 @endif ">
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        <a href="{{route('events.show', $event->id)}}">{{$event->title}}</a>
                    </td>
                </tr>
        @endforeach



        </tbody>
    </table>



    <div class="my-5">
        {{ $events->links() }}
    </div>


@endsection





