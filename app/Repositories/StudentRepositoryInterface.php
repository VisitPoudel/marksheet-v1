<?php

namespace App\Repositories;

use App\Models\Student;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;

interface StudentRepositoryInterface
{
    /**
     * Returns Student Model.
     *
     * @return Student
     */
    public function getModel(): Student;

    /**
     * Returns Student with given id,
     *
     * @param int $id
     * @return Student
     * @throws ModelNotFoundException
     */
    public function get(int $id): Student;

    /**
     * Creates and returns Student.
     *
     * @param array $attributes
     * @return Student
     */
    public function create(array $attributes): Student;

    /**
     * Updates and returns Student.
     *
     * @param array $attributes
     * @param Student $student
     * @return Student
     */
    public function update(array $attributes, Student $student): Student;

    /**
     * Deletes the given student.
     *
     * @param Student $student
     * @return bool|null
     * @throws Exception
     */
    public function destroy(Student $student);
}
