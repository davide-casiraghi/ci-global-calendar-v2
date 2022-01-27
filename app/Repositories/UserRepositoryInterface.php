<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Spatie\ModelStatus\Exceptions\InvalidStatus;

interface UserRepositoryInterface
{
    /**
     * Get all the users.
     *
     * @param  int|null  $recordsPerPage
     * @param  array|null  $searchParameters
     *
     * @return iterable|LengthAwarePaginator
     */
    public function users(int $recordsPerPage = null, array $searchParameters = null);

    /**
     * Get user by id.
     *
     * @param  int  $userId
     * @return User
     */
    public function getById(int $userId): User;

    /**
     * Get user by email.
     *
     * @param  string  $userEmail
     * @return User|null
     */
    public function getByEmail(string $userEmail): ?User;

    /**
     * Store User
     *
     * @param  array  $data
     * @return User
     * @throws InvalidStatus
     */
    public function storeUser(array $data): User;

    /**
     * Update User.
     *
     * @param  array  $data
     * @param  User  $user
     * @return User
     * @throws InvalidStatus
     */
    public function update(array $data, User $user): User;

    /**
     * Delete User
     *
     * @param  int  $userId
     * @return void
     */
    public function delete(int $userId): void;

    /**
     * Return the users number
     *
     * @return int
     */
    public function usersCount(): int;

    /**
     * Return the users number by country
     *
     * @return Collection
     */
    public function usersNumberByCountry(): Collection;
}