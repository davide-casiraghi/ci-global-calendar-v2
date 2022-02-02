@extends('layouts.backend')

@section('title')
    @lang('views.create_new_post')
@endsection

@section('content')

    @include('partials.messages')

    <form class="space-y-6" method="POST" action="{{ route('posts.store') }}" enctype="multipart/form-data" x-data="{translationActive: '{{Config::get('app.fallback_locale')}}'}">
        @csrf

        {{-- Post contents --}}
        <div class="bg-white shadow px-4 py-5 sm:rounded-lg sm:p-6">
          <div class="md:grid md:grid-cols-3 md:gap-6">
            <div class="md:col-span-1">
              <h3 class="text-lg font-medium leading-6 text-gray-900">Post contents</h3>
                {{--
                  <p class="mt-1 text-sm text-gray-500">
                    Edit the post data
                </p>
              --}}

                {{-- Translations tabs - Buttons --}}
                <div class="mt-4">
                    @include('partials.forms.languageTabs',[
                        'countriesAvailableForTranslations' => $countriesAvailableForTranslations
                    ])
                </div>

            </div>
            <div class="mt-5 md:mt-0 md:col-span-2">

                {{-- Translations tabs - Default Contents --}}
                <div class="translation en" x-show.transition.in="translationActive === '{{Config::get('app.fallback_locale')}}'">
                    <div class="grid grid-cols-6 gap-6">
                        <div class="col-span-6">
                            @include('partials.forms.input', [
                                    'label' => __('views.title'),
                                    'name' => 'title',
                                    'placeholder' => 'Post title',
                                    'value' => old('title'),
                                    'required' => true,
                                    'disabled' => false,
                            ])
                        </div>

                        <div class="col-span-6">
                            @include('partials.forms.select', [
                                'label' => __('views.category'),
                                'name' => 'category_id',
                                'placeholder' => __('views.select_category'),
                                'records' => $categories,
                                'selected' => old('category_id'),
                                'required' => true,
                                'extraClasses' => '',
                            ])
                        </div>

                        <div class="col-span-6">
                            @include('partials.forms.textarea', [
                                    'label' => __('views.before_post_contents'),
                                    'name' => 'before_content',
                                    'placeholder' => '',
                                    'value' =>  old('before_content'),
                                    'required' => false,
                                    'disabled' => false,
                                    'style' => 'plain',
                                    'extraDescription' => 'Anything to show jumbo style before the content',
                                ])
                        </div>

                        <div class="col-span-6">
                            @include('partials.forms.textarea', [
                                    'label' => __('general.intro_text'),
                                    'name' => 'intro_text',
                                    'placeholder' => '',
                                    'value' => old('intro_text'),
                                    'required' => false,
                                    'disabled' => false,
                                    'style' => 'plain',
                                    'extraDescription' => '',
                                ])
                        </div>

                        <div class="col-span-6">
                            @include('partials.forms.textarea', [
                                   'label' => __('general.text'),
                                   'name' => 'body',
                                   'placeholder' => '',
                                   'value' => old('body'),
                                   'required' => false,
                                   'disabled' => false,
                                   'style' => 'tinymce',
                                   //'extraDescription' => 'Anything to show jumbo style after the content',
                               ])

                            {{--<x-trix name="body"></x-trix>--}}
                        </div>

                        <div class="col-span-6">
                            @include('partials.forms.textarea', [
                                    'label' => __('views.after_post_contents'),
                                    'name' => 'after_content',
                                    'placeholder' => '',
                                    'value' => old('after_content'),
                                    'required' => false,
                                    'disabled' => false,
                                    'style' => 'plain',
                                    //'extraDescription' => 'Anything to show jumbo style after the content',
                                ])
                        </div>

                        <div class="col-span-6">
                            @include('partials.forms.uploadImage', [
                                      'label' => __('views.intro_image'),
                                      'name' => 'introimage',
                                      'value' => '',
                                      'required' => false,
                                      'collection' => 'introimage',
                                  ])
                        </div>

                    </div>
                </div>

                {{-- Translations tabs - Contents translated other languages --}}
                @foreach ($countriesAvailableForTranslations as $countryCode => $countryAvTrans)
                    @if($countryCode != Config::get('app.fallback_locale'))
                        <div class="translation {{$countryCode}}" x-show.transition.in="translationActive === '{{$countryCode}}'">
                            <div class="grid grid-cols-6 gap-6">

                                <div class="col-span-6">
                                    @include('partials.forms.input', [
                                            'label' => __('views.title'),
                                            'name' => 'title_'.$countryCode,
                                            'placeholder' => 'Post title',
                                            'value' => old('title_'.$countryCode),
                                            'required' => true,
                                            'disabled' => false,
                                    ])
                                </div>

                                <div class="col-span-6">
                                    @include('partials.forms.textarea', [
                                            'label' => __('views.intro_text'),
                                            'name' => 'intro_text_'.$countryCode,
                                            'placeholder' => '',
                                            'value' => old('intro_text_'.$countryCode),
                                            'required' => false,
                                            'disabled' => false,
                                            'style' => 'plain',
                                            'extraDescription' => '',
                                    ])
                                </div>

                                <div class="col-span-6">
                                    @include('partials.forms.textarea', [
                                           'label' => __('views.text'),
                                           'name' => 'body_'.$countryCode,
                                           'placeholder' => '',
                                           'value' => old('body_'.$countryCode), //, $post->body
                                           'required' => false,
                                           'disabled' => false,
                                           'style' => 'tinymce',
                                           //'extraDescription' => 'Anything to show jumbo style after the content',
                                       ])

                                    {{--<x-trix name="body_{{$countryCode}}"></x-trix>--}}
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
          </div>
        </div>

        <div class="flex justify-end">
            <a href="{{ url()->previous() }}" class="grayButton mediumButton mr-2">
                @lang('general.back')
            </a>
            <button type="submit" class="blueButton mediumButton">
                @lang('general.submit')
            </button>
        </div>
    </form>

@endsection
