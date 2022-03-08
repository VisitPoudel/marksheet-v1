<?php

namespace App\Repositories\Eloquent;

use App\Models\Student;
use App\Repositories\StudentRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;

class StudentRepository implements StudentRepositoryInterface
{
    private $model;

    /**
     * StudentRepository constructor.
     *
     * @param Student $model
     */
    public function __construct(Student $model)
    {
        $this->model = $model;
    }

    /**
     * Returns Student Model.
     *
     * @return Student
     */
    public function getModel(): Student
    {
        return $this->model;
    }

    /**
     * Returns Student with give id,
     *
     * @param int $id
     * @return Student
     * @throws ModelNotFoundException
     */
    public function get(int $id): Student
    {
        return $this->model->findOrfail($id);
    }

    /**
     * Creates and returns Student.
     *
     * @param array $attributes
     * @return Student
     */
    public function create(array $attributes): Student
    {
        return $this->model->create($attributes);
    }

    /**
     * Updates and returns Student.
     *
     * @param array $attributes
     * @param Student $student
     * @return Student
     */
    public function update(array $attributes, Student $student): Student
    {
        $student->update($attributes);

        return $student;
    }

    /**
     * Deletes the given datacenter along with servers of the datacenter and loadbalancers of that server.
     *
     * @param Student $student
     * @return bool|null
     * @throws Exception
     */
    public function destroy(Student $student)
    {
        return $student->delete();
    }
}
