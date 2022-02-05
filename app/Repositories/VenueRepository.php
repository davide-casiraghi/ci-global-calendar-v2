<?php

namespace App\Repositories;

use App\Models\Venue;
use Illuminate\Support\Facades\Auth;

class VenueRepository implements VenueRepositoryInterface
{

    /**
     * Get all EventCategories.
     *
     * @param int|null $recordsPerPage
     * @param array|null $searchParameters
     *
     * @return Venue[]|\Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Collection
     */
    public function getAll(int $recordsPerPage = null, array $searchParameters = null, bool $showJustOwned)
    {
        $query = Venue::orderBy('name', 'desc');

        foreach ($searchParameters as $searchParameter => $value) {
            if (!empty($value)) {
                if ($searchParameter == 'country_id') {
                    $query->where($searchParameter, $value);
                } else {
                    $query->where('venues.'.$searchParameter, 'LIKE', '%'.$value.'%');
                }
            }
        }

        if ($showJustOwned) {
            $query->where('user_id', Auth::id());
        }

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
        $venue->zip_code = $data['zip_code'] ?? null;
        $venue->lat = $data['lat'] ?? null;
        $venue->lng = $data['lng'] ?? null;

        return $venue;
    }
}
