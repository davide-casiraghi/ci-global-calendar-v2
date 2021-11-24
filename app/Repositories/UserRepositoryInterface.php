<?php

namespace App\Repositories;

use App\Models\User;

interface UserRepositoryInterface
{

    /**
     * Get all the users.
     *
     * @param int|null $recordsPerPage
     * @param array|null $searchParameters
     *
     * @return iterable|\Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function users(
        int $recordsPerPage = null,
        array $searchParameters = null
    );

    /**
     * Get user by id
     *
     * @param int $userId
     *
     * @return User
     */
    public function getById(int $userId);

    /**
     * Store User
     *
     * @param array $data
     *
     * @return User
     */
    public function storeUser(array $data);

    /**
     * Update User
     *
     * @param array $data
     * @param int $userId
     *
     * @return User
     */
    public function update(array $data, int $userId);

    /**
     * Delete User
     *
     * @param int $userId
     *
     * @return void
     */
    public function delete(int $userId);

}