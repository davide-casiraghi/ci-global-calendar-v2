<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Requests\UserSearchRequest;
use App\Http\Requests\UserStoreRequest;
use App\Models\User;
use App\Services\CountryService;
use App\Services\TeamService;
use App\Services\UserService;
use App\Traits\CheckPermission;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Session;

class UserController extends Controller
{
    use CheckPermission;

    private UserService $userService;
    private TeamService $teamService;
    private CountryService $countryService;

    /**
     * UserController constructor.
     *
     * @param \App\Services\UserService $userService
     * @param \App\Services\TeamService $teamService
     * @param \App\Services\CountryService $countryService
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
     * @param \App\Http\Requests\UserSearchRequest $request
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\View\View
     */
    public function index(UserSearchRequest $request): View
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
     * @param \App\Http\Requests\UserStoreRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
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
     * @param  int  $userId
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\View\View
     */
    public function edit(int $userId): View
    {
        if (Auth::id() != $userId) {
            $this->checkPermission('users.edit');
        }

        $user = $this->userService->getById($userId);
        $countries = $this->countryService->getCountries();
        $roles = $this->teamService->getAllUserRoles();
        $userLevels = $this->teamService->getAllAdminRoles();
        $allTeams = $this->teamService->getAllTeamRoles();

        return view('users.edit', [
            'user' => $user,
            'countries' => $countries,
            'roles' => $roles,
            'userLevels' => $userLevels,
            'allTeams' => $allTeams,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\UserStoreRequest $request
     * @param int $userId
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Spatie\ModelStatus\Exceptions\InvalidStatus
     */
    public function update(UserStoreRequest $request, int $userId): RedirectResponse
    {
        if (Auth::id() != $userId) {
            $this->checkPermission('users.edit');
        }

        $this->userService->updateUser($request, $userId);

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
     * @return \Illuminate\Http\RedirectResponse
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
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\View\View
     */
    public function pending(): View
    {
        return view('users.status.pending');
    }

    /**
     * Show to the user a notice that his/her status is refused
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\View\View
     */
    public function refused(): View
    {
        return view('users.status.refused');
    }
}
