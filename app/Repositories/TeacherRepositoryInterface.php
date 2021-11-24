<?php

namespace App\Repositories;

use App\Models\Teacher;

interface TeacherRepositoryInterface
{

    /**
     * Get all Teachers.
     *
     * @param int|null $recordsPerPage
     * @param array|null $searchParameters
     *
     * @return \App\Models\Teacher[]|\Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Collection
     */
    public function getAll(
        int $recordsPerPage = null,
        array $searchParameters = null
    );

    /**
     * Get Teacher by id
     *
     * @param int $id
     *
     * @return Teacher
     */
    public function getById(int $id): Teacher;

    /**
     * Get Teacher by slug
     *
     * @param  string  $teacherSlug
     * @return Teacher
     */
    public function getBySlug(string $teacherSlug): ?Teacher;

    /**
     * Store Teacher
     *
     * @param array $data
     *
     * @return Teacher
     */
    public function store(array $data): Teacher;

    /**
     * Update Teacher
     *
     * @param array $data
     * @param int $id
     *
     * @return Teacher
     */
    public function update(array $data, int $id): Teacher;

    /**
     * Delete Teacher
     *
     * @param int $id
     *
     * @return void
     */
    public function delete(int $id): void;

    /**
     * Assign the attributes of the data array to the object
     *
     * @param \App\Models\Teacher $teacher
     * @param array $data
     *
     * @return \App\Models\Teacher
     */
    public function assignDataAttributes(
        Teacher $teacher,
        array $data
    ): Teacher;

}
