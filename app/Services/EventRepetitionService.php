<?php
namespace App\Services;

use App\Http\Requests\EventRepetitionStoreRequest;
use App\Http\Requests\EventStoreRequest;
use App\Models\EventRepetition;
use App\Repositories\EventRepetitionRepository;

class EventRepetitionService
{
    private EventRepetitionRepository $eventRepetitionRepository;

    /**
     * EventRepetitionService constructor.
     *
     * @param \App\Repositories\EventRepetitionRepository $eventRepetitionRepository
     */
    public function __construct(
        EventRepetitionRepository $eventRepetitionRepository
    ) {
        $this->eventRepetitionRepository = $eventRepetitionRepository;
    }

    /**
     * Create a eventRepetition
     *
     * @param array $data
     *
     * @return \App\Models\EventRepetition
     */
    /*public function createEventRepetition(array $data): EventRepetition
    {
        $eventRepetition = $this->eventRepetitionRepository->store($data);

        return $eventRepetition;
    }*/

    /**
     * Update the EventRepetition
     *
     * @param array $data
     * @param int $eventRepetitionId
     *
     * @return void
     */
    public function updateEventRepetitions(array $data, int $eventRepetitionId): void
    {
        $this->eventRepetitionRepository->updateEventRepetitions($data, $eventRepetitionId);

        //return $eventRepetition;
    }

    /**
     * Return the eventRepetition from the database
     *
     * @param int $eventRepetitionId
     *
     * @return \App\Models\EventRepetition
     */
    public function getById(int $eventRepetitionId): EventRepetition
    {
        return $this->eventRepetitionRepository->getById($eventRepetitionId);
    }

    /**
     * Get all the EventRepetitions.
     *
     * @return iterable
     */
    /*public function getEventRepetitions()
    {
        return $this->eventRepetitionRepository->getAll();
    }*/

    /**
     * Delete the eventRepetition from the database
     *
     * @param int $eventRepetitionId
     */
    /*public function deleteEventRepetition(int $eventRepetitionId): void
    {
        $this->eventRepetitionRepository->delete($eventRepetitionId);
    }*/

    /**
     * Get the event first repetition
     *
     * @param int $eventId
     *
     * @return EventRepetition
     */
    public function getFirstByEventId(int $eventId)
    {
        return $this->eventRepetitionRepository->getFirstByEventId($eventId);
    }
}
