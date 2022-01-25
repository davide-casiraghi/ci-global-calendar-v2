@extends('layouts.app')

@section('title')
    @lang('menu.create_account')
@endsection

@section('content')

    <div class="max-w-prose mx-auto my-8 px-6">

        <h3 class="text-2xl font-medium leading-6 text-gray-900 mb-10">@lang('menu.create_account')</h3>

        @include('partials.messages')

        {{-- The form submit is then processed by app/Actions/Fortify/CreateNewUser.php --}}
        <form method="POST" action="{{ route('register') }}" class="mt-4">
        @csrf

            <div class="md:grid md:grid-cols-6 md:gap-x-8 md:gap-y-4">
                <div class="md:col-span-3">
                    @include('partials.forms.input', [
                        'label' => __('general.name'),
                        'name' => 'name',
                        'placeholder' => '',
                        'value' => old('name'),
                        'required' => true,
                        'disabled' => false,
                    ])
                </div>
                <div class="md:col-span-3 mt-2 md:mt-0">
                    @include('partials.forms.input', [
                        'label' => __('general.surname'),
                        'name' => 'surname',
                        'placeholder' => '',
                        'value' => old('surname'),
                        'required' => true,
                        'disabled' => false,
                    ])
                </div>

                <div class="md:col-span-3">
                    @include('partials.forms.input', [
                        'label' => __('general.your_email'),
                        'name' => 'email',
                        'placeholder' => '',
                        'value' => old('email'),
                        'required' => true,
                        'disabled' => false,
                    ])
                </div>

                <div class="md:col-span-3 mt-2 md:mt-0">
                    @include('partials.forms.select', [
                            'label' => __('general.country'),
                            'name' => 'country_id',
                            'placeholder' => __('general.select_one'),
                            'records' => $countries,
                            'required' => true,
                            'extraClasses' => 'select2',
                        ])
                </div>

                <div class="md:col-span-3 mt-2 md:mt-0">
                    @include('partials.forms.password', [
                        'label' => __('general.password'),
                        'name' => 'password',
                        'placeholder' => '',
                        'value' => '',
                        'required' => true,
                        'disabled' => false,
                    ])
                </div>
                <div class="md:col-span-3 mt-2 md:mt-0">
                    @include('partials.forms.password', [
                        'label' => __('general.confirm_password'),
                        'name' => 'password_confirmation',
                        'placeholder' => '',
                        'value' => '',
                        'required' => true,
                        'disabled' => false,
                    ])
                </div>

                <div class="md:col-span-6 mt-2 md:mt-0">
                    @include('partials.forms.textarea', [
                        'label' => __('general.description'),
                        'name' => 'description',
                        'placeholder' => __('general.to_be_approved'),
                        'value' =>  '',
                        'required' => true,
                        'disabled' => false,
                        'style' => 'plain',
                        'extraDescription' => '',
                        'extraClasses' => 'h-48',
                    ])
                </div>

                <div class="md:col-span-6 mt-2 md:mt-0">
                    @include('partials.forms.checkbox', [
                        'label' => __('general.accept_terms_of_use'),
                        'id'  => 'accept_terms',
                        'name' => 'accept_terms',
                        'size' => 'small',
                        'required' => false,
                        'checked' => false,
                    ])
                </div>

                <div class="md:col-span-6 mt-2 md:mt-0">
                    <a class="underline" href="/posts/terms-of-use" target="_blank">
                        @lang('menu.terms_of_use') &gt;
                    </a>
                </div>

                <div class="md:col-span-6 mt-2 md:mt-0">
                    <div role="alert" class="relative py-3 px-5 my-4 tracking-tight leading-6 text-left text-yellow-800 bg-yellow-100 rounded border border-yellow-200 border-solid box-border">
                        @lang('general.admin_account_approval')
                    </div>
                </div>

            </div>

            <div class="flex justify-end">
                <a href="{{ route('home') }}" class="grayButton mediumButton mr-2">
                    @lang('general.back')
                </a>
                <button type="submit" class="blueButton mediumButton">
                    @lang('general.register')
                </button>
            </div>
        </form>
    </div>

@endsection
