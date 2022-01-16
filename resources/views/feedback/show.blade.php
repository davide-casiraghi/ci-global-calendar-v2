@extends('layouts.frontend')

@section('title') Send a feedback or Report a bug @endsection
@section('description') Send a mail to the CI Global Calendar administrator. @endsection

@section('content')

    <form class="m-auto max-w-lg my-10" method="POST" action="{{ route('feedback.sendMail') }}">
        @csrf
        <h2 class="text-2xl font-bold">@lang('views.contact_the_administrator')</h2>

        <div class="bg-yellow-100 rounded-lg py-5 px-6 my-8 text-base text-yellow-700 mb-3" role="alert">
            @lang('views.please_write_in_english')
        </div>

        <div class="col-span-6 mb-2">
            @include('partials.forms.input', [
                    'label' => __('general.name'),
                    'name' => 'name',
                    'placeholder' => '',
                    'value' => old('name'),
                    'required' => true,
                    'disabled' => false,
            ])
        </div>

        <div class="col-span-6 mb-2">
            @include('partials.forms.input', [
                    'label' => __('general.email_address'),
                    'name' => 'email',
                    'placeholder' => '',
                    'value' => old('email'),
                    'required' => true,
                    'disabled' => false,
            ])
        </div>

        <div class="col-span-6 mb-2">
            @include('partials.forms.textarea', [
                    'label' => __('general.message'),
                    'name' => 'message',
                    'placeholder' => '',
                    'value' =>  old('message'),
                    'required' => false,
                    'disabled' => false,
                    'style' => 'plain',
                    'extraDescription' => '',
                ])
        </div>

        <div class="flex justify-end mt-4">
            <a href="{{ url()->previous() }}">
                <button type="button" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    @lang('general.delete')
                </button>
            </a>
            <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                @lang('general.send')
            </button>
        </div>

    </form>
@endsection
