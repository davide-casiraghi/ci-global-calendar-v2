<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Requests\UserStoreRequest;
use App\Models\User;
use App\Services\CountryService;
use App\Services\TeamService;
use App\Services\UserService;
use App\Traits\CheckPermission;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Session;
use Spatie\ModelStatus\Exceptions\InvalidStatus;

class UserController extends Controller
{
    use CheckPermission;

    private UserService $userService;
    private TeamService $teamService;
    private CountryService $countryService;

    /**
     * UserController constructor.
     *
     * @param  UserService  $userService
     * @param  TeamService  $teamService
     * @param  CountryService  $countryService
     */
    public function __construct(
        UserService $userService,
        TeamService $teamService,
        CountryService $countryService
    ) {
        $this->userService = $userService;
        $this->teamService = $teamService;
        $this->countryService = $countryService;
    }

    /**
     * Display a listing of the users.
     *
     * @param  Request  $request
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\View\View
     */
    public function index(Request $request): View
    {
        $this->checkPermission('users.view');

        $searchParameters = Helper::getSearchParameters($request, User::SEARCH_PARAMETERS);

        $users = $this->userService->getUsers(20, $searchParameters);
        $userLevels =  $this->teamService->getAllAdminRoles();
        $teams = $this->teamService->getAllTeamRoles();
        $countries = $this->countryService->getCountries();
        $statuses = User::STATUS;

        return view('users.index', [
            'users' => $users,
            'userLevels' => $userLevels,
            'teams' => $teams,
            'countries' => $countries,
            'searchParameters' => $searchParameters,
            'statuses' => $statuses,
        ]);
    }

    /**
     * Show to the form for creating a new user.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\View\View
     */
    public function create(): View
    {
        $this->checkPermission('users.create');

        $countries = $this->countryService->getCountries();
        $roles = $this->teamService->getAllUserRoles();
        $userLevels = $this->teamService->getAllAdminRoles();
        $allTeams = $this->teamService->getAllTeamRoles();

        return view('users.create', [
            'countries' => $countries,
            'roles' => $roles,
            'userLevels' => $userLevels,
            'allTeams' => $allTeams,
        ]);
    }

    /**
     * Store a user created by an admin
     *
     * @param  UserStoreRequest  $request
     *
     * @return RedirectResponse
     */
    public function store(UserStoreRequest $request): RedirectResponse
    {
        $this->checkPermission('users.create');

        $user = $this->userService->createUser($request);
        //$user->notify(new MemberResetPasswordNotification($user));

        return redirect()->route('users.index')
            ->with('success', 'User created successfully');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  User  $user
     * @return View
     */
    public function edit(User $user): View
    {
        if (Auth::id() != $user->id) {
            $this->checkPermission('users.edit');
        }

        $countries = $this->countryService->getCountries();
        $roles = $this->teamService->getAllUserRoles();
        $assignedRole = $user->getRoleNames()[0] ?? null;
        $userLevels = $this->teamService->getAllAdminRoles();
        $allTeams = $this->teamService->getAllTeamRoles();

        return view('users.edit', [
            'user' => $user,
            'countries' => $countries,
            'roles' => $roles,
            'assignedRole' => $assignedRole,
            'userLevels' => $userLevels,
            'allTeams' => $allTeams,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UserStoreRequest  $request
     * @param  User  $user
     * @return RedirectResponse
     * @throws InvalidStatus
     */
    public function update(UserStoreRequest $request, User $user): RedirectResponse
    {
        if (Auth::id() != $user->id) {
            $this->checkPermission('users.edit');
        }

        $this->userService->updateUser($request, $user);

        if (Auth::user()->hasPermissionTo('users.edit')) {
            return redirect()->route('users.index')
                ->with('success', __('ui.users.admin_updated_member_profile'));
        }
        if (Session::get('completeProfile')) {
            return redirect()->back()
                ->with('success', __('ui.users.first_time_updated_profile'));
        }
        return redirect()->back()
            ->with('success', __('ui.users.updated_profile'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $userId
     *
     * @return RedirectResponse
     */
    public function destroy(int $userId): RedirectResponse
    {
        $this->checkPermission('users.delete');

        $this->userService->deleteUser($userId);

        return redirect()->route('users.index')
            ->with('success', __('ui.users.admin_deleted_member_profile'));
    }

    /**
     * Show to the user a notice that his/her status is still pending
     *
     * @return View
     */
    public function pending(): View
    {
        return view('users.status.pending');
    }

    /**
     * Show to the user a notice that his/her status is refused
     *
     * @return View
     */
    public function refused(): View
    {
        return view('users.status.refused');
    }
}
