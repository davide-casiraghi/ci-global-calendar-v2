<?php

namespace App\Repositories;

use App\Models\Teacher;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TeacherRepository implements TeacherRepositoryInterface
{
    /**
     * Get all Teachers.
     *
     * @param int|null $recordsPerPage
     * @param array|null $searchParameters
     *
     * @return Teacher[]|\Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Collection
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
     * @return Teacher|null
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
     * @param  array  $data
     * @param  Teacher  $teacher
     * @return Teacher
     */
    public function update(array $data, Teacher $teacher): Teacher
    {
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
     * @param  Teacher  $teacher
     * @param array $data
     *
     * @return Teacher
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

    /**
     * Return the teachers number by country
     *
     * @return Collection
     */
    public function teachersNumberByCountry(): Collection
    {
        $teachersNumberByCountries = Teacher::leftJoin('countries', 'teachers.country_id', '=', 'countries.id')
            ->select(DB::raw('count(*) as teacher_count, countries.name as country_name'))
            ->groupBy('country_id')
            ->orderBy('country_name')
            ->get();

        return $teachersNumberByCountries;
    }
}
