<?php


namespace App\Repositories;

use App\Models\Country;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class CountryRepository implements CountryRepositoryInterface
{

    /**
     * Get all Countries.
     *
     * @param  int|null  $recordsPerPage
     * @param  array|null  $searchParameters
     * @return Collection
     */
    public function getAll(int $recordsPerPage = null, array $searchParameters = null): Collection
    {
        $query = Country::select([
            'countries.id',
            'countries.name',
            'continents.name as continent_name',
        ])
            ->leftJoin('continents', 'countries.continent_id', '=', 'continents.id');

        if (!is_null($searchParameters)) {
            foreach ($searchParameters as $searchParameter => $value) {
                if (!empty($value)) {
                    if ($searchParameter == 'continent_id') {
                        $query->where($searchParameter, $value);
                    } else {
                        $query->where('countries.'.$searchParameter, 'LIKE', '%'.$value.'%');
                    }
                }
            }
        }

        $query->orderBy('name', 'asc');

        if ($recordsPerPage) {
            $results = $query->paginate($recordsPerPage)->withQueryString();
        } else {
            $results = $query->get();
        }

        return $results;
    }

    /**
     * Get Country by id
     *
     * @param int $id
     * @return Country
     */
    public function getById(int $id)
    {
        return Country::findOrFail($id);
    }

    /**
     * Store Country
     *
     * @param array $data
     * @return Country
     */
    public function store(array $data): Country
    {
        $country = new Country();
        $country = self::assignDataAttributes($country, $data);

        $country->save();

        return $country->fresh();
    }

    /**
     * Update Country
     *
     * @param array $data
     * @param int $id
     * @return Country
     */
    public function update(array $data, int $id): Country
    {
        $country = $this->getById($id);
        $country = self::assignDataAttributes($country, $data);

        $country->update();

        return $country;
    }

    /**
     * Delete Country
     *
     * @param int $id
     * @return void
     */
    public function delete(int $id): void
    {
        Country::destroy($id);
    }

    /**
     * Assign the attributes of the data array to the object
     *
     * @param \App\Models\Country $country
     * @param array $data
     *
     * @return \App\Models\Country
     */
    public function assignDataAttributes(Country $country, array $data): Country
    {
        $country->name = $data['name'];
        $country->code = $data['code'];
        $country->continent_id = $data['continent_id'];

        return $country;
    }

    /**
     * Get all countries with Active events.
     *
     * @return Collection
     */
    public function getCountriesWithActiveEvents()
    {
        $query = Country::select(['countries.id','countries.name'])
            ->join('venues', 'venues.country_id', '=', 'countries.id')
            ->join('events', 'events.venue_id', '=', 'venues.id')
            ->join('event_repetitions', 'events.id', '=', 'event_repetitions.event_id')
            ->where('event_repetitions.start_repeat', '>=', Carbon::today())
            ->where('is_published', true)
            ->orderBy('countries.name', 'asc');

        return $query->get()->unique('id');
    }
}
