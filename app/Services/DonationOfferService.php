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

    /**
     * Return the possible gift kinds.
     * They are encoded as collection of objects to be used in
     * the select blade partial that accept a collection of object
     * as record attribute.
     *
     * @return Collection
     */
    public function getGiftKinds(): Collection
    {
        return collect([
            (object)['id'=> 1, 'name'=> __('donations.gift_kind_free_festival')],
            (object)['id'=> 2, 'name'=> __('donations.gift_kind_free_other')],
        ]);
    }

    /**
     * Return the possible volunteer kinds.
     * They are encoded as collection of objects to be used in
     * the select blade partial that accept a collection of object
     * as record attribute.
     *
     * @return Collection
     */
    public function getVolunteerKinds(): Collection
    {
        return collect([
            (object)['id'=> 1, 'name'=> __('donations.volunteering_kind_developer')],
            (object)['id'=> 2, 'name'=> __('donations.volunteering_kind_fundriser')],
            (object)['id'=> 3, 'name'=> __('donations.volunteering_kind_translator')],
            (object)['id'=> 4, 'name'=> __('donations.volunteering_kind_communicator')],
            (object)['id'=> 5, 'name'=> __('donations.volunteering_kind_other')],
        ]);
    }

}
