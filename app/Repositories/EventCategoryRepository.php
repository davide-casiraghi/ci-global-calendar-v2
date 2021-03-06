<?php

namespace App\Repositories;

use App\Models\EventCategory;
use Illuminate\Support\Collection;

class EventCategoryRepository implements EventCategoryRepositoryInterface
{
    /**
     * Get all EventCategories.
     *
     * @return Collection
     */
    public function getAll(): Collection
    {
        return EventCategory::orderBy('name')->get();
    }

    /**
     * Get EventCategory by id
     *
     * @param int $id
     * @return EventCategory
     */
    public function getById(int $id): EventCategory
    {
        return EventCategory::findOrFail($id);
    }

    /**
     * Store EventCategory
     *
     * @param array $data
     * @return EventCategory
     */
    public function store(array $data): EventCategory
    {
        $eventCategory = new EventCategory();
        $eventCategory = self::assignDataAttributes($eventCategory, $data);

        $eventCategory->save();

        return $eventCategory->fresh();
    }

    /**
     * Update EventCategory
     *
     * @param  array  $data
     * @param  EventCategory  $eventCategory
     * @return EventCategory
     */
    public function update(array $data, EventCategory $eventCategory): EventCategory
    {
        $eventCategory = self::assignDataAttributes($eventCategory, $data);

        $eventCategory->update();

        return $eventCategory;
    }

    /**
     * Delete EventCategory
     *
     * @param int $id
     * @return void
     */
    public function delete(int $id): void
    {
        EventCategory::destroy($id);
    }

    /**
     * Assign the attributes of the data array to the object
     *
     * @param  EventCategory  $eventCategory
     * @param array $data
     *
     * @return EventCategory
     */
    public function assignDataAttributes(EventCategory $eventCategory, array $data): EventCategory
    {
        $eventCategory->name = $data['name'];
        $eventCategory->description = $data['description'];

        return $eventCategory;
    }
}
