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
     * @param  int  $id
     * @return PostCategory
     */
    public function getById(int $id): PostCategory;

    /**
     * Get PostCategory by name
     *
     * @param  string  $postCategoryName
     *
     * @return int
     */
    public function getCategoryIdByName(string $postCategoryName): int;

    /**
     * Store PostCategory
     *
     * @param  array  $data
     * @return PostCategory
     */
    public function store(array $data): PostCategory;

    /**
     * Update PostCategory
     *
     * @param  array  $data
     * @param  PostCategory  $postCategory
     * @return PostCategory
     */
    public function update(array $data, PostCategory $postCategory): PostCategory;

    /**
     * Delete PostCategory
     *
     * @param  int  $id
     * @return void
     */
    public function delete(int $id): void;
}