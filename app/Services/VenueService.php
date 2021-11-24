<?php
namespace App\Services;

use App\Helpers\Helper;
use App\Helpers\ImageHelpers;
use App\Http\Requests\VenueSearchRequest;
use App\Http\Requests\VenueStoreRequest;
use App\Models\Venue;
use App\Repositories\VenueRepository;
use Illuminate\Support\Collection;

class VenueService
{
    private VenueRepository $venueRepository;

    /**
     * VenueService constructor.
     *
     * @param \App\Repositories\VenueRepository $venueRepository
     */
    public function __construct(
        VenueRepository $venueRepository
    ) {
        $this->venueRepository = $venueRepository;
    }

    /**
     * Create a venue
     *
     * @param \App\Http\Requests\VenueStoreRequest $request
     *
     * @return \App\Models\Venue
     * @throws \Spatie\ModelStatus\Exceptions\InvalidStatus
     */
    public function createVenue(VenueStoreRequest $request): Venue
    {
        $venue = $this->venueRepository->store($request->all());
        ImageHelpers::storeImages($venue, $request, 'introimage');

        return $venue;
    }

    /**
     * Update the Venue
     *
     * @param \App\Http\Requests\VenueStoreRequest $request
     * @param int $venueId
     *
     * @return \App\Models\Venue
     */
    public function updateVenue(VenueStoreRequest $request, int $venueId): Venue
    {
        $venue = $this->venueRepository->update($request->all(), $venueId);

        ImageHelpers::storeImages($venue, $request, 'introimage');
        ImageHelpers::deleteImages($venue, $request, 'introimage');

        return $venue;
    }

    /**
     * Return the venue from the database
     *
     * @param int $venueId
     *
     * @return \App\Models\Venue
     */
    public function getById(int $venueId): Venue
    {
        return $this->venueRepository->getById($venueId);
    }

    /**
     * Get all the Venues.
     *
     * @param int|null $recordsPerPage
     * @param array|null $searchParameters
     *
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getVenues(int $recordsPerPage = null, array $searchParameters = null)
    {
        return $this->venueRepository->getAll($recordsPerPage, $searchParameters);
    }

    /**
     * Delete the venue from the database
     *
     * @param int $venueId
     */
    public function deleteVenue(int $venueId): void
    {
        $this->venueRepository->delete($venueId);
    }

    /**
     * Get the number of venue created in the last 30 days.
     *
     * @return int
     */
    public function getNumberVenuesCreatedLastThirtyDays(): int
    {
        return Venue::whereDate('created_at', '>', date('Y-m-d', strtotime('-30 days')))->count();
    }

    /**
     * Return the GPS coordinates of the venue
     * https://developer.mapquest.com/.
     *
     * @param  string $address
     * @return array $ret
     */
    public static function getVenueGpsCoordinates(string $address): array
    {
        $address = Helper::cleanString($address);
        $key = 'Ad5KVnAISxX6aHyj6fAnHcKeh30n4W60';
        $url = 'https://www.mapquestapi.com/geocoding/v1/address?key=' . $key . '&location=' . $address;
        $response = @file_get_contents($url);

        if (! $response) {
            $url = 'http://open.mapquestapi.com/geocoding/v1/address?key=' . $key . '&location=' . $address;
            $response = @file_get_contents($url);
        }

        $response = json_decode($response, true);

        $ret = [];
        $ret['lat'] = $response['results'][0]['locations'][0]['latLng']['lat'];
        $ret['lng'] = $response['results'][0]['locations'][0]['latLng']['lng'];

        return $ret;
    }

}
