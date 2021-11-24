<?php

namespace App\Http\Controllers;

use App\Http\Requests\TeamStoreRequest;
use App\Services\PermissionService;
use App\Services\TeamService;
use App\Traits\CheckPermission;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class TeamController extends Controller
{
    use CheckPermission;

    private TeamService $teamService;
    private PermissionService $permissionService;

    /**
     * TeamController constructor.
     *
     * @param \App\Services\TeamService $teamService
     * @param \App\Services\PermissionService $permissionService
     */
    public function __construct(
        TeamService $teamService,
        PermissionService $permissionService
    ) {
        $this->teamService = $teamService;
        $this->permissionService = $permissionService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $this->checkPermission('teams.view');

        $teams = $this->teamService->getAll();
        $allPermissions = $this->permissionService->getAllPermissionsByRoleAndProperty();

        return view('teams.index', [
            'teams' => $teams,
            'allPermissions' => $allPermissions,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $this->checkPermission('teams.create');

        return view('teams.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\TeamStoreRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(TeamStoreRequest $request)
    {
        $this->checkPermission('teams.create');

        $this->teamService->createTeam($request);

        return redirect()->route('teams.index')
            ->with('success', 'Team created successfully');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $teamId
     * @return \Illuminate\View\View
     */
    public function edit(int $teamId)
    {
        $this->checkPermission('teams.edit');

        $team = Role::findById($teamId);

        return view('teams.edit', [
            'team' => $team,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\TeamStoreRequest $request
     * @param int $teamId
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(TeamStoreRequest $request, int $teamId)
    {
        $this->checkPermission('teams.edit');

        $this->teamService->updateTeam($request, $teamId);

        return redirect()->route('teams.index')
            ->with('success','Team updated successfully');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $teamId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(int $teamId)
    {
        $this->teamService->deleteTeam($teamId);

        return redirect()->route('teams.index')
            ->with('success', 'Team deleted successfully');
    }

}
