@php
    $selectTailwindClasses = "mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm";
    $optionTailwindClasses = "text-gray-500";
@endphp

<div>


    <div class="col-span-6">
        @include('partials.forms.input', [
                'label' => __('eventVenue.city'),
                'name' => 'city',
                'placeholder' => '',
                'value' => old('city', $venue->city),
                'required' => false,
                'disabled' => false,
        ])
    </div>


    {{--@if (!is_null($selectedContinent))--}}
    <div class="form-group row mt-4">
        {{--<label for="country" class="col-md-4 col-form-label text-md-right">Country</label>--}}

        <div class="col-md-6">
            <select wire:model="selectedCountry" class="form-control {{$selectTailwindClasses}}" name="country_id">
                <option value="" selected>Choose country</option>
                @foreach($countries as $country)
                    <option value="{{ $country->id }}" class="{{$optionTailwindClasses}}">{{ $country->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
    {{--@endif--}}

    @if (!is_null($selectedCountry))
        <div class="form-group row mt-4">
            {{--<label for="region" class="col-md-4 col-form-label text-md-right">Region</label>--}}

            <div class="col-md-6">
                <select wire:model="selectedRegion" class="form-control {{$selectTailwindClasses}}" name="region_id">
                    <option value="" selected>Choose region</option>
                    @foreach($regions as $region)
                        <option value="{{ $region->id }}" class="{{$optionTailwindClasses}}">{{ $region->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    @endif
</div>