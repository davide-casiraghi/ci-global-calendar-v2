<?php

namespace App\Services;

use App\Http\Requests\UserStoreRequest;
use App\Models\User;
use App\Repositories\UserProfileRepositoryInterface;
use App\Repositories\UserRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Laravolt\Avatar\Facade as Avatar;
use Spatie\ModelStatus\Exceptions\InvalidStatus;

class UserService
{
    private UserRepositoryInterface $userRepository;
    private UserProfileRepositoryInterface $userProfileRepository;

    /**
     * AdminService constructor.
     *
     * @param  UserRepositoryInterface  $userRepository
     * @param  UserProfileRepositoryInterface  $userProfileRepository
     */
    public function __construct(
        UserRepositoryInterface $userRepository,
        UserProfileRepositoryInterface $userProfileRepository
    ) {
        $this->userRepository = $userRepository;
        $this->userProfileRepository = $userProfileRepository;
    }

    /**
     * Create a user and the profile at the same time.
     *
     * @param  UserStoreRequest  $request
     *
     * @return User
     * @throws InvalidStatus
     */
    public function createUser(Request $request): User
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

        // Assign registered role to all new users.
        $user->assignRole('Registered');

        // User level (Super admin, Admin, Member)
        $roles[] = $request->role;

        // Teams membership
        $roles = $request->team_membership ?? [];

        $user->assignRole($roles);

        self::updateUserAvatar($user->id, $user->profile->name, $user->profile->surname);

        return $user;
    }

    /**
     * Update the user and profile at the same time.
     *
     * @param  UserStoreRequest  $request
     * @param  User  $user
     * @return User
     * @throws InvalidStatus
     */
    public function updateUser(UserStoreRequest $request, User $user): User
    {
        $user = $this->userRepository->update($request->all(), $user);
        $this->userProfileRepository->update($request->all(), $user->profile->id);

        $roles = [];

        // User level (Super admin, Admin)
        $roles[] = $request->role;

        // Teams membership
        // (Just if the role is admin, for super admins we don't need them)
        if ($request->role == "Admin") {
            $roles[] = $request->team_membership;
        }
        $user->syncRoles($roles);

        self::updateUserAvatar($user->id, $user->profile->name, $user->profile->surname);

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

    /**
     * Update the user avatar image.
     *
     * @param  int  $userId
     * @param  string  $name
     * @param  string  $surname
     */
    public function updateUserAvatar(int $userId, string $name, string $surname): void
    {
        $path = public_path('images/avatars');
        if(!File::isDirectory($path)){
            File::makeDirectory($path, 0777, true, true);
        }

        Avatar::create($name." ".$surname)->save($path.'/'.$userId.'_avatar.png');
    }
}



