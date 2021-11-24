<?php

namespace App\Services;

use App\Http\Requests\RegionStoreRequest;
use App\Models\Region;
use App\Repositories\RegionRepository;
use Illuminate\Support\Collection;

class RegionService
{
    private RegionRepository $regionRepository;

    /**
     * RegionService constructor.
     *
     * @param \App\Repositories\RegionRepository $regionRepository
     */
    public function __construct(
        RegionRepository $regionRepository
    ) {
        $this->regionRepository = $regionRepository;
    }

    /**
     * Create a region
     *
     * @param \App\Http\Requests\RegionStoreRequest $request
     *
     * @return \App\Models\Region
     */
    public function createRegion(RegionStoreRequest $request): Region
    {
        $region = $this->regionRepository->store($request->all());

        return $region;
    }

    /**
     * Update the region
     *
     * @param \App\Http\Requests\RegionStoreRequest $request
     * @param int $regionId
     *
     * @return \App\Models\Region
     */
    public function updateRegion(RegionStoreRequest $request, int $regionId): Region
    {
        $region = $this->regionRepository->update($request->all(), $regionId);

        return $region;
    }

    /**
     * Return the region from the database
     *
     * @param int $regionId
     *
     * @return \App\Models\Region
     */
    public function getById(int $regionId): Region
    {
        return $this->regionRepository->getById($regionId);
    }

    /**
     * Get all the regions
     *
     * @return \Illuminate\Support\Collection
     */
    public function getRegions(): Collection
    {
        return $this->regionRepository->getAll();
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
