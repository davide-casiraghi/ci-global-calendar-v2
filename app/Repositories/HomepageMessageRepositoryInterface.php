<?php

namespace App\Repositories;

use App\Models\HomepageMessage;

interface HomepageMessageRepositoryInterface
{
    /**
     * Get all DonationOffers.
     *
     * @param  int|null  $recordsPerPage
     * @param  array|null  $searchParameters
     *
     * @return HomepageMessage[]|\Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Collection
     */
    public function getAll(int $recordsPerPage = null, array $searchParameters = null);

    /**
     * Get HomepageMessage by id
     *
     * @param  int  $id
     * @return HomepageMessage
     */
    public function getById(int $id): HomepageMessage;

    /**
     * Store HomepageMessage
     *
     * @param  array  $data
     * @return HomepageMessage
     */
    public function store(array $data): HomepageMessage;

    /**
     * Update HomepageMessage
     *
     * @param  array  $data
     * @param  HomepageMessage  $homepageMessage
     * @return HomepageMessage
     */
    public function update(array $data, HomepageMessage $homepageMessage): HomepageMessage;

    /**
     * Delete HomepageMessage
     *
     * @param  int  $id
     * @return void
     */
    public function delete(int $id): void;

    /**
     * Assign the attributes of the data array to the object
     *
     * @param  HomepageMessage  $homepageMessage
     * @param  array  $data
     *
     * @return HomepageMessage
     */
    public function assignDataAttributes(HomepageMessage $homepageMessage, array $data): HomepageMessage;
}