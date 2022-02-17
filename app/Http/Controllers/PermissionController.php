<?php

namespace App\Http\Controllers;

use App\Http\Requests\PermissionStoreRequest;
use App\Services\PermissionService;
use App\Traits\CheckPermission;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    use CheckPermission;

    private PermissionService $permissionService;

    /**
     * PermissionController constructor.
     *
     * @param  PermissionService  $permissionService
     */
    public function __construct(
        PermissionService $permissionService
    ) {
        $this->permissionService = $permissionService;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  PermissionStoreRequest  $request
     *
     * @return RedirectResponse
     */
    public function store(PermissionStoreRequest $request)
    {
        $this->checkPermission('permissions.edit');
        $this->permissionService->updateTeamPermissions($request);

        return redirect()->route('teams.index')
            ->with('success', 'Team permissions updated successfully');
    }
}
