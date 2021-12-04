<?php

namespace App\Http\Livewire;

use App\Models\Continent;
use App\Models\Country;
use App\Models\Region;
use Livewire\Component;

class ContinentCountryRegion extends Component
{
    public $continents;
    public $countries;
    public $regions;

    public $selectedContinent = null;
    public $selectedCountry = null;
    public $selectedRegion = null;

    public function mount($selectedCountry = null)
    {
        $this->continents = Continent::all();
        $this->countries = collect();
        $this->regions = collect();
        //$this->selectedCountry = $selectedCountry;

        if (!is_null($selectedCountry)) {
            $region = Region::with('country.continent')->find($selectedCountry);
            if ($region) {
                $this->regions = Region::where('country_id', $region->country_id)->get();
                $this->country = Country::where('continent_id', $region->country->continent_id)->get();
                $this->selectedContinent = $region->country->continent_id;
                $this->selectedCountry = $region->country_id;
            }
        }
    }

    public function updatedSelectedContinent($continent)
    {
        $this->countries = Country::where('continent_id', $continent)->get();
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
