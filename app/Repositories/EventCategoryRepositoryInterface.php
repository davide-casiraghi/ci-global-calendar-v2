<?php

namespace App\Repositories;

use App\Models\EventCategory;
use Illuminate\Support\Collection;

interface EventCategoryRepositoryInterface
{
    /**
     * Get all EventCategories.
     *
     * @return Collection
     */
    public function getAll(): Collection;

    /**
     * Get EventCategory by id
     *
     * @param  int  $id
     * @return EventCategory
     */
    public function getById(int $id): EventCategory;

    /**
     * Store EventCategory
     *
     * @param  array  $data
     * @return EventCategory
     */
    public function store(array $data): EventCategory;

    /**
     * Update EventCategory
     *
     * @param  array  $data
     * @param  EventCategory  $eventCategory
     * @return EventCategory
     */
    public function update(array $data, EventCategory $eventCategory): EventCategory;

    /**
     * Delete EventCategory
     *
     * @param  int  $id
     * @return void
     */
    public function delete(int $id): void;

    /**
     * Assign the attributes of the data array to the object
     *
     * @param  EventCategory  $eventCategory
     * @param  array  $data
     *
     * @return EventCategory
     */
    public function assignDataAttributes(EventCategory $eventCategory, array $data): EventCategory;
}