<?php


namespace App\Repositories;

use App\Models\Country;
use Illuminate\Support\Collection;

class CountryRepository implements CountryRepositoryInterface
{

    /**
     * Get all Countries.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getAll(): Collection
    {
        return Country::orderBy('name')->get();
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
}
