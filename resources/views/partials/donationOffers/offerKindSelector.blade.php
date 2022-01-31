<div class="">
    <div class="mb-2">
        <label for="i_can_offer" class="block text-sm font-medium text-gray-700 inline">@lang('donations.i_can_offer')</label>
        <span class="simple-tooltip text-gray-500 inline" title="@lang('views.required')">*</span>
    </div>
    <div class="flex w-full space-x-4 uppercase text-xs font-bold text-gray-500 text-center">
        @foreach($donationKindItems as $key => $donationKindItem)
            <label x-on:click="selectedDK = '{{$key}}'" for="{{$donationKindItem['id']}}" class="w-1/4 p-4 rounded border" :class="{ 'border-2 border-green-700 bg-green-100/50': selectedDK === '{{$key}}' }">
                <input id="{{$donationKindItem['id']}}" type="radio" name="offer_kind" value="{{$key}}" class="hidden" x-bind:checked="selectedDK == '{{$key}}'">
                {!! $donationKindItem['icon'] !!}
                <div class="block m-auto mt-3">
                    {{$donationKindItem['label']}}
                </div>
            </label>
        @endforeach
    </div>
</div>


