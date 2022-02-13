@extends('layouts.frontend')

@section('title') Send a feedback or Report a bug @endsection
@section('description') Send a mail to the CI Global Calendar administrator. @endsection

@section('content')

    <form class="m-auto max-w-lg my-10" method="POST" action="{{ route('feedback.sendMail') }}">
        @csrf
        <h2 class="text-2xl font-bold">@lang('views.contact_the_administrator')</h2>

        @include('partials.contextualFeedback', [
            'message' => __('views.please_write_in_english'),
            'color' => 'warning',
            'extraClasses' => 'mb-4 mt-4 px-10',
        ])

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
                <button type="button" class="grayButton mediumButton mr-2">
                    @lang('general.close')
                </button>
            </a>
            <button type="submit" class="blueButton mediumButton">
                @lang('general.send')
            </button>
        </div>

    </form>
@endsection
