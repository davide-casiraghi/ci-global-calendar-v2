<?php

namespace App\Services;

use App\Http\Requests\RegionStoreRequest;
use App\Models\Region;
use App\Repositories\RegionRepositoryInterface;
use Illuminate\Support\Collection;

class RegionService
{
    private RegionRepositoryInterface $regionRepository;

    /**
     * RegionService constructor.
     *
     * @param  RegionRepositoryInterface  $regionRepository
     */
    public function __construct(
        RegionRepositoryInterface $regionRepository
    ) {
        $this->regionRepository = $regionRepository;
    }

    /**
     * Create a region
     *
     * @param  RegionStoreRequest  $request
     *
     * @return Region
     */
    public function createRegion(RegionStoreRequest $request): Region
    {
        return $this->regionRepository->store($request->all());
    }

    /**
     * Update the region
     *
     * @param  RegionStoreRequest  $request
     * @param int $regionId
     *
     * @return Region
     */
    public function updateRegion(RegionStoreRequest $request, int $regionId): Region
    {
        return $this->regionRepository->update($request->all(), $regionId);
    }

    /**
     * Return the region from the database
     *
     * @param int $regionId
     *
     * @return Region
     */
    public function getById(int $regionId): Region
    {
        return $this->regionRepository->getById($regionId);
    }

    /**
     * Get all the regions
     *
     * @param  int|null  $recordsPerPage
     * @param  array|null  $searchParameters
     * @return Collection
     */
    public function getRegions(int $recordsPerPage = null, array $searchParameters = null): Collection
    {
        return $this->regionRepository->getAll($recordsPerPage, $searchParameters);
    }

    /**
     * Get all the regions with active events.
     *
     * @param  int|null  $countryId
     * @return Collection
     */
    public function getRegionsWithActiveEvents(int $countryId = null): Collection
    {
        return $this->regionRepository->getRegionsWithActiveEvents($countryId);
    }

    /**
     * Delete the region from the database
     *
     * @param int $regionId
     */
    public function deleteRegion(int $regionId): void
    {
        $this->regionRepository->delete($regionId);
    }
}
