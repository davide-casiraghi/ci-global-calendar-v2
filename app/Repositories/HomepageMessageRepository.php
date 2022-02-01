<?php


namespace App\Repositories;

use App\Models\HomepageMessage;
use Illuminate\Support\Collection;

class HomepageMessageRepository implements HomepageMessageRepositoryInterface
{

    /**
     * Get all PostCategories.
     *
     * @return Collection
     */
    public function getAll(): Collection
    {
        return HomepageMessage::orderBy('title')->get();
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
