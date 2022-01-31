<?php

namespace App\Services;

use App\Http\Requests\CountryStoreRequest;
use App\Models\Country;
use App\Repositories\CountryRepository;
use Illuminate\Support\Collection;

class CountryService
{
    private CountryRepository $countryRepository;

    /**
     * CountryService constructor.
     *
     * @param  CountryRepository  $countryRepository
     */
    public function __construct(
        CountryRepository $countryRepository
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
     * @return Collection
     */
    public function getCountries(): Collection
    {
        return $this->countryRepository->getAll();
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
