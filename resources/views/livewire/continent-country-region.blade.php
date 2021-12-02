<div>
    <div class="form-group row">
        <label for="continent" class="col-md-4 col-form-label text-md-right">{{ __('Continent') }}</label>

        <div class="col-md-6">
            <select wire:model="selectedContinent" class="form-control">
                <option value="" selected>Choose continent</option>
                @foreach($continents as $continent)
                    <option value="{{ $continent->id }}">{{ $continent->name }}</option>
                @endforeach
            </select>
        </div>
    </div>

    @if (!is_null($selectedContinent))
        <div class="form-group row">
            <label for="country" class="col-md-4 col-form-label text-md-right">{{ __('Country') }}</label>

            <div class="col-md-6">
                <select wire:model="selectedCountry" class="form-control">
                    <option value="" selected>Choose country</option>
                    @foreach($countries as $country)
                        <option value="{{ $country->id }}">{{ $country->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    @endif

    @if (!is_null($selectedCountry))
        <div class="form-group row">
            <label for="region" class="col-md-4 col-form-label text-md-right">{{ __('Region') }}</label>

            <div class="col-md-6">
                <select wire:model="selectedRegion" class="form-control" name="region_id">
                    <option value="" selected>Choose region</option>
                    @foreach($regions as $region)
                        <option value="{{ $region->id }}">{{ $region->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    @endif
</div>