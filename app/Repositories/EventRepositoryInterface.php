<?php

namespace App\Repositories;

use App\Models\Event;

interface EventRepositoryInterface
{
    /**
     * Get all Events.
     *
     * @param  int|null  $recordsPerPage
     * @param  array|null  $searchParameters
     * @param  string  $orderDirection sorting direction: 'asc' = from oldest to newest | 'desc' = from newest to oldest
     * @return \App\Models\Event[]|\Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Collection
     */
    public function getAll(
        int $recordsPerPage = null,
        array $searchParameters = null,
        string $orderDirection = 'asc'
    );

    /**
     * Get Event by id
     *
     * @param int $eventId
     *
     * @return Event
     */
    public function getById(int $eventId);

    /**
     * Get Event by slug
     *
     * @param  string  $eventSlug
     * @return Event
     */
    public function getBySlug(string $eventSlug): ?Event;

    /**
     * Store Event
     *
     * @param array $data
     *
     * @return Event
     * @throws \Spatie\ModelStatus\Exceptions\InvalidStatus
     */
    public function store(array $data): Event;

    /**
     * Update Event
     *
     * @param array $data
     * @param int $id
     *
     * @return Event
     */
    public function update(array $data, int $id): Event;

    /**
     * Delete Event
     *
     * @param int $id
     *
     * @return void
     */
    public function delete(int $id);
}
