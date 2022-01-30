<div class="md:grid md:grid-cols-3 md:gap-6">

    {{-- Donation kind title --}}
    <div class="md:col-span-1">
        <div x-show="selectedDK == 'financial'">
            <h3 class="text-lg font-medium leading-6 text-gray-900">@lang('donations.donation_kind_financial')</h3>
        </div>
        <div x-show="selectedDK == 'free_entrance'">
            <h3 class="text-lg font-medium leading-6 text-gray-900">@lang('donations.donation_kind_free_entrance')</h3>
            <p class="text-gray-500 mb-2">
                @lang('donations.gift_kind_free_festival')
            </p>
        </div>
        <div x-show="selectedDK == 'volunteer'">
            <h3 class="text-lg font-medium leading-6 text-gray-900">@lang('donations.donation_kind_other_gift')</h3>
            <p class="text-gray-500 mb-2">
                @lang('donations.other_description')
            </p>
            <p class="text-gray-500 mb-2">
            @lang('donations.other_suggestion')
        </div>
        <div x-show="selectedDK == 'other_gift'">
            <h3 class="text-lg font-medium leading-6 text-gray-900">@lang('donations.donation_kind_volunteer')</h3>
            <p class="text-gray-500 mb-2">
                @lang('donations.volunteering_thank_you')
            </p>
            <p class="text-gray-500 mb-2">
                @lang('donations.volunteering_details') <br>
            </p>
        </div>
    </div>

    {{-- Donation kind form inputs --}}
    <div class="mt-5 md:mt-0 md:col-span-2">
        <p class="text-gray-500 mb-2">
            @lang('donations.financial_contribution_description')
        </p>
        <a href="/posts/donate" class="" target="_blank">@lang('menu.donate') ></a>
    </div>
</div>
