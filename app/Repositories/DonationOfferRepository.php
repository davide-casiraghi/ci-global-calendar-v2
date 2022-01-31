<?php

namespace App\Repositories;

use App\Models\DonationOffer;

class DonationOfferRepository implements DonationOfferRepositoryInterface
{

    /**
     * Get all DonationOffers.
     *
     * @param int|null $recordsPerPage
     * @param array|null $searchParameters
     *
     * @return DonationOffer[]|\Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Collection
     */
    public function getAll(int $recordsPerPage = null, array $searchParameters = null)
    {
        $query = DonationOffer::orderBy('created_at', 'desc');

        if (!is_null($searchParameters)) {
            if (!empty($searchParameters['name'])) {
                $query->where(
                    'name',
                    'like',
                    '%' . $searchParameters['name'] . '%'
                );
            }
            if (!empty($searchParameters['surname'])) {
                $query->where(
                    'surname',
                    'like',
                    '%' . $searchParameters['surname'] . '%'
                );
            }
            if (!empty($searchParameters['countryId'])) {
                $query->where('country_id', $searchParameters['countryId']);
            }
            if (!empty($searchParameters['offerKind'])) {
                $query->where('offer_kind', $searchParameters['offerKind']);
            }
        }

        if ($recordsPerPage) {
            $results = $query->paginate($recordsPerPage)->withQueryString();
        } else {
            $results = $query->get();
        }

        return $results;
    }

    /**
     * Get DonationOffer by id
     *
     * @param int $id
     *
     * @return DonationOffer
     */
    public function getById(int $id): DonationOffer
    {
        return DonationOffer::findOrFail($id);
    }

    /**
     * Store DonationOffer
     *
     * @param array $data
     *
     * @return DonationOffer
     */
    public function store(array $data): DonationOffer
    {
        $donationOffer = new DonationOffer();
        $donationOffer = self::assignDataAttributes($donationOffer, $data);
        $donationOffer->save();

        return $donationOffer->fresh();
    }

    /**
     * Update DonationOffer
     *
     * @param  array  $data
     * @param  DonationOffer  $donationOffer
     * @return DonationOffer
     */
    public function update(array $data, DonationOffer $donationOffer): DonationOffer
    {
        $donationOffer = self::assignDataAttributes($donationOffer, $data);

        $donationOffer->update();

        return $donationOffer;
    }

    /**
     * Delete DonationOffer
     *
     * @param int $id
     * @return void
     */
    public function delete(int $id): void
    {
        DonationOffer::destroy($id);
    }

    /**
     * Assign the attributes of the data array to the object
     *
     * @param  DonationOffer  $donationOffer
     * @param array $data
     *
     * @return DonationOffer
     */
    public function assignDataAttributes(DonationOffer $donationOffer, array $data): DonationOffer
    {
        $donationOffer->user_id = $data['user_id'];  // created by
        $donationOffer->country_id = $data['country_id'] ?? null;
        $donationOffer->name = $data['name'] ?? null;
        $donationOffer->surname = $data['surname'] ?? null;
        $donationOffer->email = $data['email'] ?? null;
        $donationOffer->contact_trough_voip = $data['contact_trough_voip'] ?? null;
        $donationOffer->language_spoken = $data['language_spoken'] ?? null;
        $donationOffer->offer_kind = $data['offer_kind'];
        $donationOffer->gift_kind = $data['gift_kind'] ?? null;
        $donationOffer->gift_description = $data['gift_description'] ?? null;
        $donationOffer->volunteer_kind = $data['volunteer_kind'] ?? null;
        $donationOffer->volunteer_description = $data['volunteer_description'] ?? null;
        $donationOffer->other_description = $data['other_description'] ?? null;
        $donationOffer->suggestions = $data['suggestions'] ?? null;
        $donationOffer->gift_title = $data['gift_title'];
        $donationOffer->gift_donater = $data['gift_donater'] ?? null;
        $donationOffer->gift_economic_value = $data['gift_economic_value'] ?? null;
        $donationOffer->gift_volunteer_time_value = $data['gift_volunteer_time_value'] ?? null;
        $donationOffer->gift_given_to = $data['gift_given_to']?? null;
        $donationOffer->gift_given_when = $data['gift_given_when'] ?? null;
        $donationOffer->gift_country_of = $data['gift_country_of'] ?? null;
        $donationOffer->admin_notes = $data['admin_notes'] ?? null;

        return $donationOffer;
    }
}
