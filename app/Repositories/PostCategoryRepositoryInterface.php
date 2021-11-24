<?php

namespace App\Repositories;

use App\Models\PostCategory;
use Illuminate\Support\Collection;

interface PostCategoryRepositoryInterface
{

    /**
     * Get all PostCategories.
     *
     * @return Collection
     */
    public function getAll(): Collection;

    /**
     * Get PostCategory by id
     *
     * @param int $id
     *
     * @return PostCategory
     */
    public function getById(int $id): PostCategory;

    /**
     * Store PostCategory
     *
     * @param array $data
     *
     * @return PostCategory
     */
    public function store(array $data): PostCategory;

    /**
     * Update PostCategory
     *
     * @param array $data
     * @param int $id
     *
     * @return PostCategory
     */
    public function update(array $data, int $id): PostCategory;

    /**
     * Delete PostCategory
     *
     * @param int $id
     *
     * @return void
     */
    public function delete(int $id): void;

}