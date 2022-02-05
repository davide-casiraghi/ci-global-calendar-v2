<?php

namespace App\Repositories;

use App\Models\BackgroundImage;
use Spatie\ModelStatus\Exceptions\InvalidStatus;

class BackgroundImageRepository implements BackgroundImageRepositoryInterface
{

    /**
     * Get all BackgroundImages.
     *
     * @param int|null $recordsPerPage
     * @param array|null $searchParameters
     *
     * @return BackgroundImage[]|\Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Collection
     */
    public function getAll(int $recordsPerPage = null, array $searchParameters = null)
    {
        $query = BackgroundImage::orderBy('title', 'desc');

        if (!is_null($searchParameters)) {
            foreach ($searchParameters as $searchParameter => $value) {
                if (!empty($value)) {
                    if ($searchParameter == 'orientation' || $searchParameter ==  'is_published') {
                        $query->where($searchParameter, $value);
                    } else {
                        $query->where('background_images.'.$searchParameter, 'LIKE', '%'.$value.'%');
                    }
                }
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
     * @param  array  $data
     *
     * @return BackgroundImage
     * @throws InvalidStatus
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
     * @param  array  $data
     * @param  BackgroundImage  $backgroundImage
     * @return BackgroundImage
     * @throws InvalidStatus
     */
    public function update(array $data, BackgroundImage $backgroundImage): BackgroundImage
    {
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
     * @param  BackgroundImage  $backgroundImage
     * @param array $data
     *
     * @return BackgroundImage
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
