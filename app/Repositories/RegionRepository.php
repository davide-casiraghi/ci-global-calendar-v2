<?php


namespace App\Repositories;

use App\Models\Region;
use Illuminate\Support\Collection;

class RegionRepository
{
    /**
     * Get all Regions.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getAll(): Collection
    {
        return Region::orderBy('name')->get();
    }

    /**
     * Get Region by id
     *
     * @param int $id
     * @return Region
     */
    public function getById(int $id)
    {
        return Region::findOrFail($id);
    }

    /**
     * Store Region
     *
     * @param array $data
     * @return Region
     */
    public function store(array $data): Region
    {
        $region = new Region();
        $region = self::assignDataAttributes($region, $data);

        $region->save();

        return $region->fresh();
    }

    /**
     * Update Region
     *
     * @param array $data
     * @param int $id
     * @return Region
     */
    public function update(array $data, int $id): Region
    {
        $region = $this->getById($id);
        $region = self::assignDataAttributes($region, $data);

        $region->update();

        return $region;
    }

    /**
     * Delete Region
     *
     * @param int $id
     * @return void
     */
    public function delete(int $id): void
    {
        Region::destroy($id);
    }

    /**
     * Assign the attributes of the data array to the object
     *
     * @param \App\Models\Region $region
     * @param array $data
     *
     * @return \App\Models\Region
     */
    public function assignDataAttributes(Region $region, array $data): Region
    {
        $region->name = $data['name'];
        $region->timezone = $data['timezone'];
        $region->country_id = $data['country_id'];

        return $region;
    }
}
