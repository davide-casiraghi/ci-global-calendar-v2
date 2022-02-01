<?php

namespace App\Repositories;

use App\Models\HomepageMessage;
use Illuminate\Support\Collection;

interface HomepageMessageRepositoryInterface
{
    /**
     * Get all PostCategories.
     *
     * @return Collection
     */
    public function getAll(): Collection;

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