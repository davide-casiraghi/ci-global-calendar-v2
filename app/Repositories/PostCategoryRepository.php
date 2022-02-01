<?php


namespace App\Repositories;

use App\Models\PostCategory;
use Illuminate\Support\Collection;

class PostCategoryRepository implements PostCategoryRepositoryInterface
{

    /**
     * Get all PostCategories.
     *
     * @return Collection
     */
    public function getAll(): Collection
    {
        return PostCategory::orderBy('name')->get();
    }

    /**
     * Get PostCategory by id
     *
     * @param int $id
     * @return PostCategory
     */
    public function getById(int $id): PostCategory
    {
        return PostCategory::findOrFail($id);
    }

    /**
     * Get PostCategory by name
     *
     * @param  string  $postCategoryName
     *
     * @return int
     */
    public function getCategoryIdByName(string $postCategoryName): int
    {
        return PostCategory::where('name', 'like', '%' . $postCategoryName . '%')->first()->id;
    }

    /**
     * Store PostCategory
     *
     * @param array $data
     * @return PostCategory
     */
    public function store(array $data): PostCategory
    {
        $postCategory = new PostCategory();
        $postCategory->name = $data['name'];

        $postCategory->save();

        return $postCategory->fresh();
    }

    /**
     * Update PostCategory
     *
     * @param  array  $data
     * @param  PostCategory  $postCategory
     * @return PostCategory
     */
    public function update(array $data, PostCategory $postCategory): PostCategory
    {
        $postCategory->name = $data['name'];

        $postCategory->update();

        return $postCategory;
    }

    /**
     * Delete PostCategory
     *
     * @param int $id
     * @return void
     */
    public function delete(int $id): void
    {
        PostCategory::destroy($id);
    }
}
