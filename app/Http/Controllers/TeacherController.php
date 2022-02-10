<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Requests\TeacherStoreRequest;
use App\Models\Teacher;
use App\Services\CountryService;
use App\Services\EventService;
use App\Services\TeacherService;
use App\Traits\CheckPermission;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeacherController extends Controller
{
    use CheckPermission;

    private TeacherService $teacherService;
    private CountryService $countryService;
    private EventService $eventService;

    public function __construct(
        TeacherService $teacherService,
        CountryService $countryService,
        EventService $eventService,
    ) {
        $this->teacherService = $teacherService;
        $this->countryService = $countryService;
        $this->eventService = $eventService;
    }

    /**
     * Display a listing of the resource.
     *
     * @param  Request  $request
     *
     * @return View
     */
    public function index(Request $request): View
    {
        $this->checkPermission('teachers.view');

        $searchParameters = Helper::getSearchParameters($request, Teacher::SEARCH_PARAMETERS);
        $showJustOwned = !Auth::user()->isAdmin(); // To a normal user shows just the owned events.

        $teachers = $this->teacherService->getTeachers(20, $searchParameters, $showJustOwned, 'name', 'desc');
        $countries = $this->countryService->getCountries();

        return view('teachers.index', [
            'teachers' => $teachers,
            'searchParameters' => $searchParameters,
            'countries' => $countries,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(): View
    {
        $this->checkPermission('teachers.create');

        $countries = $this->countryService->getCountries();

        return view('teachers.create', [
            'countries' => $countries,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  TeacherStoreRequest  $request
     *
     * @return RedirectResponse
     */
    public function store(TeacherStoreRequest $request): RedirectResponse
    {
        $this->checkPermission('teachers.create');

        $this->teacherService->createTeacher($request);

        return redirect()->route('teachers.index')
            ->with('success', 'Teacher updated successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  Teacher  $teacher
     * @return View
     */
    public function show(Teacher $teacher): View
    {
        $searchParameters = [
            'teacher_id' => $teacher->id,
            'is_published' => true,
            'start_repeat' => Carbon::today()->format('d/m/Y'),
        ];
        $futureTeacherEvents = $this->eventService->getEvents(null, $searchParameters, 'asc', false);

        return view('teachers.show', [
            'teacher' => $teacher,
            'futureTeacherEvents' =>  $futureTeacherEvents,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Teacher  $teacher
     * @return View
     */
    public function edit(Teacher $teacher): View
    {
        $this->checkPermissionAllowOwner('teachers.edit', $teacher);

        $countries = $this->countryService->getCountries();

        return view('teachers.edit', [
            'teacher' => $teacher,
            'countries' => $countries,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  TeacherStoreRequest  $request
     * @param  Teacher  $teacher
     * @return RedirectResponse
     */
    public function update(TeacherStoreRequest $request, Teacher $teacher): RedirectResponse
    {
        $this->checkPermissionAllowOwner('teachers.edit', $teacher);

        $this->teacherService->updateTeacher($request, $teacher);

        return redirect()->route('teachers.index')
            ->with('success', 'Teacher updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Teacher  $teacher
     * @return RedirectResponse
     */
    public function destroy(Teacher $teacher): RedirectResponse
    {
        $this->checkPermissionAllowOwner('teachers.delete', $teacher);

        $this->teacherService->deleteTeacher($teacher->id);

        return redirect()->route('teachers.index')
            ->with('success', 'Teacher deleted successfully');
    }
}
