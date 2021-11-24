<?php

namespace App\Repositories;

use App\Http\Requests\PermissionStoreRequest;
use Spatie\Permission\Guard;
use Spatie\Permission\Models\Role;

class PermissionRepository implements PermissionRepositoryInterface {

    /**
     * Update all the permissions of the Teams (Spatie Roles)
     *
     * @param \App\Http\Requests\PermissionStoreRequest $data
     *
     * @return void
     */
    public function updateAllTeamsPermissions(PermissionStoreRequest $data)
    {
        foreach ($data['permissions'] as $team => $permission){
            $teamName = str_replace('_', ' ', $team);
            $role = Role::findByName($teamName, 'web');

            //Detach all prior permissions and attach only the ones provided.
            $role->syncPermissions(array_keys($permission));
        }
    }

}