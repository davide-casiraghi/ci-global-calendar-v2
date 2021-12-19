<?php

namespace App\Repositories;

use App\Models\BackgroundImage;

class BackgroundImageRepository implements BackgroundImageRepositoryInterface
{

    /**
     * Get all BackgroundImages.
     *
     * @param int|null $recordsPerPage
     * @param array|null $searchParameters
     *
     * @return \App\Models\BackgroundImage[]|\Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Collection
     */
    public function getAll(int $recordsPerPage = null, array $searchParameters = null)
    {
        $query = BackgroundImage::orderBy('title', 'desc');

        if (!is_null($searchParameters)) {
            if (!empty($searchParameters['title'])) {
                $query->where(
                    'title',
                    'like',
                    '%' . $searchParameters['title'] . '%'
                );
            }
            if (!empty($searchParameters['photographer'])) {
                $query->where(
                    'photographer',
                    'like',
                    '%' . $searchParameters['photographer'] . '%'
                );
            }
            if (!empty($searchParameters['orientation'])) {
                $query->where('orientation', $searchParameters['orientation']);
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
     * Get BackgroundImage by id
     *
     * @param int $id
     *
     * @return BackgroundImage
     */
    public function getById(int $id): BackgroundImage
    {
        return BackgroundImage::findOrFail($id);
    }

    /**
     * Store BackgroundImage
     *
     * @param array $data
     *
     * @return BackgroundImage
     */
    public function store(array $data): BackgroundImage
    {
        $backgroundImage = new BackgroundImage();
        $backgroundImage = self::assignDataAttributes($backgroundImage, $data);

        $backgroundImage->save();
        $backgroundImage->setStatus('published');

        return $backgroundImage->fresh();
    }

    /**
     * Update BackgroundImage
     *
     * @param array $data
     * @param int $id
     *
     * @return BackgroundImage
     */
    public function update(array $data, int $id): BackgroundImage
    {
        $backgroundImage = $this->getById($id);
        $backgroundImage = self::assignDataAttributes($backgroundImage, $data);

        $status = (isset($data['status'])) ? 'published' : 'unpublished';
        if ($backgroundImage->publishingStatus() != $status) {
            $backgroundImage->setStatus($status);
        }

        $backgroundImage->update();

        return $backgroundImage;
    }

    /**
     * Delete BackgroundImage
     *
     * @param int $id
     * @return void
     */
    public function delete(int $id): void
    {
        BackgroundImage::destroy($id);
    }

    /**
     * Assign the attributes of the data array to the object
     *
     * @param \App\Models\BackgroundImage $backgroundImage
     * @param array $data
     *
     * @return \App\Models\BackgroundImage
     */
    public function assignDataAttributes(BackgroundImage $backgroundImage, array $data): BackgroundImage
    {
        $backgroundImage->title = $data['title'] ?? null;
        $backgroundImage->photographer = $data['photographer'];
        $backgroundImage->description = $data['description'];
        $backgroundImage->orientation = $data['orientation'];

        return $backgroundImage;
    }
}
