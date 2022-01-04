<?php

namespace App\Repositories;

use App\Models\Teacher;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class TeacherRepository implements TeacherRepositoryInterface
{
    /**
     * Get all Teachers.
     *
     * @param int|null $recordsPerPage
     * @param array|null $searchParameters
     *
     * @return \App\Models\Teacher[]|\Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Collection
     */
    public function getAll(int $recordsPerPage = null, array $searchParameters = null)
    {
        $query = Teacher::orderBy('name', 'desc');

        if (!is_null($searchParameters)) {
            if (!empty($searchParameters['name'])) {
                $query->where(
                    'name',
                    'like',
                    '%' . $searchParameters['name'] . '%'
                );
            }
            if (!empty($searchParameters['surname'])) {
                $query->where(
                    'surname',
                    'like',
                    '%' . $searchParameters['surname'] . '%'
                );
            }
            if (!empty($searchParameters['countryId'])) {
                $query->where('country_id', $searchParameters['countryId']);
            }
        }

        if ($recordsPerPage) {
            $results = $query->paginate($recordsPerPage)->withQueryString();
        } else {
            $results = $query->get();
        }

        return $results;
    }

    /**
     * Get Teacher by id
     *
     * @param int $id
     *
     * @return Teacher
     */
    public function getById(int $id): Teacher
    {
        return Teacher::findOrFail($id);
    }

    /**
     * Get Teacher by slug
     *
     * @param string $teacherSlug
     *
     * @return \App\Models\Teacher|null
     */
    public function getBySlug(string $teacherSlug): ?Teacher
    {
        return Teacher::where('slug', $teacherSlug)->first();
    }

    /**
     * Store Teacher
     *
     * @param array $data
     *
     * @return Teacher
     */
    public function store(array $data): Teacher
    {
        $teacher = new Teacher();
        $teacher = self::assignDataAttributes($teacher, $data);

        // Creator - Logged user id or 1 for factories
        $teacher->user_id = !is_null(Auth::id()) ? Auth::id() : 1;

        $teacher->save();

        return $teacher->fresh();
    }

    /**
     * Update Teacher
     *
     * @param array $data
     * @param int $id
     *
     * @return Teacher
     */
    public function update(array $data, int $id): Teacher
    {
        $teacher = $this->getById($id);
        $teacher = self::assignDataAttributes($teacher, $data);

        $teacher->update();

        return $teacher;
    }

    /**
     * Delete Teacher
     *
     * @param int $id
     * @return void
     */
    public function delete(int $id): void
    {
        Teacher::destroy($id);
    }

    /**
     * Assign the attributes of the data array to the object
     *
     * @param \App\Models\Teacher $teacher
     * @param array $data
     *
     * @return \App\Models\Teacher
     */
    public function assignDataAttributes(Teacher $teacher, array $data): Teacher
    {
        $teacher->country_id = $data['country_id'] ?? null;
        $teacher->name = $data['name'];
        $teacher->surname = $data['surname'] ?? null;
        $teacher->bio = $data['bio'] ?? null;
        $teacher->year_starting_practice = $data['year_starting_practice'] ?? null;
        $teacher->year_starting_teach = $data['year_starting_teach'] ?? null;
        $teacher->significant_teachers = $data['significant_teachers'] ?? null;
        $teacher->website = $data['website'] ?? null;
        $teacher->facebook = $data['facebook'] ?? null;

        return $teacher;
    }

    /**
     * Return the teachers number
     *
     * @return int
     */
    public function teachersCount(): int
    {
        return Teacher::count();
    }
}
