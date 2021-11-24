<?php

namespace App\Repositories;

use App\Models\Post;

interface PostRepositoryInterface
{

    /**
     * Get all Posts.
     *
     * @param int|null $recordsPerPage
     * @param array|null $searchParameters
     *
     * @return \Illuminate\Support\Collection|\Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getAll(
        int $recordsPerPage = null,
        array $searchParameters = null
    );

    /**
     * Get Post by id
     *
     * @param int $postId
     *
     * @return Post
     */
    public function getById(int $postId): Post;

    /**
     * Store Post
     *
     * @param array $data
     *
     * @return Post
     * @throws \Spatie\ModelStatus\Exceptions\InvalidStatus
     */
    public function store(array $data): Post;

    /**
     * Update Post
     *
     * @param array $data
     * @param int $id
     *
     * @return Post
     * @throws \Spatie\ModelStatus\Exceptions\InvalidStatus
     */
    public function update(array $data, int $id): Post;

    /**
     * Delete Post
     *
     * @param int $id
     *
     * @return void
     */
    public function delete(int $id): void;

}