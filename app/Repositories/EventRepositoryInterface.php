<?php

namespace App\Repositories;

use App\Models\Event;
use Illuminate\Support\Collection;

interface EventRepositoryInterface
{
    /**
     * Get all Events.
     *
     * @param  int|null  $recordsPerPage
     * @param  array|null  $searchParameters
     * @param  string  $orderDirection  sorting direction: 'asc' = from oldest to newest | 'desc' = from newest to oldest
     * @return Event[]|\Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Collection
     */
    public function getAll(int $recordsPerPage = null, array $searchParameters = null, string $orderDirection = 'asc');

    /**
     * Get Event by id
     *
     * @param  int  $eventId
     * @return Event
     */
    public function getById(int $eventId): Event;

    /**
     * Get Event by slug
     *
     * @param  string  $eventSlug
     * @return Event
     */
    public function getBySlug(string $eventSlug): ?Event;

    /**
     * Return the list of the expiring repetitive events (the 7th day from now).
     * Consider just Weekly(2) and Monthly(3) events.
     * It returns just the events expiring the 7th day from now, not the 6th day or less.
     *
     * @return Collection
     */
    public function getRepetitiveExpiringInOneWeek(): Collection;

    /**
     * Store Event
     *
     * @param  array  $data
     *
     * @return Event
     * @throws \Spatie\ModelStatus\Exceptions\InvalidStatus
     */
    public function store(array $data): Event;

    /**
     * Update Event
     *
     * @param  array  $data
     * @param  int  $id
     *
     * @return Event
     */
    public function update(array $data, Event $event): Event;

    /**
     * Delete Event
     *
     * @param  int  $id
     * @return void
     */
    public function delete(int $id): void;

    /**
     * Assign the attributes of the data array to the object
     *
     * @param  Event  $event
     * @param  array  $data
     *
     * @return Event
     */
    public function assignDataAttributes(Event $event, array $data): Event;

    /**
     * Sync the many-to-many relatioships
     *
     * @param  Event  $event
     * @param  array  $data
     *
     * @return void
     */
    public function syncManyToMany(Event $event, array $data): void;

    /**
     * Return the active events number
     *
     * @return int
     */
    public function activeEventsCount(): int;

    /**
     * Return event count by country.
     *
     * @return Collection
     */
    public function activeEventsCountByCountry(): Collection;
}