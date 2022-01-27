@extends('layouts.backend')

@section('title')
    @lang('views.edit_post')
@endsection

@section('buttons')
    @livewire('delete-model', [
        'model' => $post,
        'modelName' => 'post',
        'redirectRoute' => 'posts.index'
    ])
@endsection

@section('content')

    @include('partials.messages')

    <form class="space-y-6" method="POST" action="{{ route('posts.update',$post) }}" enctype="multipart/form-data" x-data="{translationActive: '{{Config::get('app.fallback_locale')}}'}">
        @csrf
        @method('PUT')

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
                                    'value' => old('title', $post->title),
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
                                'selected' => $post->category_id,
                                'required' => true,
                                'extraClasses' => '',
                            ])
                        </div>

                        <div class="col-span-6">
                            @include('partials.forms.textarea', [
                                    'label' => __('views.before_post_contents'),
                                    'name' => 'before_content',
                                    'placeholder' => '',
                                    'value' => old('before_content', $post->before_content),
                                    'required' => false,
                                    'disabled' => false,
                                    'style' => 'plain',
                                    'extraDescription' => 'Anything to show jumbo style before the content',
                                ])
                        </div>

                        <div class="col-span-6">
                            @include('partials.forms.textarea', [
                                    'label' => __('views.intro_text'),
                                    'name' => 'intro_text',
                                    'placeholder' => '',
                                    'value' => old('intro_text', $post->intro_text),
                                    'required' => false,
                                    'disabled' => false,
                                    'style' => 'plain',
                                    'extraDescription' => '',
                                ])
                        </div>

                        <div class="col-span-6">
                           @include('partials.forms.textarea', [
                                   'label' => __('views.body'),
                                   'name' => 'body',
                                   'placeholder' => '',
                                   'value' => old('body', $post->body),
                                   'required' => false,
                                   'disabled' => false,
                                   'style' => 'tinymce',
                                   //'extraDescription' => 'Anything to show jumbo style after the content',
                               ])


                            {{-- <x-trix name="body">{{$post->body}}</x-trix>--}}
                        </div>

                        <div class="col-span-6">
                            @include('partials.forms.textarea', [
                                    'label' => __('views.after_post_contents'),
                                    'name' => 'after_content',
                                    'placeholder' => '',
                                    'value' => old('after_content', $post->after_content),
                                    'required' => false,
                                    'disabled' => false,
                                    'style' => 'plain',
                                    'extraDescription' => 'Anything to show jumbo style after the content',
                                ])
                        </div>

                        <div class="col-span-6">
                            @include('partials.forms.uploadImage', [
                                      'label' => __('views.intro_image'),
                                      'name' => 'introimage',
                                      //'value' => $post->introimage,
                                      'required' => false,
                                      'collection' => 'introimage',
                                      'entity' => $post,
                                  ])
                        </div>

                        <div class="col-span-6">
                            @include('partials.forms.uploadImageMultiple', [
                                      'label' => __('views.images_for_galleries'),
                                      'name' => 'images',
                                      'required' => false,
                                      'collection' => 'images',
                                      'model' => $post,
                                  ])
                        </div>

                        <div class="col-span-6">
                            @php
                                $checked = ($post->isPublished()) ? "checked" : "";
                            @endphp
                            @include('partials.forms.checkbox', [
                                'label' => __('views.published'),
                                'id'  => 'status',
                                'name' => 'status',
                                'size' => 'small',
                                'required' => false,
                                'checked' => $checked,
                            ])
                        </div>

                        <div class="col-span-6">
                            @include('partials.forms.inputFlatPickrDatePicker',[
                                    'class' => 'flatpickr date all',
                                    'label' => __('general.created_on'),
                                    'placeholder' => __('general.select_date'),
                                    'name' => 'created_at',
                                    'value' => old('created_at', $post->created_at->format('d/m/Y')),
                                    'required' => true,
                                    'disabled' => false,
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
                                            'value' => old('title_'.$countryCode, $post->getTranslation('title', $countryCode)),
                                            'required' => true,
                                            'disabled' => false,
                                    ])
                                </div>

                                <div class="col-span-6">
                                    @include('partials.forms.textarea', [
                                            'label' => __('views.intro_text'),
                                            'name' => 'intro_text_'.$countryCode,
                                            'placeholder' => '',
                                            'value' => old('intro_text_'.$countryCode, $post->getTranslation('intro_text', $countryCode)),
                                            'required' => false,
                                            'disabled' => false,
                                            'style' => 'plain',
                                            'extraDescription' => '',
                                        ])
                                </div>

                                <div class="col-span-6">

                                    @include('partials.forms.textarea', [
                                   'label' => __('views.body'),
                                   'name' => 'body_'.$countryCode,
                                   'placeholder' => '',
                                   'value' => old('body_'.$countryCode, $post->getTranslation('body', $countryCode)),
                                   'required' => false,
                                   'disabled' => false,
                                   'style' => 'tinymce',
                                   //'extraDescription' => 'Anything to show jumbo style after the content',
                               ])

                                    {{--<x-trix name="body_{{$countryCode}}">{{$post->getTranslation('body', $countryCode))}}</x-trix>--}}
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach

            </div>

          </div>
        </div>

        {{-- Utility --}}
        <div class="bg-white shadow px-4 py-5 sm:rounded-lg sm:p-6">
            <div class="md:grid md:grid-cols-3 md:gap-6">
                <div class="md:col-span-1">
                    <h3 class="text-lg font-medium leading-6 text-gray-900">Utility</h3>
                    {{--
                      <p class="mt-1 text-sm text-gray-500">
                        Edit the post data
                    </p>
                  --}}

                </div>
                <div class="mt-5 md:mt-0 md:col-span-2">
                    <div class="grid grid-cols-6 gap-6">
                        <div class="col-span-6 sm:col-span-4">
                            @include('partials.forms.input', [
                                    'label' => __('views.link_to_this_post'),
                                    'name' => 'post_link',
                                    'placeholder' => '',
                                    'value' => env('APP_URL').'/posts/'.$post->slug,
                                    'required' => false,
                                    'disabled' => true,
                                ])
                        </div>

                        <div class="col-span-6 sm:col-span-2">
                            @include('partials.forms.input', [
                                    'label' => __('views.post_id'),
                                    'name' => 'post_id',
                                    'placeholder' => '',
                                    'value' => $post->id,
                                    'required' => false,
                                    'disabled' => true,
                                ])
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="flex items-stretch justify-between">
            <a href="{{ route('posts.show',$post->slug) }}" class="blueButtonInverse mediumButton">
                <svg class="flex-shrink-0 mr-1.5 h-5 w-5 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                @lang('general.view')
            </a>

            <div class="flex justify-end">
                <a href="{{ url()->previous() }}" class="grayButton mediumButton mr-2">
                    @lang('general.back')
                </a>
                <button type="submit" class="blueButton mediumButton">
                    @lang('general.submit')
                </button>
            </div>
        </div>
    </form>

@endsection
