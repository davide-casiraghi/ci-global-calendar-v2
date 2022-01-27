<?php

namespace App\Repositories;

use App\Models\Organizer;

interface OrganizerRepositoryInterface
{
    /**
     * Get all Organizers.
     *
     * @param  int|null  $recordsPerPage
     * @param  array|null  $searchParameters
     *
     * @return Organizer[]|\Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Collection
     */
    public function getAll(int $recordsPerPage = null, array $searchParameters = null);

    /**
     * Get Organizer by id
     *
     * @param  int  $id
     *
     * @return Organizer
     */
    public function getById(int $id): Organizer;

    /**
     * Get Organizer by slug
     *
     * @param  string  $organizerSlug
     * @return Organizer
     */
    public function getBySlug(string $organizerSlug): ?Organizer;

    /**
     * Store Organizer
     *
     * @param  array  $data
     *
     * @return Organizer
     */
    public function store(array $data): Organizer;

    /**
     * Update Organizer
     *
     * @param  array  $data
     * @param  Organizer  $organizer
     *
     * @return Organizer
     */
    public function update(array $data, Organizer $organizer): Organizer;

    /**
     * Delete Organizer
     *
     * @param  int  $id
     * @return void
     */
    public function delete(int $id): void;

    /**
     * Assign the attributes of the data array to the object
     *
     * @param  Organizer  $organizer
     * @param  array  $data
     *
     * @return Organizer
     */
    public function assignDataAttributes(Organizer $organizer, array $data): Organizer;

    /**
     * Return the organizer number
     *
     * @return int
     */
    public function organizersCount(): int;
}