@php
    $selectTailwindClasses = "mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm";
    $optionTailwindClasses = "text-gray-500";
@endphp

<div class="col-span-6">
    <div class="">
        <label for="country" class="block text-sm font-medium text-gray-700 inline">@lang('general.country')</label>
        <span class="simple-tooltip text-gray-500 inline" title="@lang('views.required')">*</span>
        <div class="col-md-6">
            <select wire:model="selectedCountry" class="form-control {{$selectTailwindClasses}}" name="country_id">
                <option value="" selected>@lang('general.select_one')</option>
                @foreach($countries as $country)
                    <option value="{{ $country->id }}" class="{{$optionTailwindClasses}}">{{ $country->name }}</option>
                @endforeach
            </select>
        </div>
    </div>

    @if ($regions->isNotEmpty())
        <div class="mt-4">
            <label for="region" class="block text-sm font-medium text-gray-700 inline">@lang('eventVenue.region')</label>

            <div class="col-md-6">
                <select wire:model="selectedRegion" class="form-control {{$selectTailwindClasses}}" name="region_id">
                    <option value="" selected>@lang('general.select_one')</option>
                    @foreach($regions as $region)
                        <option value="{{ $region->id }}" class="{{$optionTailwindClasses}}">{{ $region->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    @endif
</div>