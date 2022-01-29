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
     * Return the data for the donation kind menu.
     *
     * @return array
     */
    public function getDonationKindMenuData(): array
    {
        return [
            1 => [
                'label' => __('donations.donation_kind_financial'),
                'id' => 'offerFinancial',
                'icon' => '<svg class="flex-shrink-0 h-6 w-6 text-gray-600 block m-auto" x-description="Heroicon name: outline/cursor-click" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 512 512" stroke="currentColor" aria-hidden="true">
                                <path fill="currentColor" d="M551.9 312c-31.1-26.4-69.3-16.1-88.4-1.8l-60.4 45.5h-3.3c-.2-38-30.5-67.8-69.2-67.8h-144c-28.4 0-56.3 9.4-78.5 26.3L79.8 336H16c-8.8 0-16 7.2-16 16v16c0 8.8 7.2 16 16 16h80l41.3-31.5c14-10.7 31.4-16.5 49.4-16.5h144c27.9 0 29.1 40.2-1.1 40.2h-59.8c-7.6 0-13.8 6.2-13.8 13.8v.1c0 7.6 6.2 13.8 13.8 13.8h134.5c9.7 0 19.2-3.2 26.9-9l61.3-46.1c8.3-6.2 20.5-6.7 28.4 0 10.1 8.5 9.3 23.1-.9 30.7L419.4 455c-7.8 5.8-17.2 9-26.9 9H16c-8.8 0-16 7.2-16 16v16c0 8.8 7.2 16 16 16h376.8c19.9 0 39.3-6.5 55.2-18.5l100.8-75.9c16.6-12.5 26.5-31.5 27.1-52 .7-20.5-8.1-40.1-24-53.6zM257.6 144.3l50.1 14.3c3.6 1 6.1 4.4 6.1 8.1 0 4.6-3.8 8.4-8.4 8.4h-32.8c-3.6 0-7.1-.8-10.3-2.2-4.8-2.2-10.4-1.7-14.1 2l-17.5 17.5c-5.3 5.3-4.7 14.3 1.5 18.4 9.5 6.3 20.4 10.1 31.8 11.5V240c0 8.8 7.2 16 16 16h16c8.8 0 16-7.2 16-16v-17.6c30.3-3.6 53.4-31 49.3-63-2.9-23-20.7-41.3-42.9-47.7l-50.1-14.3c-3.6-1-6.1-4.4-6.1-8.1 0-4.6 3.8-8.4 8.4-8.4h32.8c3.6 0 7.1.8 10.3 2.2 4.8 2.2 10.4 1.7 14.1-2l17.5-17.5c5.3-5.3 4.7-14.3-1.5-18.4-9.5-6.3-20.4-10.1-31.8-11.5V16c0-8.8-7.2-16-16-16h-16c-8.8 0-16 7.2-16 16v17.6c-30.3 3.6-53.4 31-49.3 63 2.9 23 20.6 41.3 42.9 47.7z"></path>
                            </svg>',

            ],
            2 => [
                'label' => __('donations.donation_kind_free_entrance'),
                'id' => 'offerFreeEntrance',
                'icon' => '<svg class="flex-shrink-0 h-6 w-6 text-gray-600 block m-auto" x-description="Heroicon name: outline/cursor-click" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 512 512" stroke="currentColor" aria-hidden="true">
                                <path fill="currentColor" d="M551.9 312c-31.1-26.4-69.3-16.1-88.4-1.8l-60.4 45.5h-3.3c-.2-38-30.5-67.8-69.2-67.8h-144c-28.4 0-56.3 9.4-78.5 26.3L79.8 336H16c-8.8 0-16 7.2-16 16v16c0 8.8 7.2 16 16 16h80l41.3-31.5c14-10.7 31.4-16.5 49.4-16.5h144c27.9 0 29.1 40.2-1.1 40.2h-59.8c-7.6 0-13.8 6.2-13.8 13.8v.1c0 7.6 6.2 13.8 13.8 13.8h134.5c9.7 0 19.2-3.2 26.9-9l61.3-46.1c8.3-6.2 20.5-6.7 28.4 0 10.1 8.5 9.3 23.1-.9 30.7L419.4 455c-7.8 5.8-17.2 9-26.9 9H16c-8.8 0-16 7.2-16 16v16c0 8.8 7.2 16 16 16h376.8c19.9 0 39.3-6.5 55.2-18.5l100.8-75.9c16.6-12.5 26.5-31.5 27.1-52 .7-20.5-8.1-40.1-24-53.6zM257.6 144.3l50.1 14.3c3.6 1 6.1 4.4 6.1 8.1 0 4.6-3.8 8.4-8.4 8.4h-32.8c-3.6 0-7.1-.8-10.3-2.2-4.8-2.2-10.4-1.7-14.1 2l-17.5 17.5c-5.3 5.3-4.7 14.3 1.5 18.4 9.5 6.3 20.4 10.1 31.8 11.5V240c0 8.8 7.2 16 16 16h16c8.8 0 16-7.2 16-16v-17.6c30.3-3.6 53.4-31 49.3-63-2.9-23-20.7-41.3-42.9-47.7l-50.1-14.3c-3.6-1-6.1-4.4-6.1-8.1 0-4.6 3.8-8.4 8.4-8.4h32.8c3.6 0 7.1.8 10.3 2.2 4.8 2.2 10.4 1.7 14.1-2l17.5-17.5c5.3-5.3 4.7-14.3-1.5-18.4-9.5-6.3-20.4-10.1-31.8-11.5V16c0-8.8-7.2-16-16-16h-16c-8.8 0-16 7.2-16 16v17.6c-30.3 3.6-53.4 31-49.3 63 2.9 23 20.6 41.3 42.9 47.7z"></path>
                            </svg>',
            ],
            3 => [
                'label' => __('donations.donation_kind_volunteer'),
                'id' => 'offerVolunteer',
                'icon' => '<svg class="flex-shrink-0 h-6 w-6 text-gray-600 block m-auto" x-description="Heroicon name: outline/cursor-click" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 512 512" stroke="currentColor" aria-hidden="true">
                                <path fill="currentColor" d="M551.9 312c-31.1-26.4-69.3-16.1-88.4-1.8l-60.4 45.5h-3.3c-.2-38-30.5-67.8-69.2-67.8h-144c-28.4 0-56.3 9.4-78.5 26.3L79.8 336H16c-8.8 0-16 7.2-16 16v16c0 8.8 7.2 16 16 16h80l41.3-31.5c14-10.7 31.4-16.5 49.4-16.5h144c27.9 0 29.1 40.2-1.1 40.2h-59.8c-7.6 0-13.8 6.2-13.8 13.8v.1c0 7.6 6.2 13.8 13.8 13.8h134.5c9.7 0 19.2-3.2 26.9-9l61.3-46.1c8.3-6.2 20.5-6.7 28.4 0 10.1 8.5 9.3 23.1-.9 30.7L419.4 455c-7.8 5.8-17.2 9-26.9 9H16c-8.8 0-16 7.2-16 16v16c0 8.8 7.2 16 16 16h376.8c19.9 0 39.3-6.5 55.2-18.5l100.8-75.9c16.6-12.5 26.5-31.5 27.1-52 .7-20.5-8.1-40.1-24-53.6zM257.6 144.3l50.1 14.3c3.6 1 6.1 4.4 6.1 8.1 0 4.6-3.8 8.4-8.4 8.4h-32.8c-3.6 0-7.1-.8-10.3-2.2-4.8-2.2-10.4-1.7-14.1 2l-17.5 17.5c-5.3 5.3-4.7 14.3 1.5 18.4 9.5 6.3 20.4 10.1 31.8 11.5V240c0 8.8 7.2 16 16 16h16c8.8 0 16-7.2 16-16v-17.6c30.3-3.6 53.4-31 49.3-63-2.9-23-20.7-41.3-42.9-47.7l-50.1-14.3c-3.6-1-6.1-4.4-6.1-8.1 0-4.6 3.8-8.4 8.4-8.4h32.8c3.6 0 7.1.8 10.3 2.2 4.8 2.2 10.4 1.7 14.1-2l17.5-17.5c5.3-5.3 4.7-14.3-1.5-18.4-9.5-6.3-20.4-10.1-31.8-11.5V16c0-8.8-7.2-16-16-16h-16c-8.8 0-16 7.2-16 16v17.6c-30.3 3.6-53.4 31-49.3 63 2.9 23 20.6 41.3 42.9 47.7z"></path>
                            </svg>',
            ],
            4 => [
                'label' => __('donations.donation_kind_other_gift'),
                'id' => 'offerOtherGift',
                'icon' => '<svg class="flex-shrink-0 h-6 w-6 text-gray-600 block m-auto" x-description="Heroicon name: outline/cursor-click" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 512 512" stroke="currentColor" aria-hidden="true">
                                <path fill="currentColor" d="M551.9 312c-31.1-26.4-69.3-16.1-88.4-1.8l-60.4 45.5h-3.3c-.2-38-30.5-67.8-69.2-67.8h-144c-28.4 0-56.3 9.4-78.5 26.3L79.8 336H16c-8.8 0-16 7.2-16 16v16c0 8.8 7.2 16 16 16h80l41.3-31.5c14-10.7 31.4-16.5 49.4-16.5h144c27.9 0 29.1 40.2-1.1 40.2h-59.8c-7.6 0-13.8 6.2-13.8 13.8v.1c0 7.6 6.2 13.8 13.8 13.8h134.5c9.7 0 19.2-3.2 26.9-9l61.3-46.1c8.3-6.2 20.5-6.7 28.4 0 10.1 8.5 9.3 23.1-.9 30.7L419.4 455c-7.8 5.8-17.2 9-26.9 9H16c-8.8 0-16 7.2-16 16v16c0 8.8 7.2 16 16 16h376.8c19.9 0 39.3-6.5 55.2-18.5l100.8-75.9c16.6-12.5 26.5-31.5 27.1-52 .7-20.5-8.1-40.1-24-53.6zM257.6 144.3l50.1 14.3c3.6 1 6.1 4.4 6.1 8.1 0 4.6-3.8 8.4-8.4 8.4h-32.8c-3.6 0-7.1-.8-10.3-2.2-4.8-2.2-10.4-1.7-14.1 2l-17.5 17.5c-5.3 5.3-4.7 14.3 1.5 18.4 9.5 6.3 20.4 10.1 31.8 11.5V240c0 8.8 7.2 16 16 16h16c8.8 0 16-7.2 16-16v-17.6c30.3-3.6 53.4-31 49.3-63-2.9-23-20.7-41.3-42.9-47.7l-50.1-14.3c-3.6-1-6.1-4.4-6.1-8.1 0-4.6 3.8-8.4 8.4-8.4h32.8c3.6 0 7.1.8 10.3 2.2 4.8 2.2 10.4 1.7 14.1-2l17.5-17.5c5.3-5.3 4.7-14.3-1.5-18.4-9.5-6.3-20.4-10.1-31.8-11.5V16c0-8.8-7.2-16-16-16h-16c-8.8 0-16 7.2-16 16v17.6c-30.3 3.6-53.4 31-49.3 63 2.9 23 20.6 41.3 42.9 47.7z"></path>
                            </svg>',
            ],
        ];
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
