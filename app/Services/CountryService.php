<?php

namespace App\Services;

use App\Http\Requests\CountryStoreRequest;
use App\Models\Country;
use App\Repositories\CountryRepositoryInterface;
use Illuminate\Support\Collection;

class CountryService
{
    private CountryRepositoryInterface $countryRepository;

    /**
     * CountryService constructor.
     *
     * @param  CountryRepositoryInterface  $countryRepository
     */
    public function __construct(
        CountryRepositoryInterface $countryRepository
    ) {
        $this->countryRepository = $countryRepository;
    }

    /**
     * Create a country
     *
     * @param  CountryStoreRequest  $request
     *
     * @return Country
     */
    public function createCountry(CountryStoreRequest $request): Country
    {
        return $this->countryRepository->store($request->all());
    }

    /**
     * Update the country
     *
     * @param  CountryStoreRequest  $request
     * @param int $countryId
     *
     * @return Country
     */
    public function updateCountry(CountryStoreRequest $request, int $countryId): Country
    {
        return $this->countryRepository->update($request->all(), $countryId);
    }

    /**
     * Return the country from the database
     *
     * @param int $countryId
     *
     * @return Country
     */
    public function getById(int $countryId): Country
    {
        return $this->countryRepository->getById($countryId);
    }

    /**
     * Get all the countries
     *
     * @param  int|null  $recordsPerPage
     * @param  array|null  $searchParameters
     * @return Collection
     */
    public function getCountries(int $recordsPerPage = null, array $searchParameters = null): Collection
    {
        return $this->countryRepository->getAll($recordsPerPage, $searchParameters);
    }

    /**
     * Get all the countries with active events.
     *
     * @param  int|null  $continentId
     * @return Collection
     */
    public function getCountriesWithActiveEvents(int $continentId = null): Collection
    {
        return $this->countryRepository->getCountriesWithActiveEvents($continentId);
    }

    /**
     * Delete the country from the database
     *
     * @param int $countryId
     */
    public function deleteCountry(int $countryId): void
    {
        $this->countryRepository->delete($countryId);
    }
}
