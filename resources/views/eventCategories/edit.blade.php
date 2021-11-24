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

        <div class="grid grid-cols-6 gap-6">


            <div class="col-span-6">
                <div class="flex justify-end mt-4">
                    <a href="{{ url()->previous() }}">
                        <button type="button" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Cancel
                        </button>
                    </a>
                    <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Save
                    </button>
                </div>
            </div>
        </div>

    </form>

@endsection
