<?php

namespace App\Services;

use App\Http\Requests\EventCategoryStoreRequest;
use App\Models\EventCategory;
use App\Repositories\EventCategoryRepository;
use Illuminate\Support\Collection;

class EventCategoryService
{

    private EventCategoryRepository $eventCategoryRepository;

    /**
     * EventCategoryService constructor.
     *
     * @param \App\Repositories\EventCategoryRepository $eventCategoryRepository
     */
    public function __construct(
        EventCategoryRepository $eventCategoryRepository
    ) {
        $this->eventCategoryRepository = $eventCategoryRepository;
    }

    /**
     * Create a EventCategory
     *
     * @param \App\Http\Requests\EventCategoryStoreRequest $request
     *
     * @return \App\Models\EventCategory
     */
    public function createEventCategory(EventCategoryStoreRequest $request): EventCategory
    {
        $eventCategory = $this->eventCategoryRepository->store($request->all());

        return $eventCategory;
    }

    /**
     * Update the EventCategory
     *
     * @param \App\Http\Requests\EventCategoryStoreRequest $request
     * @param int $eventCategoryId
     *
     * @return \App\Models\EventCategory
     */
    public function updateEventCategory(EventCategoryStoreRequest $request, int $eventCategoryId): EventCategory
    {
        $eventCategory = $this->eventCategoryRepository->update($request->all(), $eventCategoryId);

        return $eventCategory;
    }

    /**
     * Return the EventCategory from the database
     *
     * @param int $eventCategoryId
     *
     * @return \App\Models\EventCategory
     */
    public function getById(int $eventCategoryId): EventCategory
    {
        return $this->eventCategoryRepository->getById($eventCategoryId);
    }

    /**
     * Get all the EventCategories
     *
     * @return Collection
     */
    public function getEventCategories(): Collection
    {
        return $this->eventCategoryRepository->getAll();
    }

    /**
     * Delete the EventCategory from the database
     *
     * @param int $eventCategoryId
     */
    public function deleteEventCategory(int $eventCategoryId): void
    {
        $this->eventCategoryRepository->delete($eventCategoryId);
    }

}