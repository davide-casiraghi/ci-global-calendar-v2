<?php

namespace App\Repositories;

use App\Models\BackgroundImage;
use Spatie\ModelStatus\Exceptions\InvalidStatus;

interface BackgroundImageRepositoryInterface
{
    /**
     * Get all BackgroundImages.
     *
     * @param  int|null  $recordsPerPage
     * @param  array|null  $searchParameters
     *
     * @return BackgroundImage[]|\Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Collection
     */
    public function getAll(int $recordsPerPage = null, array $searchParameters = null);

    /**
     * Get BackgroundImage by id
     *
     * @param  int  $id
     *
     * @return BackgroundImage
     */
    public function getById(int $id): BackgroundImage;

    /**
     * Store BackgroundImage
     *
     * @param  array  $data
     *
     * @return BackgroundImage
     * @throws InvalidStatus
     */
    public function store(array $data): BackgroundImage;

    /**
     * Update BackgroundImage
     *
     * @param  array  $data
     * @param  BackgroundImage  $backgroundImage
     * @return BackgroundImage
     * @throws InvalidStatus
     */
    public function update(array $data, BackgroundImage $backgroundImage): BackgroundImage;

    /**
     * Delete BackgroundImage
     *
     * @param  int  $id
     * @return void
     */
    public function delete(int $id): void;

    /**
     * Assign the attributes of the data array to the object
     *
     * @param  BackgroundImage  $backgroundImage
     * @param  array  $data
     *
     * @return BackgroundImage
     */
    public function assignDataAttributes(BackgroundImage $backgroundImage, array $data): BackgroundImage;
}