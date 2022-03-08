<?php

namespace App\Repositories\Eloquent;

use App\Models\Subject;
use App\Repositories\SubjectRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;

class SubjectRepository implements SubjectRepositoryInterface
{
    private $model;

    /**
     * SubjectRepository constructor.
     *
     * @param Subject $model
     */
    public function __construct(Subject $model)
    {
        $this->model = $model;
    }

    /**
     * Returns Subject Model.
     *
     * @return Subject
     */
    public function getModel(): Subject
    {
        return $this->model;
    }

    /**
     * Returns Subject with give id,
     *
     * @param int $id
     * @return Subject
     * @throws ModelNotFoundException
     */
    public function get(int $id): Subject
    {
        return $this->model->findOrfail($id);
    }

    /**
     * Creates and returns Subject.
     *
     * @param array $attributes
     * @return Subject
     */
    public function create(array $attributes): Subject
    {
        return $this->model->create($attributes);
    }

    /**
     * Updates and returns Subject.
     *
     * @param array $attributes
     * @param Subject $subject
     * @return Subject
     */
    public function update(array $attributes, Subject $subject): Subject
    {
        $subject->update($attributes);

        return $subject;
    }

    /**
     * Deletes the given datacenter along with servers of the datacenter and loadbalancers of that server.
     *
     * @param Subject $subject
     * @return bool|null
     * @throws Exception
     */
    public function destroy(Subject $subject)
    {
        return $subject->delete();
    }
}
