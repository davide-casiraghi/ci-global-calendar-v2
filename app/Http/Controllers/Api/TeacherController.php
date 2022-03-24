<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Resources\TeacherResource;
use App\Models\Teacher;
use App\Services\TeacherService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class TeacherController extends Controller
{
    private TeacherService $teacherService;

    public function __construct(
        TeacherService $teacherService
    )
    {
        $this->teacherService = $teacherService;
    }

    /**
     * Display a listing of the resource.
     *
     * @param  Request  $request
     * @return AnonymousResourceCollection
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $searchParameters = Helper::getSearchParameters($request, Teacher::SEARCH_PARAMETERS);
        $teachers = $this->teacherService->getTeachers(20, $searchParameters, false, 'teachers.name', 'asc');

        return TeacherResource::collection($teachers);
    }

    /**
     * Display the specified resource.
     *
     * @param  Teacher  $teacher
     * @return TeacherResource
     */
    public function show(Teacher $teacher): TeacherResource
    {
        return new TeacherResource($teacher);
    }
}
