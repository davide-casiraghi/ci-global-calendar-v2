<li>
    <a href="{{route('donationOffers.edit', $donationOffer)}}" class="block hover:bg-gray-50">
        <div class="px-4 py-4 sm:px-6">

            {{-- Name Surname Country  ---   Donation kind --}}
            <div class="flex items-center justify-between">
                <div class="flex">
                    <div class="text-sm font-medium text-indigo-600 truncate">
                        {{$donationOffer->name}} {{$donationOffer->surname}}
                    </div>
                    {{-- Country --}}
                    <div class="flex items-center ml-3">
                        <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM4.332 8.027a6.012 6.012 0 011.912-2.706C6.512 5.73 6.974 6 7.5 6A1.5 1.5 0 019 7.5V8a2 2 0 004 0 2 2 0 011.523-1.943A5.977 5.977 0 0116 10c0 .34-.028.675-.083 1H15a2 2 0 00-2 2v2.197A5.973 5.973 0 0110 16v-2a2 2 0 00-2-2 2 2 0 01-2-2 2 2 0 00-1.668-1.973z" clip-rule="evenodd"></path></svg>
                        <p class="text-sm text-gray-500">{{$donationOffer->country->name}}</p>
                    </div>
                </div>

                <div class="ml-2 flex-shrink-0 flex">
                    <div class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full border-2 border-gray-400 bg-gray-100 text-gray-600">
                        @lang(\App\Models\DonationOffer::OFFER_KIND[$donationOffer->offer_kind])
                    </div>
                </div>
            </div>

            {{-- Gift title/Volunteer kind   ---   Created on --}}
            <div class="flex items-center justify-between mt-2">
                <div class="text-sm text-gray-500">
                    {{$donationOffer->gift_title}} {{$donationOffer->volunteer_kind}}
                </div>
                <div class="ml-2 flex-shrink-0 flex">
                    <!-- Heroicon name: calendar -->
                    <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                    </svg>
                    <div class="text-sm text-gray-500">
                        Created on:
                        <time datetime="{{$donationOffer->created_at->format('Y-m-d')}}">
                            {{$donationOffer->created_at->format('M j, Y')}}
                        </time>
                    </div>
                </div>
            </div>

        </div>
    </a>
</li>
