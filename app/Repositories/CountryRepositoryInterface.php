<?php

namespace App\Repositories;

use App\Models\Country;
use Illuminate\Support\Collection;

interface CountryRepositoryInterface
{
    /**
     * Get all Countries.
     *
     * @param  int|null  $recordsPerPage
     * @param  array|null  $searchParameters
     * @return Collection
     */
    public function getAll(int $recordsPerPage = null, array $searchParameters = null): Collection;

    /**
     * Get Country by id
     *
     * @param  int  $id
     * @return Country
     */
    public function getById(int $id);

    /**
     * Store Country
     *
     * @param  array  $data
     * @return Country
     */
    public function store(array $data): Country;

    /**
     * Update Country
     *
     * @param  array  $data
     * @param  int  $id
     * @return Country
     */
    public function update(array $data, int $id): Country;

    /**
     * Delete Country
     *
     * @param  int  $id
     * @return void
     */
    public function delete(int $id): void;

    /**
     * Assign the attributes of the data array to the object
     *
     * @param  \App\Models\Country  $country
     * @param  array  $data
     *
     * @return \App\Models\Country
     */
    public function assignDataAttributes(Country $country, array $data): Country;
}