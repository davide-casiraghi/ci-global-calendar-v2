<?php

namespace App\Http\Livewire;

use App\Models\Continent;
use App\Models\Country;
use App\Models\Region;
use App\Services\CountryService;
use App\Services\RegionService;
use Illuminate\Support\Facades\App;
use Livewire\Component;

class ContinentCountryRegion extends Component
{
    public $continents;
    public $countries;
    public $regions;

    public $selectedContinent = null;
    public $selectedCountry = null;
    public $selectedRegion = null;

    public function mount(int $selectedContinent = null, int $selectedCountry = null, int $selectedRegion = null)
    {
        $countryService = App::make(CountryService::class);

        $this->continents = Continent::orderBy('name', 'asc')->get();
        $this->countries = $countryService->getCountriesWithActiveEvents();
        $this->regions = collect();

        if (!is_null($selectedContinent)) {
            $this->selectedContinent = $selectedContinent;
            $this->countries = $countryService->getCountriesWithActiveEvents($selectedContinent);
        }

        if (!is_null($selectedCountry)) {
            $this->selectedCountry = $selectedCountry;
            $regions = Region::where('country_id', $selectedCountry)->get();
            if (count($regions) > 0) {
                $this->regions = $regions;
            }
        }

        if (!is_null($selectedRegion)) {
            $this->selectedRegion = $selectedRegion;
        }
    }

    /**
     * Update the countries' dropdown when the continent dropdown changes.
     *
     * @param  int  $continentId
     * @return void
     */
    public function updatedSelectedContinent(int $continentId): void
    {
        $countryService = App::make(CountryService::class);
        $this->countries = $countryService->getCountriesWithActiveEvents($continentId);

        $this->selectedCountry = NULL;
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
        $this->regions = $regionService->getRegionsWithActiveEvents($countryId);

        //$this->regions = Region::where('country_id', $countryId)->get();
    }

    public function render()
    {
        return view('livewire.continent-country-region');
    }
}
