<?php

namespace App\Repositories;

use App\Models\Region;
use Illuminate\Support\Collection;

interface RegionRepositoryInterface
{
    /**
     * Get all Regions.
     *
     * @param  int|null  $recordsPerPage
     * @param  array|null  $searchParameters
     * @return Collection
     */
    public function getAll(int $recordsPerPage = null, array $searchParameters = null): Collection;

    /**
     * Get Region by id
     *
     * @param  int  $id
     * @return Region
     */
    public function getById(int $id);

    /**
     * Store Region
     *
     * @param  array  $data
     * @return Region
     */
    public function store(array $data): Region;

    /**
     * Update Region
     *
     * @param  array  $data
     * @param  int  $id
     * @return Region
     */
    public function update(array $data, int $id): Region;

    /**
     * Delete Region
     *
     * @param  int  $id
     * @return void
     */
    public function delete(int $id): void;

    /**
     * Assign the attributes of the data array to the object
     *
     * @param  \App\Models\Region  $region
     * @param  array  $data
     *
     * @return \App\Models\Region
     */
    public function assignDataAttributes(Region $region, array $data): Region;
}