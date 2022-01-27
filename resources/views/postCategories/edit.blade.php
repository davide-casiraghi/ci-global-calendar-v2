@extends('layouts.backend')

@section('title')
    @lang('views.edit_category')
@endsection

@section('buttons')
    <form action="{{ route('posts.destroy',$postCategory) }}" method="POST">
        @csrf
        @method('DELETE')
        <button type="submit" class="inline-flex items-center border font-medium focus:outline-none focus:ring-2 focus:ring-offset-2 border-transparent text-red-700 bg-red-100 hover:bg-red-200 px-2.5 py-1.5 text-xs rounded shadow-sm mt-4">
            <svg class="flex-shrink-0 mr-1.5 h-5 w-5 inline-block" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
            <div class="inline-block">Delete</div>
        </button>
    </form>
@endsection


@section('content')
    @include('partials.messages')

    <form class="space-y-6" method="POST" action="{{ route('postCategories.update',$postCategory) }}">
        <div class="bg-white shadow px-4 py-5 sm:rounded-lg sm:p-6">
          <div class="md:grid md:grid-cols-3 md:gap-6">
            <div class="md:col-span-1">
              <h3 class="text-lg font-medium leading-6 text-gray-900">Edit post category</h3>
                {{--
                  <p class="mt-1 text-sm text-gray-500">
                    Edit the post category data
                </p>
              --}}

            </div>
            <div class="mt-5 md:mt-0 md:col-span-2">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-6 gap-6">
                    <div class="col-span-6">
                        @include('partials.forms.input', [
                                'label' => __('general.name'),
                                'name' => 'name',
                                'placeholder' => 'Post category name',
                                'value' => old('name', $postCategory->name),
                                'required' => true,
                                'disabled' => false,
                        ])
                    </div>

                    <div class="col-span-6">
                        @include('partials.forms.textarea', [
                                'label' => __('general.description'),
                                'name' => 'description',
                                'placeholder' => '',
                                'value' => old('description', $postCategory->description),
                                'required' => false,
                                'disabled' => false,
                                'style' => 'plain',
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
