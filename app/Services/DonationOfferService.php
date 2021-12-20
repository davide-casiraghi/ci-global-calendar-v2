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
     * @param \App\Http\Requests\DonationOfferStoreRequest $request
     *
     * @return \App\Models\DonationOffer
     * @throws \Spatie\ModelStatus\Exceptions\InvalidStatus
     */
    public function createDonationOffer(DonationOfferStoreRequest $request): DonationOffer
    {
        $donationOffer = $this->donationOfferRepository->store($request->all());

        return $donationOffer;
    }

    /**
     * Update the DonationOffer
     *
     * @param \App\Http\Requests\DonationOfferStoreRequest $request
     * @param int $donationOfferId
     *
     * @return \App\Models\DonationOffer
     */
    public function updateDonationOffer(DonationOfferStoreRequest $request, int $donationOfferId): DonationOffer
    {
        $donationOffer = $this->donationOfferRepository->update($request->all(), $donationOfferId);

        return $donationOffer;
    }

    /**
     * Return the DonationOffer from the database
     *
     * @param int $donationOfferId
     *
     * @return \App\Models\DonationOffer
     */
    public function getById(int $donationOfferId): DonationOffer
    {
        return $this->donationOfferRepository->getById($donationOfferId);
    }

    /**
     * Return the DonationOffer from the database
     *
     * @param  string  $donationOfferSlug
     * @return DonationOffer|null
     */
    public function getBySlug(string $donationOfferSlug): ?DonationOffer
    {
        return $this->donationOfferRepository->getBySlug($donationOfferSlug);
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
