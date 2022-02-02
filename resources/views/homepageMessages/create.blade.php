@extends('layouts.backend')

@section('content')

    @include('partials.messages')

    <form class="space-y-6" method="POST" action="{{ route('homepageMessages.store') }}">
        <div class="bg-white shadow px-4 py-5 sm:rounded-lg sm:p-6">
          <div class="md:grid md:grid-cols-3 md:gap-6">
            <div class="md:col-span-1">
              <h3 class="text-lg font-medium leading-6 text-gray-900">Create homepage message</h3>
                {{--
                  <p class="mt-1 text-sm text-gray-500">
                    Edit the homepage message data
                </p>
              --}}

            </div>
            <div class="mt-5 md:mt-0 md:col-span-2">
                @csrf

                <div class="grid grid-cols-6 gap-6">
                    <div class="col-span-6">
                        @include('partials.forms.input', [
                                'label' => __('general.title'),
                                'name' => 'title',
                                'placeholder' => '',
                                'value' => old('title'),
                                'required' => true,
                                'disabled' => false,
                        ])
                    </div>

                    <div class="col-span-6">
                        @include('partials.forms.textarea', [
                                'label' => __('general.body'),
                                'name' => 'body',
                                'placeholder' => '',
                                'value' => old('body'),
                                'required' => false,
                                'disabled' => false,
                                'style' => 'plain',
                                'extraDescription' => '',
                            ])
                    </div>

                    <div class="col-span-6">
                        @include('partials.forms.select', [
                                'label' => 'Color',
                                'name' => 'color',
                                'placeholder' => __('general.select_one'),
                                'records' => $colors,
                                'selected' =>  old('color'),
                                'required' => true,
                                'extraClasses' => 'select2',
                            ])
                    </div>

                    <div class="col-span-6">
                        @include('partials.forms.checkbox', [
                            'label' => "Show title",
                            'id'  => 'show_title',
                            'name' => 'show_title',
                            'size' => 'small',
                            'required' => false,
                            'checked' => false,
                            'description' => 'Display the title above the message.',
                        ])
                    </div>

                    <div class="col-span-6">
                        @include('partials.forms.checkbox', [
                            'label' => __('views.published'),
                            'id'  => 'status',
                            'name' => 'status',
                            'size' => 'small',
                            'required' => false,
                            'checked' => false,
                            'description' => 'Since one message at time can be published, publishing this message will unpublish all the others.',
                        ])
                    </div>

                </div>
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
