<?php

namespace App\Services;

use App\Http\Requests\AdminStoreRequest;
use App\Http\Requests\PermissionStoreRequest;
use App\Http\Requests\UserStoreRequest;
use App\Repositories\PermissionRepository;
use App\Repositories\PermissionRepositoryInterface;
use App\Repositories\UserRepository;
use App\Repositories\UserRepositoryInterface;
use Spatie\Permission\Models\Permission;

class PermissionService {

    private PermissionRepositoryInterface $permissionRepository;
    private UserRepositoryInterface $userRepository;

    /**
     * PermissionService constructor.
     *
     * @param \App\Repositories\PermissionRepositoryInterface $permissionRepository
     * @param \App\Repositories\UserRepositoryInterface $userRepository
     */
    public function __construct(
        PermissionRepositoryInterface $permissionRepository,
        UserRepositoryInterface $userRepository
    )
    {
        $this->permissionRepository = $permissionRepository;
        $this->userRepository = $userRepository;
    }


    /**
     * Update all teams permissions (Spatie permissions)
     *
     * @param PermissionStoreRequest $data
     *
     * @return void
     */
    public function updateTeamPermissions(PermissionStoreRequest $data): void
    {
        $this->permissionRepository->updateAllTeamsPermissions($data);
    }


    /**
     * Update user permissions (Spatie permissions)
     *
     * @param array $data
     * @param int $userId
     *
     * @return void
     */
    public function updateUserPermissions(array $data, int $userId): void
    {
        $user = $this->userRepository->getById($userId);
        $user->syncPermissions(array_keys($data['permissions']));
    }

    /**
     * Return a multidimensional array with all the available Permissions.
     *
     * eg.
     * $permissionsByEntities['users'][0] = 'view'
     * $permissionsByEntities['users'][1] = 'edit'
     *
     * @return iterable
     */
    public function getAllPermissionsByRoleAndProperty()
    {
        $permissions = Permission::all();

        $permissionsByEntities = [];
        foreach ($permissions as $permission) {
            $permission_name = explode(".",$permission->name);

            $entity = $permission_name[0];
            $entity_permission = $permission_name[1];

            $permissionsByEntities[$entity][] = $entity_permission;
        }

        return $permissionsByEntities;
    }

    /**
     * Get a list of all permissions directly assigned to the user (Spatie permissions)
     *
     * @param int $userId
     *
     * @return iterable
     */
    public function getUserPermissions($userId)
    {
        $user = $this->userRepository->getById($userId);
        return $user->permissions;
    }

}