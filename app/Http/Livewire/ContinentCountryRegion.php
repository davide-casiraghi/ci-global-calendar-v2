<?php

namespace App\Http\Livewire;

use App\Models\Continent;
use App\Models\Country;
use App\Models\Region;
use App\Services\CountryService;
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

    public function mount($selectedContinent = null, $selectedCountry = null, $selectedRegion = null)
    {
        $countryService = App::make(CountryService::class);

        $this->continents = Continent::orderBy('name', 'asc')->get();
        $this->countries = $countryService->getCountriesWithActiveEvents();
        $this->regions = collect();

        if (!is_null($selectedContinent)) {
            $this->selectedContinent = $selectedContinent;
            $this->countries = Country::where('continent_id', $selectedContinent)->orderBy('name', 'asc')->get();
        }

        if (!is_null($selectedCountry)) {
            $this->selectedCountry = $selectedCountry;
            $regions = Region::where('country_id', $selectedCountry)->get();
            if (count($regions) > 0) {
                $this->regions = $regions;
            }
        }
    }

    /**
     * Updated the countries' dropdown when the continent dropdown changes.
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

    public function updatedSelectedCountry($country)
    {
        if (!is_null($country)) {
            $this->regions = Region::where('country_id', $country)->get();
        }
    }

    public function render()
    {
        return view('livewire.continent-country-region');
    }
}
