<?php

namespace App\Http\Livewire;

use App\Services\CountryService;
use App\Services\RegionService;
use Illuminate\Support\Facades\App;
use Livewire\Component;

class CountryRegionSelect extends Component
{
    public $countries;
    public $regions;

    public $selectedCountry = null;
    public $selectedRegion = null;

    public function mount(int $selectedCountry = null, int $selectedRegion = null)
    {
        $countryService = App::make(CountryService::class);

        $this->countries = $countryService->getCountries();
        $this->regions = collect();

        if (!is_null($selectedCountry)) {
            $this->selectedCountry = $selectedCountry;

            //$regions = Region::where('country_id', $selectedCountry)->get();

            $regionService = App::make(RegionService::class);
            $regions = $regionService->getRegions(null, ['country_id' => $selectedCountry]);
            //dd($regions);

            if (count($regions) > 0) {
                $this->regions = $regions;
            }
        }

        if (!is_null($selectedRegion)) {
            $this->selectedRegion = $selectedRegion;
        }
    }

    /**
     * Update the regions' dropdown when the country dropdown changes.
     *
     * @param  int  $countryId
     * @return void
     */
    public function updatedSelectedCountry(int $countryId): void
    {
        $regionService = App::make(RegionService::class);
        $this->regions = $regionService->getRegions(null, ['country_id' => $countryId]);
    }

    public function render()
    {
        return view('livewire.country-region-select');
    }
}

