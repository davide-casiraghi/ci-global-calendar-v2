<?php

namespace App\Repositories;

use App\Http\Requests\PermissionStoreRequest;

interface PermissionRepositoryInterface {

    /**
     * Update all the permissions of the Teams (Spatie Roles)
     *
     * @param \App\Http\Requests\PermissionStoreRequest $data
     *
     * @return void
     */
    public function updateAllTeamsPermissions(PermissionStoreRequest $data);

}