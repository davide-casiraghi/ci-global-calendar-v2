<?php

namespace App\Services;

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
            'financial' => [
                'label' => __('donations.donation_kind_financial'),
                'id' => 'offerFinancial',
                'icon' => '<svg class="flex-shrink-0 h-6 w-6 text-gray-600 block m-auto" x-description="Heroicon name: outline/cursor-click" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 512 512" stroke="currentColor" aria-hidden="true">
                                <path fill="currentColor" d="M551.9 312c-31.1-26.4-69.3-16.1-88.4-1.8l-60.4 45.5h-3.3c-.2-38-30.5-67.8-69.2-67.8h-144c-28.4 0-56.3 9.4-78.5 26.3L79.8 336H16c-8.8 0-16 7.2-16 16v16c0 8.8 7.2 16 16 16h80l41.3-31.5c14-10.7 31.4-16.5 49.4-16.5h144c27.9 0 29.1 40.2-1.1 40.2h-59.8c-7.6 0-13.8 6.2-13.8 13.8v.1c0 7.6 6.2 13.8 13.8 13.8h134.5c9.7 0 19.2-3.2 26.9-9l61.3-46.1c8.3-6.2 20.5-6.7 28.4 0 10.1 8.5 9.3 23.1-.9 30.7L419.4 455c-7.8 5.8-17.2 9-26.9 9H16c-8.8 0-16 7.2-16 16v16c0 8.8 7.2 16 16 16h376.8c19.9 0 39.3-6.5 55.2-18.5l100.8-75.9c16.6-12.5 26.5-31.5 27.1-52 .7-20.5-8.1-40.1-24-53.6zM257.6 144.3l50.1 14.3c3.6 1 6.1 4.4 6.1 8.1 0 4.6-3.8 8.4-8.4 8.4h-32.8c-3.6 0-7.1-.8-10.3-2.2-4.8-2.2-10.4-1.7-14.1 2l-17.5 17.5c-5.3 5.3-4.7 14.3 1.5 18.4 9.5 6.3 20.4 10.1 31.8 11.5V240c0 8.8 7.2 16 16 16h16c8.8 0 16-7.2 16-16v-17.6c30.3-3.6 53.4-31 49.3-63-2.9-23-20.7-41.3-42.9-47.7l-50.1-14.3c-3.6-1-6.1-4.4-6.1-8.1 0-4.6 3.8-8.4 8.4-8.4h32.8c3.6 0 7.1.8 10.3 2.2 4.8 2.2 10.4 1.7 14.1-2l17.5-17.5c5.3-5.3 4.7-14.3-1.5-18.4-9.5-6.3-20.4-10.1-31.8-11.5V16c0-8.8-7.2-16-16-16h-16c-8.8 0-16 7.2-16 16v17.6c-30.3 3.6-53.4 31-49.3 63 2.9 23 20.6 41.3 42.9 47.7z"></path>
                            </svg>',

            ],
            'free_entrance' => [
                'label' => __('donations.donation_kind_free_entrance'),
                'id' => 'offerFreeEntrance',
                'icon' => '<svg class="flex-shrink-0 h-6 w-6 text-gray-600 block m-auto" aria-hidden="true" focusable="false" data-prefix="far" data-icon="ticket-alt" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                                <path fill="currentColor" d="M400 208v96H176v-96h224m24-48H152c-13.255 0-24 10.745-24 24v144c0 13.255 10.745 24 24 24h272c13.255 0 24-10.745 24-24V184c0-13.255-10.745-24-24-24zm144 56h8V112c0-26.51-21.49-48-48-48H48C21.49 64 0 85.49 0 112v104h8c22.091 0 40 17.909 40 40s-17.909 40-40 40H0v104c0 26.51 21.49 48 48 48h480c26.51 0 48-21.49 48-48V296h-8c-22.091 0-40-17.909-40-40s17.909-40 40-40zm-40-38.372c-28.47 14.59-48 44.243-48 78.372s19.53 63.782 48 78.372V400H48v-65.628c28.471-14.59 48-44.243 48-78.372s-19.529-63.782-48-78.372V112h480v65.628z" class=""></path>
                            </svg>',
            ],
            'volunteer' => [
                'label' => __('donations.donation_kind_volunteer'),
                'id' => 'offerVolunteer',
                'icon' => '<svg class="flex-shrink-0 h-6 w-6 text-gray-600 block m-auto" x-description="Heroicon name: outline/cursor-click" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 512 512" stroke="currentColor" aria-hidden="true">
                                <path fill="currentColor" d="M637.9 203.9l-8-13.9c-4.4-7.7-14.2-10.3-21.9-5.9l-96.7 56.4c-3.7-27.4-26.9-48.6-55.3-48.6H304v64c0 17.6-14.3 32-32 32s-32-14.4-32-32v-86.3c0-11 5.7-21.3 15-27.1l33.4-20.9c10.2-6.4 21.9-9.7 33.9-9.7h105.3l119.8-68.2c7.7-4.4 10.4-14.1 6-21.8L545.5 8c-4.4-7.7-14.1-10.4-21.8-6L415 64h-92.7c-21 0-41.5 5.9-59.3 17l-33.5 20.9c-18.3 11.4-30.6 29.4-35.2 49.8l-59.4 35.6C110.8 201.8 96 227.9 96 256.1v34.1L8 341c-7.7 4.4-10.3 14.2-5.9 21.9l8 13.9c4.4 7.7 14.2 10.3 21.9 5.9L144 318v-61.8c0-11.3 5.9-21.8 15.6-27.6L192 209v42.2c0 41.8 30 80.1 71.7 84.3 47.9 4.9 88.3-32.7 88.3-79.6v-16h104c4.4 0 8 3.6 8 8v32c0 4.4-3.6 8-8 8h-32v60c0 15.4-12.5 27.8-27.8 27.8h-24.1v24c0 17.8-14.4 32.2-32.2 32.2H211.3l-62.8 36.3c-7.7 4.4-10.3 14.2-5.9 21.9l8 13.9c4.4 7.7 14.2 10.3 21.9 5.9l51.6-29.9h115.8c36.9 0 68.1-25.1 77.4-59.2 31.5-9.2 54.7-38.4 54.7-72.8v-14.3c17.6-5.3 31.5-19 37.1-36.4L632 225.8c7.7-4.5 10.3-14.2 5.9-21.9z" class=""></path>
                            </svg>',
            ],
            'other_gift' => [
                'label' => __('donations.donation_kind_other_gift'),
                'id' => 'offerOtherGift',
                'icon' => '<svg class="flex-shrink-0 h-6 w-6 text-gray-600 block m-auto" x-description="Heroicon name: outline/cursor-click" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 512 512" stroke="currentColor" aria-hidden="true">
                                <path fill="currentColor" d="M464 144h-26.1c6.2-12.1 10.1-25.5 10.1-40 0-48.5-39.5-88-88-88-41.6 0-68.5 21.3-103 68.3-34.5-47-61.4-68.3-103-68.3-48.5 0-88 39.5-88 88 0 14.5 3.8 27.9 10.1 40H48c-26.5 0-48 21.5-48 48v128c0 8.8 7.2 16 16 16h16v107.4c0 29 23.6 52.6 52.6 52.6h342.8c29 0 52.6-23.6 52.6-52.6V336h16c8.8 0 16-7.2 16-16V192c0-26.5-21.5-48-48-48zM232 448H84.6c-2.5 0-4.6-2-4.6-4.6V336h112v-48H48v-96h184v256zm-78.1-304c-22.1 0-40-17.9-40-40s17.9-40 40-40c22 0 37.5 7.6 84.1 77l2 3h-86.1zm122-3C322.5 71.6 338 64 360 64c22.1 0 40 17.9 40 40s-17.9 40-40 40h-86.1l2-3zM464 288H320v48h112v107.4c0 2.5-2 4.6-4.6 4.6H280V192h184v96z" class=""></path>
                            </svg>',
            ],
        ];
    }

}
