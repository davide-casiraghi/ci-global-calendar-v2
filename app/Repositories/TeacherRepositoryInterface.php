<?php

namespace App\Repositories;

use App\Models\Teacher;
use Illuminate\Support\Collection;

interface TeacherRepositoryInterface
{
    /**
     * Get all Teachers.
     *
     * @param  int|null  $recordsPerPage
     * @param  array|null  $searchParameters
     *
     * @return Teacher[]|\Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Collection
     */
    public function getAll(int $recordsPerPage = null, array $searchParameters = null);

    /**
     * Get Teacher by id
     *
     * @param  int  $id
     *
     * @return Teacher
     */
    public function getById(int $id): Teacher;

    /**
     * Get Teacher by slug
     *
     * @param  string  $teacherSlug
     *
     * @return Teacher|null
     */
    public function getBySlug(string $teacherSlug): ?Teacher;

    /**
     * Store Teacher
     *
     * @param  array  $data
     *
     * @return Teacher
     */
    public function store(array $data): Teacher;

    /**
     * Update Teacher
     *
     * @param  array  $data
     * @param  Teacher  $teacher
     * @return Teacher
     */
    public function update(array $data, Teacher $teacher): Teacher;

    /**
     * Delete Teacher
     *
     * @param  int  $id
     * @return void
     */
    public function delete(int $id): void;

    /**
     * Assign the attributes of the data array to the object
     *
     * @param  Teacher  $teacher
     * @param  array  $data
     *
     * @return Teacher
     */
    public function assignDataAttributes(Teacher $teacher, array $data): Teacher;

    /**
     * Return the teachers number
     *
     * @return int
     */
    public function teachersCount(): int;

    /**
     * Return the teachers number by country
     *
     * @return Collection
     */
    public function teachersNumberByCountry(): Collection;
}