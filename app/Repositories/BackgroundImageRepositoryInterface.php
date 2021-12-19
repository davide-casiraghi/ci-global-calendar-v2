<?php

namespace App\Repositories;

use App\Models\BackgroundImage;

interface BackgroundImageRepositoryInterface
{
    /**
     * Get all BackgroundImages.
     *
     * @param  int|null  $recordsPerPage
     * @param  array|null  $searchParameters
     *
     * @return \App\Models\BackgroundImage[]|\Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Collection
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
     */
    public function store(array $data): BackgroundImage;

    /**
     * Update BackgroundImage
     *
     * @param  array  $data
     * @param  int  $id
     *
     * @return BackgroundImage
     */
    public function update(array $data, int $id): BackgroundImage;

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
     * @param  \App\Models\BackgroundImage  $backgroundImage
     * @param  array  $data
     *
     * @return \App\Models\BackgroundImage
     */
    public function assignDataAttributes(BackgroundImage $backgroundImage, array $data): BackgroundImage;
}