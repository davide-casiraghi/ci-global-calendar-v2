<?php
namespace App\Services;

use App\Helpers\ImageHelpers;
use App\Http\Requests\OrganizerStoreRequest;
use App\Models\Organizer;
use App\Repositories\OrganizerRepositoryInterface;

class OrganizerService
{
    private OrganizerRepositoryInterface $organizerRepository;

    /**
     * OrganizerService constructor.
     *
     * @param  OrganizerRepositoryInterface  $organizerRepository
     */
    public function __construct(
        OrganizerRepositoryInterface $organizerRepository
    ) {
        $this->organizerRepository = $organizerRepository;
    }

    /**
     * Create a organizer
     *
     * @param  OrganizerStoreRequest  $request
     *
     * @return \App\Models\Organizer
     * @throws \Spatie\ModelStatus\Exceptions\InvalidStatus
     */
    public function createOrganizer(OrganizerStoreRequest $request): Organizer
    {
        $organizer = $this->organizerRepository->store($request->all());
        ImageHelpers::storeImages($organizer, $request, 'profile_picture');

        return $organizer;
    }

    /**
     * Update the Organizer
     *
     * @param  OrganizerStoreRequest  $request
     * @param  Organizer  $organizer
     * @return \App\Models\Organizer
     */
    public function updateOrganizer(OrganizerStoreRequest $request, Organizer $organizer): Organizer
    {
        $organizer = $this->organizerRepository->update($request->all(), $organizer);

        ImageHelpers::storeImages($organizer, $request, 'profile_picture');
        ImageHelpers::deleteImages($organizer, $request, 'profile_picture');

        return $organizer;
    }

    /**
     * Return the organizer from the database
     *
     * @param int $organizerId
     *
     * @return \App\Models\Organizer
     */
    public function getById(int $organizerId): Organizer
    {
        return $this->organizerRepository->getById($organizerId);
    }

    /**
     * Get Organizer by slug
     *
     * @param  string  $organizerSlug
     * @return Organizer|null
     */
    public function getBySlug(string $organizerSlug): ?Organizer
    {
        return $this->organizerRepository->getBySlug($organizerSlug);
    }

    /**
     * Get all the Organizers.
     *
     * @param int|null $recordsPerPage
     * @param array|null $searchParameters
     * @param  bool  $showJustOwned
     *
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getOrganizers(int $recordsPerPage = null, array $searchParameters = null, bool $showJustOwned = false)
    {
        return $this->organizerRepository->getAll($recordsPerPage, $searchParameters, $showJustOwned);
    }

    /**
     * Delete the organizer from the database
     *
     * @param int $organizerId
     */
    public function deleteOrganizer(int $organizerId): void
    {
        $this->organizerRepository->delete($organizerId);
    }

    /**
     * Get the number of organizer created in the last 30 days.
     *
     * @return int
     */
    public function getNumberOrganizersCreatedLastThirtyDays(): int
    {
        return Organizer::whereDate('created_at', '>', date('Y-m-d', strtotime('-30 days')))->count();
    }
}
