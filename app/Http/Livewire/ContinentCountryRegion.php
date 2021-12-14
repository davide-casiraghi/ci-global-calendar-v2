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

    public function mount($selectedContinent = null, $selectedCountry = null, $selectedRegion = null)
    {
        $this->continents = Continent::all();
        $this->countries = collect();
        $this->regions = collect();

        if (!is_null($selectedContinent)) {
            $this->selectedContinent = $selectedContinent;
            $this->countries = Country::where('continent_id', $selectedContinent)->get();
        }

        if (!is_null($selectedCountry)) {
            $this->selectedCountry = $selectedCountry;
            $regions = Region::where('country_id', $selectedCountry)->get();
            if (count($regions) > 0) {
                $this->regions = $regions;
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
