<?php

namespace App\Repositories;

use App\Models\HomepageMessage;
use Illuminate\Support\Collection;

class HomepageMessageRepository implements HomepageMessageRepositoryInterface
{

    /**
     * Get all DonationOffers.
     *
     * @param int|null $recordsPerPage
     * @param array|null $searchParameters
     *
     * @return HomepageMessage[]|\Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Collection
     */
    public function getAll(int $recordsPerPage = null, array $searchParameters = null)
    {
        $query = HomepageMessage::orderBy('created_at', 'desc');

        if (!is_null($searchParameters)) {
            if (!empty($searchParameters['title'])) {
                $query->where(
                    'title',
                    'like',
                    '%' . $searchParameters['title'] . '%'
                );
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
     * Get HomepageMessage by id
     *
     * @param int $id
     * @return HomepageMessage
     */
    public function getById(int $id): HomepageMessage
    {
        return HomepageMessage::findOrFail($id);
    }

    /**
     * Store HomepageMessage
     *
     * @param array $data
     * @return HomepageMessage
     */
    public function store(array $data): HomepageMessage
    {
        $homepageMessage = new HomepageMessage();
        $homepageMessage = self::assignDataAttributes($homepageMessage, $data);

        $homepageMessage->save();

        return $homepageMessage->fresh();
    }

    /**
     * Update HomepageMessage
     *
     * @param  array  $data
     * @param  HomepageMessage  $homepageMessage
     * @return HomepageMessage
     */
    public function update(array $data, HomepageMessage $homepageMessage): HomepageMessage
    {
        $homepageMessage = self::assignDataAttributes($homepageMessage, $data);

        $homepageMessage->update();

        return $homepageMessage;
    }

    /**
     * Delete HomepageMessage
     *
     * @param int $id
     * @return void
     */
    public function delete(int $id): void
    {
        HomepageMessage::destroy($id);
    }

    /**
     * Assign the attributes of the data array to the object
     *
     * @param  HomepageMessage  $homepageMessage
     * @param array $data
     *
     * @return HomepageMessage
     */
    public function assignDataAttributes(HomepageMessage $homepageMessage, array $data): HomepageMessage
    {
        $homepageMessage->title = $data['title'];
        $homepageMessage->body = $data['body'];
        $homepageMessage->color = $data['color'] ?? null;

        return $homepageMessage;
    }
}
