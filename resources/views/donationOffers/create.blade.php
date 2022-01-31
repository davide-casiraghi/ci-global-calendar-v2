@extends('layouts.backend')

@section('title')
    @lang('donations.donation_form_title')
@endsection

@section('content')

    @include('partials.messages')

    <form class="space-y-6" method="POST" action="{{ route('donationOffers.store') }}" enctype="multipart/form-data">
        <input name="user_id" type="hidden" value="{{Auth::id()}}">

        <div class="bg-white shadow px-4 py-5 sm:rounded-lg sm:p-6">
            <div class="md:grid md:grid-cols-3 md:gap-6">
                <div class="md:col-span-1">
                    <h3 class="text-lg font-medium leading-6 text-gray-900">@lang('donations.donation_form_title')</h3>
                    <p class="mt-1 text-sm text-gray-500">
                        @lang('donations.your_contact_details_desc')
                    </p>
                </div>
                <div class="mt-5 md:mt-0 md:col-span-2">
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

                        <div class="md:col-span-3 mt-2 md:mt-0">
                            @include('partials.forms.input', [
                                    'label' => __('general.email_address'),
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
                                'selected' =>  old('country_id'),
                                'required' => true,
                                'extraClasses' => 'select2',
                            ])
                        </div>

                        <div class="md:col-span-3 mt-2 md:mt-0">
                            @include('partials.forms.input', [
                                    'label' => __('donations.contact_through_skype_or_another_voip'),
                                    'name' => 'contact_trough_voip',
                                    'placeholder' => '',
                                    'value' => old('contact_trough_voip'),
                                    'required' => false,
                                    'disabled' => false,
                            ])
                        </div>

                        <div class="md:col-span-3 mt-2 md:mt-0">
                            @include('partials.forms.textarea', [
                                   'label' => __('donations.language_spoken'),
                                   'name' => 'language_spoken',
                                   'placeholder' => '',
                                   'value' =>  old('language_spoken'),
                                   'required' => true,
                                   'disabled' => false,
                                   'style' => '',
                               ])
                        </div>
                    </div>
                </div>
            </div>

            <div class="border-b-2 my-8"></div>

            {{-- I want to help --}}
            <div x-data="{ selectedDK: '{{old('offer_kind', 'financial')}}' }">
                <div class="md:grid md:grid-cols-3 md:gap-6">
                    <div class="md:col-span-1">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">@lang('donations.i_want_to_help')</h3>
                        <p class="mt-1 text-sm text-gray-500">
                            @lang('donations.kind_of_help_description')
                        </p>
                    </div>
                    <div class="mt-5 md:mt-0 md:col-span-2">
                        @include('partials.donationOffers.offerKindSelector')
                    </div>
                </div>

                <div class="border-b-2 my-8"></div>

                @include('partials.donationOffers.offerKindDetails')
            </div>

            <div class="border-b-2 my-8"></div>

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
