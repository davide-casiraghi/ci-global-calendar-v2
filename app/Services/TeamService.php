<?php

namespace App\Services;

use App\Http\Requests\TeamStoreRequest;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Spatie\Permission\Models\Role;

class TeamService
{
    /**
     * Create a user team (Spatie role)
     *
     * @param TeamStoreRequest $request
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
     */
    public function createTeam(TeamStoreRequest $request)
    {
        $team = Role::create(['name' => $request->name, 'guard_name' => 'web']);

        return $team;
    }

    /**
     * Update a user team (Spatie role)
     *
     * @param  TeamStoreRequest  $request
     * @param int $teamId
     *
     * @return \Spatie\Permission\Contracts\Role
     */
    public function updateTeam(TeamStoreRequest $request, int $teamId)
    {
        $team = Role::findById($teamId, 'web');
        $team->name = $request->name;
        $team->save();

        return $team;
    }

    /**
     * Return the team from the database
     *
     * @param int $teamId
     *
     * @return \Spatie\Permission\Contracts\Role
     */
    public function getById(int $teamId): Role
    {
        return Role::findById($teamId, 'web');
    }

    /**
     * Get all teams.
     *
     * @return Collection
     */
    public function getAll(): Collection
    {
        return Role::whereNotIn('name', ['Super Admin', 'Admin', 'Member', 'Registered'])->get();
    }

    /**
     * Delete the team from the database
     *
     * @param int $teamId
     *
     * @throws Exception
     */
    public function deleteTeam(int $teamId): void
    {
        $team = Role::findById($teamId);
        $team->delete();
    }

    /**
     * Return all the roles related to user level
     * (Admin, Super Admin, Member)
     *
     * @return Collection
     */
    public function getAllUserLevels(): Collection
    {
        return Role::where('name', 'like', '%Admin%')
            ->orWhere('name', 'like', '%Member%')
            ->get();
    }

    /**
     * Return all the roles related to teams.
     * (just admins can be assigned to teams)
     * @todo - this may be a duplicate of getAll()
     *
     * @return Collection
     */
    public function getAllTeamRoles(): Collection
    {
        return Role::orWhere(function ($query) {
            $query->where('name', 'not like', '%Super admin%')
                ->where('name', 'not like', '%Admin%')
                ->where('name', 'not like', '%Member%')
                ->where('name', 'not like', '%Registered%');
        })->get();
    }

    /**
     * Return all the roles Admins and Teams.
     *
     * @param null $userId
     *
     * @return \Illuminate\Support\Collection
     */
    public function getAllUserRoles($userId = null): \Illuminate\Support\Collection
    {
        return Role::all()->pluck('name');
    }

}