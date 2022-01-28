@extends('layouts.backend')

@section('title')
    @lang('donations.donation_offers_management')
@endsection

@section('buttons')
    <a href="{{ route('donationOffers.create') }}" target="_self" class="blueButton smallButton">
        @lang('donations.create_new_donation_offer')
    </a>
@endsection

@section('content')

    @include('partials.donationOffers.searchBar')

    {{-- Tailwind Component: https://tailwindui.com/components/application-ui/lists/stacked-lists--}}
    <div class="bg-white shadow overflow-hidden sm:rounded-md">
        <ul class="divide-y divide-gray-200">
            @foreach($donationOffers as $donationOffer)
                @include('$partials.donationOffers.indexItem', [
                    'donationOffer' => $donationOffer
                ])
            @endforeach
        </ul>
    </div>

    <div class="my-5">
        {{ $donationOffers->links() }}
    </div>

@endsection
