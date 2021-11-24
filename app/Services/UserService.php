<?php

namespace App\Services;

use App\Http\Requests\UserSearchRequest;
use App\Http\Requests\UserStoreRequest;
use App\Models\User;
use App\Repositories\UserProfileRepositoryInterface;
use App\Repositories\UserRepositoryInterface;

class UserService
{
    private UserRepositoryInterface $userRepository;
    private UserProfileRepositoryInterface $userProfileRepository;

    /**
     * AdminService constructor.
     *
     * @param \App\Repositories\UserRepositoryInterface $userRepository
     * @param \App\Repositories\UserProfileRepositoryInterface $userProfileRepository
     */
    public function __construct(
        UserRepositoryInterface $userRepository,
        UserProfileRepositoryInterface $userProfileRepository
    ) {
        $this->userRepository = $userRepository;
        $this->userProfileRepository = $userProfileRepository;
    }

    /**
     * Create an user and the profile at the same time
     *
     * @param \App\Http\Requests\UserStoreRequest $request
     *
     * @return User
     */
    public function createUser(UserStoreRequest $request): User
    {
        $user = $this->userRepository->storeUser($request->all());

        // Assign an new empty user profile to the user
        $this->userProfileRepository->store([
            'user_id' => $user->id,
            'name' => $request->name,
            'surname' => $request->surname,
            'country_id' => $request->country_id,
            'description' => $request->description,
            'accept_terms' => ($request->accept_terms == 'on') ? 1 : 0,
        ]);

        // Teams membership
        $roles = $request->team_membership ?? [];

        // User level
        $roles[] = $request->role;

        $user->assignRole($roles);

        return $user;
    }

    /**
     * Update the user user and profile at the same time
     *
     * @param \App\Http\Requests\UserStoreRequest $request
     * @param int $userId
     *
     * @return User
     * @throws \Spatie\ModelStatus\Exceptions\InvalidStatus
     */
    public function updateUser(UserStoreRequest $request, int $userId): User
    {
        $user = $this->userRepository->update($request->all(), $userId);
        $this->userProfileRepository->update($request->all(), $user->profile->id);

        $roles = [];

        // User level
        $roles[] = $request->role;

        // Teams membership
        // (Just if the role is admin, for super admins we don't need them)
        if ($request->role == "Admin") {
            $roles[] = $request->team_membership;
        }
        $user->syncRoles($roles);

        return $user;
    }

    /**
     * Return the user from the database
     *
     * @param int $userId
     *
     * @return User
     */
    public function getById(int $userId): User
    {
        return $this->userRepository->getById($userId);
    }

    /**
     * Get all the administrators.
     *
     * @param int|null $recordsPerPage
     * @param array|null $searchParameters
     *
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getUsers(int $recordsPerPage = null, array $searchParameters = null)
    {
        return $this->userRepository->users($recordsPerPage, $searchParameters);
    }

    /**
     * Delete the user from the database
     *
     * @param int $userId
     */
    public function deleteUser(int $userId): void
    {
        $this->userRepository->delete($userId);
    }
}
