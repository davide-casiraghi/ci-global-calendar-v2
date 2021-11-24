<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Requests\TeacherSearchRequest;
use App\Http\Requests\TeacherStoreRequest;
use App\Models\Teacher;
use App\Services\CountryService;
use App\Services\TeacherService;
use App\Traits\CheckPermission;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    use CheckPermission;

    private TeacherService $teacherService;
    private CountryService $countryService;

    public function __construct(
        TeacherService $teacherService,
        CountryService $countryService
    ) {
        $this->teacherService = $teacherService;
        $this->countryService = $countryService;
    }

    /**
     * Display a listing of the resource.
     *
     * @param \App\Http\Requests\TeacherSearchRequest $request
     *
     * @return Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(TeacherSearchRequest $request)
    {
        $this->checkPermission('teachers.view');

        $searchParameters = Helper::getSearchParameters($request, Teacher::SEARCH_PARAMETERS);

        $teachers = $this->teacherService->getTeachers(20, $searchParameters);
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
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
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
     * @param \App\Http\Requests\TeacherStoreRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Spatie\ModelStatus\Exceptions\InvalidStatus
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
     * @param  string  $teacherSlug
     * @return Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|RedirectResponse
     */
    public function show(string $teacherSlug)
    {
        $teacher = $this->teacherService->getBySlug($teacherSlug);

        if (is_null($teacher)){
            return redirect()->route('home');
        }

        return view('teachers.show', compact('teacher'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $teacherId
     *
     * @return Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(int $teacherId)
    {
        $this->checkPermission('teachers.edit');

        $teacher = $this->teacherService->getById($teacherId);
        $countries = $this->countryService->getCountries();

        return view('teachers.edit', [
            'teacher' => $teacher,
            'countries' => $countries,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\TeacherStoreRequest $request
     * @param int $teacherId
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(TeacherStoreRequest $request, int $teacherId): RedirectResponse
    {
        $this->checkPermission('teachers.edit');

        $this->teacherService->updateTeacher($request, $teacherId);

        return redirect()->route('teachers.index')
            ->with('success', 'Teacher updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $teacherId
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(int $teacherId): RedirectResponse
    {
        $this->checkPermission('teachers.delete');

        $this->teacherService->deleteTeacher($teacherId);

        return redirect()->route('teachers.index')
            ->with('success', 'Teacher deleted successfully');
    }
}
