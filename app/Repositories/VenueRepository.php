<?php

namespace App\Repositories;

use App\Models\Venue;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class VenueRepository implements VenueRepositoryInterface
{

    /**
     * Get all EventCategories.
     *
     * @param  int|null  $recordsPerPage
     * @param  array|null
     * @param  bool  $showJustOwned
     * @return Collection|LengthAwarePaginator
     */
    public function getAll(int $recordsPerPage = null, array $searchParameters = null, bool $showJustOwned = false)
    {
        $query = Venue::with('country');

        if (!is_null($searchParameters)) {
            foreach ($searchParameters as $searchParameter => $value) {
                if (!empty($value)) {
                    if ($searchParameter == 'country_id') {
                        $query->where($searchParameter, $value);
                    } else {
                        $query->where('venues.'.$searchParameter, 'LIKE', '%'.$value.'%');
                    }
                }
            }
        }

        if ($showJustOwned) {
            $query->where('user_id', Auth::id());
        }

        $query->orderBy('venues.name', 'asc');

        if ($recordsPerPage) {
            $results = $query->paginate($recordsPerPage)->withQueryString();
        } else {
            $results = $query->get();
        }

        return $results;
    }

    /**
     * Get Venue by id
     *
     * @param int $id
     *
     * @return Venue
     */
    public function getById(int $id): Venue
    {
        return Venue::findOrFail($id);
    }

    /**
     * Store Venue
     *
     * @param array $data
     *
     * @return Venue
     */
    public function store(array $data): Venue
    {
        $venue = new Venue();
        $venue = self::assignDataAttributes($venue, $data);

        // Creator - Logged user id or 1 for factories
        $venue->user_id = !is_null(Auth::id()) ? Auth::id() : 1;

        $venue->save();

        return $venue->fresh();
    }

    /**
     * Update Venue
     *
     * @param  array  $data
     * @param  Venue  $venue
     * @return Venue
     */
    public function update(array $data, Venue $venue): Venue
    {
        $venue = self::assignDataAttributes($venue, $data);

        $venue->update();

        return $venue;
    }

    /**
     * Delete Venue
     *
     * @param int $id
     * @return void
     */
    public function delete(int $id): void
    {
        Venue::destroy($id);
    }

    /**
     * Assign the attributes of the data array to the object
     *
     * @param  Venue  $venue
     * @param array $data
     *
     * @return Venue
     */
    public function assignDataAttributes(Venue $venue, array $data): Venue
    {
        $venue->name = $data['name'];
        $venue->description = $data['description'] ?? null;
        $venue->website = $data['website'] ?? null;
        $venue->extra_info = $data['extra_info'] ?? null;
        $venue->address = $data['address'] ?? null;
        $venue->city = $data['city'] ?? null;
        $venue->state_province = $data['state_province'] ?? null;
        $venue->country_id = $data['country_id'] ?? null;
        $venue->region_id = $data['region_id'] ?? null;
        $venue->zip_code = $data['zip_code'] ?? null;
        $venue->lat = $data['lat'] ?? null;
        $venue->lng = $data['lng'] ?? null;

        return $venue;
    }
}
