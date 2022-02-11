<?php
namespace App\Services;

use App\Helpers\ImageHelpers;
use App\Http\Requests\TeacherStoreRequest;
use App\Models\Teacher;
use App\Repositories\TeacherRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class TeacherService
{
    private TeacherRepositoryInterface $teacherRepository;

    /**
     * TestimonialService constructor.
     *
     * @param  TeacherRepositoryInterface  $teacherRepository
     */
    public function __construct(
        TeacherRepositoryInterface $teacherRepository
    ) {
        $this->teacherRepository = $teacherRepository;
    }

    /**
     * Create a teacher
     *
     * @param  TeacherStoreRequest  $request
     *
     * @return Teacher
     */
    public function createTeacher(TeacherStoreRequest $request): Teacher
    {
        $teacher = $this->teacherRepository->store($request->all());
        ImageHelpers::storeImages($teacher, $request, 'profile_picture');

        return $teacher;
    }

    /**
     * Update the Teacher
     *
     * @param  TeacherStoreRequest  $request
     * @param  Teacher  $teacher
     * @return Teacher
     */
    public function updateTeacher(TeacherStoreRequest $request, Teacher $teacher): Teacher
    {
        $teacher = $this->teacherRepository->update($request->all(), $teacher);

        ImageHelpers::storeImages($teacher, $request, 'profile_picture');
        ImageHelpers::deleteImages($teacher, $request, 'profile_picture');

        return $teacher;
    }

    /**
     * Return the teacher from the database
     *
     * @param int $teacherId
     *
     * @return Teacher
     */
    public function getById(int $teacherId): Teacher
    {
        return $this->teacherRepository->getById($teacherId);
    }

    /**
     * Return the teacher from the database
     *
     * @param  string  $teacherSlug
     * @return Teacher|null
     */
    public function getBySlug(string $teacherSlug): ?Teacher
    {
        return $this->teacherRepository->getBySlug($teacherSlug);
    }

    /**
     * Get all the Teachers.
     *
     * @param  int|null  $recordsPerPage
     * @param  array|null  $searchParameters
     * @param  bool  $showJustOwned
     * @param  string  $sortColumn
     * @param  string  $sortDirection
     * @return Collection|LengthAwarePaginator
     */
    public function getTeachers(int $recordsPerPage = null, array $searchParameters = null, bool $showJustOwned = false, string $sortColumn = 'teachers.name', string $sortDirection = 'asc')
    {
        return $this->teacherRepository->getAll($recordsPerPage, $searchParameters, $showJustOwned, $sortColumn, $sortDirection);
    }

    /**
     * Delete the teacher from the database
     *
     * @param int $teacherId
     */
    public function deleteTeacher(int $teacherId): void
    {
        $this->teacherRepository->delete($teacherId);
    }

    /**
     * Get the number of teacher created in the last 30 days.
     *
     * @return int
     */
    public function getNumberTeachersCreatedLastThirtyDays(): int
    {
        return Teacher::whereDate('created_at', '>', date('Y-m-d', strtotime('-30 days')))->count();
    }

}
