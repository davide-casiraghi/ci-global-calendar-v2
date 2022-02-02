<?php

namespace App\Repositories;

use App\Models\HomepageMessage;
use Spatie\ModelStatus\Exceptions\InvalidStatus;

class HomepageMessageRepository implements HomepageMessageRepositoryInterface
{
    /**
     * Get all HomepageMessages.
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
     * Get HomepageMessage by id.
     *
     * @param int $id
     * @return HomepageMessage
     */
    public function getById(int $id): HomepageMessage
    {
        return HomepageMessage::findOrFail($id);
    }

    /**
     * Store HomepageMessage.
     *
     * @param  array  $data
     * @return HomepageMessage
     * @throws InvalidStatus
     */
    public function store(array $data): HomepageMessage
    {
        $homepageMessage = new HomepageMessage();
        $homepageMessage = self::assignDataAttributes($homepageMessage, $data);

        $homepageMessage->save();
        self::updatePublishingStatus($homepageMessage, $data);

        return $homepageMessage->fresh();
    }

    /**
     * Update HomepageMessage.
     *
     * @param  array  $data
     * @param  HomepageMessage  $homepageMessage
     * @return HomepageMessage
     * @throws InvalidStatus
     */
    public function update(array $data, HomepageMessage $homepageMessage): HomepageMessage
    {
        $homepageMessage = self::assignDataAttributes($homepageMessage, $data);

        $homepageMessage->update();
        self::updatePublishingStatus($homepageMessage, $data);

        return $homepageMessage;
    }

    /**
     * Delete HomepageMessage.
     *
     * @param int $id
     * @return void
     */
    public function delete(int $id): void
    {
        HomepageMessage::destroy($id);
    }

    /**
     * Assign the attributes of the data array to the object.
     *
     * @param  HomepageMessage  $homepageMessage
     * @param array $data
     *
     * @return HomepageMessage
     */
    public function assignDataAttributes(HomepageMessage $homepageMessage, array $data): HomepageMessage
    {
        $homepageMessage->title = $data['title'];
        $homepageMessage->show_title = (isset($data['show_title'])) ? 1 : 0;
        $homepageMessage->body = $data['body'];
        $homepageMessage->color = $data['color'] ?? null;

        return $homepageMessage;
    }

    /**
     * Update the publishing status.
     *
     * @param  HomepageMessage  $homepageMessage
     * @param  array  $data
     *
     * @return void
     * @throws InvalidStatus
     */
    public function updatePublishingStatus(HomepageMessage $homepageMessage, array $data): void
    {
        $status = (isset($data['status'])) ? 'published' : 'unpublished';

        // Un-publish all the other messages when one gets published
        if($status == 'published'){
            self::unpublishAllMessages();
        }

        if ($homepageMessage->publishingStatus() != $status) {
            $homepageMessage->setStatus($status);
        }
    }

    /**
     * Un-publish all the messages.
     *
     * @return void
     * @throws InvalidStatus
     */
    public function unpublishAllMessages(): void
    {
        $messages = HomepageMessage::all();
        foreach ($messages as $message) {
            $message->setStatus('unpublished');
        }
    }

    /**
     * Return the only published message.
     *
     * @return HomepageMessage|null
     */
    public function getThePublishedMessage(): ?HomepageMessage
    {
        return HomepageMessage::currentStatus('published')->first();
    }

}
