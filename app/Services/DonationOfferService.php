<?php

namespace App\Services;

use App\Helpers\ImageHelpers;
use App\Http\Requests\DonationOfferStoreRequest;
use App\Models\DonationOffer;
use App\Repositories\DonationOfferRepositoryInterface;
use Illuminate\Support\Collection;

class DonationOfferService
{
    private DonationOfferRepositoryInterface $donationOfferRepository;

    /**
     * TestimonialService constructor.
     *
     * @param  DonationOfferRepositoryInterface  $donationOfferRepository
     */
    public function __construct(
        DonationOfferRepositoryInterface $donationOfferRepository
    ) {
        $this->donationOfferRepository = $donationOfferRepository;
    }

    /**
     * Create a DonationOffer
     *
     * @param  DonationOfferStoreRequest  $request
     *
     * @return DonationOffer
     * @throws \Spatie\ModelStatus\Exceptions\InvalidStatus
     */
    public function createDonationOffer(DonationOfferStoreRequest $request): DonationOffer
    {
        return $this->donationOfferRepository->store($request->all());
    }

    /**
     * Update the DonationOffer
     *
     * @param  DonationOfferStoreRequest  $request
     * @param  DonationOffer  $donationOffer
     * @return DonationOffer
     */
    public function updateDonationOffer(DonationOfferStoreRequest $request, DonationOffer $donationOffer): DonationOffer
    {
        return $this->donationOfferRepository->update($request->all(), $donationOffer);
    }

    /**
     * Return the DonationOffer from the database
     *
     * @param int $donationOfferId
     *
     * @return DonationOffer
     */
    public function getById(int $donationOfferId): DonationOffer
    {
        return $this->donationOfferRepository->getById($donationOfferId);
    }

    /**
     * Get all the DonationOffers.
     *
     * @param int|null $recordsPerPage
     * @param array|null $searchParameters
     *
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getDonationOffers(int $recordsPerPage = null, array $searchParameters = null)
    {
        return $this->donationOfferRepository->getAll($recordsPerPage, $searchParameters);
    }

    /**
     * Delete the DonationOffer from the database
     *
     * @param int $donationOfferId
     */
    public function deleteDonationOffer(int $donationOfferId): void
    {
        $this->donationOfferRepository->delete($donationOfferId);
    }

}
