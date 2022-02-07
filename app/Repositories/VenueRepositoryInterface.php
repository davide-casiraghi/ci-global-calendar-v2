<?php

namespace App\Repositories;

use App\Models\Venue;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface VenueRepositoryInterface
{
    /**
     * Get all EventCategories.
     *
     * @param  int|null  $recordsPerPage
     * @param  array|null
     * @param  bool  $showJustOwned
     * @return Collection|LengthAwarePaginator
     */
    public function getAll(int $recordsPerPage = null, array $searchParameters = null, bool $showJustOwned = false);

    /**
     * Get Venue by id
     *
     * @param  int  $id
     *
     * @return Venue
     */
    public function getById(int $id): Venue;

    /**
     * Store Venue
     *
     * @param  array  $data
     *
     * @return Venue
     */
    public function store(array $data): Venue;

    /**
     * Update Venue
     *
     * @param  array  $data
     * @param  Venue  $venue
     * @return Venue
     */
    public function update(array $data, Venue $venue): Venue;

    /**
     * Delete Venue
     *
     * @param  int  $id
     * @return void
     */
    public function delete(int $id): void;

    /**
     * Assign the attributes of the data array to the object
     *
     * @param  Venue  $venue
     * @param  array  $data
     *
     * @return Venue
     */
    public function assignDataAttributes(Venue $venue, array $data): Venue;
}