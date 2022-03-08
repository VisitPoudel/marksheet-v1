<?php

namespace App\Repositories\Eloquent;

use App\Models\ClassModel;
use App\Repositories\ClassRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;

class ClassRepository implements ClassRepositoryInterface
{
    private $model;

    /**
     * ClassModelRepository constructor.
     *
     * @param ClassModel $model
     */
    public function __construct(ClassModel $model)
    {
        $this->model = $model;
    }

    /**
     * Returns Class Model.
     *
     * @return ClassModel
     */
    public function getModel(): ClassModel
    {
        return $this->model;
    }

    /**
     * Returns ClassModel with give id,
     *
     * @param int $id
     * @return ClassModel
     * @throws ModelNotFoundException
     */
    public function get(int $id): ClassModel
    {
        return $this->model->findOrfail($id);
    }

    /**
     * Creates and returns ClassModel.
     *
     * @param array $attributes
     * @return ClassModel
     */
    public function create(array $attributes): ClassModel
    {
        return $this->model->create($attributes);
    }

    /**
     * Updates and returns ClassModel.
     *
     * @param array $attributes
     * @param ClassModel $class
     * @return ClassModel
     */
    public function update(array $attributes, ClassModel $class): ClassModel
    {
        $class->update($attributes);

        return $class;
    }

    /**
     * Deletes the given datacenter along with servers of the datacenter and loadbalancers of that server.
     *
     * @param ClassModel $class
     * @return bool|null
     * @throws Exception
     */
    public function destroy(ClassModel $class)
    {
        return $class->delete();
    }
}
