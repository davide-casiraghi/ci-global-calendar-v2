<?php

namespace App\Repositories;

use App\Models\Region;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class RegionRepository implements RegionRepositoryInterface
{
    /**
     * Get all Regions.
     *
     * @param  int|null  $recordsPerPage
     * @param  array|null  $searchParameters
     * @return Collection
     */
    public function getAll(int $recordsPerPage = null, array $searchParameters = null): Collection
    {
        $query = Region::select([
            'regions.id',
            'regions.name',
            'countries.name as country_name',
        ])
            ->join('countries', 'regions.country_id', '=', 'countries.id');

        if (!is_null($searchParameters)) {
            foreach ($searchParameters as $searchParameter => $value) {
                if (!empty($value)) {
                    if ($searchParameter == 'country_id') {
                        $query->where($searchParameter, $value);
                    } else {
                        $query->where('regions.'.$searchParameter, 'LIKE', '%'.$value.'%');
                    }
                }
            }
        }

        $query->orderBy('name', 'asc');

        if ($recordsPerPage) {
            $results = $query->paginate($recordsPerPage)->withQueryString();
        } else {
            $results = $query->get();
        }

        return $results;
    }

    /**
     * Get Region by id
     *
     * @param int $id
     * @return Region
     */
    public function getById(int $id)
    {
        return Region::findOrFail($id);
    }

    /**
     * Store Region
     *
     * @param array $data
     * @return Region
     */
    public function store(array $data): Region
    {
        $region = new Region();
        $region = self::assignDataAttributes($region, $data);

        $region->save();

        return $region->fresh();
    }

    /**
     * Update Region
     *
     * @param array $data
     * @param int $id
     * @return Region
     */
    public function update(array $data, int $id): Region
    {
        $region = $this->getById($id);
        $region = self::assignDataAttributes($region, $data);

        $region->update();

        return $region;
    }

    /**
     * Delete Region
     *
     * @param int $id
     * @return void
     */
    public function delete(int $id): void
    {
        Region::destroy($id);
    }

    /**
     * Assign the attributes of the data array to the object
     *
     * @param  Region  $region
     * @param array $data
     *
     * @return Region
     */
    public function assignDataAttributes(Region $region, array $data): Region
    {
        $region->name = $data['name'];
        $region->timezone = $data['timezone'];
        $region->country_id = $data['country_id'];

        return $region;
    }

    /**
     * Get all regions with Active events.
     *
     * @param  int|null  $countryId
     * @return Collection
     */
    public function getRegionsWithActiveEvents(int $countryId = null): Collection
    {
        $query = Region::select(['regions.id', 'regions.name', 'events.id as event_id']) //@todo - if I remove events.id it doesn't work, it select all the regions of that country even without active events, why?
            ->join('countries', 'countries.id', '=', 'regions.country_id')
            ->join('venues', 'venues.country_id', '=', 'countries.id')
            ->join('events', 'events.venue_id', '=', 'venues.id')
            ->join('event_repetitions', 'events.id', '=', 'event_repetitions.event_id')
            ->where('event_repetitions.start_repeat', '>=', Carbon::today())
            ->where('is_published', true);

        if (!is_null($countryId)) {
            $query->where('regions.country_id', $countryId);
        }

        $query->orderBy('regions.name', 'asc');

        return $query->get()->unique('id');
    }
}
