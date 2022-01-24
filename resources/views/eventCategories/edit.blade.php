@extends('layouts.backend')

@section('buttons')
    @livewire('delete-model', [
    'model' => $eventCategory,
    'modelName' => 'event category',
    'redirectRoute' => 'eventCategories.index'
    ])
@endsection

@section('content')

    @include('partials.messages')

    <form class="space-y-6" method="POST" action="{{ route('eventCategories.update',$eventCategory->id) }}">
        <div class="bg-white shadow px-4 py-5 sm:rounded-lg sm:p-6">
          <div class="md:grid md:grid-cols-3 md:gap-6">
            <div class="md:col-span-1">
              <h3 class="text-lg font-medium leading-6 text-gray-900">Edit event category</h3>
                {{--
                  <p class="mt-1 text-sm text-gray-500">
                    Edit the event category data
                </p>
              --}}

            </div>
            <div class="mt-5 md:mt-0 md:col-span-2">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-6 gap-6">
                    <div class="col-span-6">
                        @include('partials.forms.input', [
                                'label' => __('ui.eventCategories.name'),
                                'name' => 'name',
                                'placeholder' => 'Event category name',
                                'value' => old('name', $eventCategory->name),
                                'required' => true,
                                'disabled' => false,
                        ])
                    </div>

                    <div class="col-span-6">
                        @include('partials.forms.textarea', [
                                'label' => __('ui.eventCategories.description'),
                                'name' => 'description',
                                'placeholder' => '',
                                'value' => old('description', $eventCategory->description),
                                'required' => false,
                                'disabled' => false,
                                'style' => 'plain',
                                'extraDescription' => 'Anything to show jumbo style before the content',
                            ])
                    </div>

                </div>
            </div>
          </div>
        </div>

        <div class="flex items-stretch justify-between">
            <div></div>

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
