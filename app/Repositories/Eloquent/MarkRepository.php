<?php

namespace App\Repositories\Eloquent;

use App\Models\Mark;
use App\Repositories\MarkRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;

class MarkRepository implements MarkRepositoryInterface
{
    private $model;

    /**
     * MarkRepository constructor.
     *
     * @param Mark $model
     */
    public function __construct(Mark $model)
    {
        $this->model = $model;
    }

    /**
     * Returns Mark Model.
     *
     * @return Mark
     */
    public function getModel(): Mark
    {
        return $this->model;
    }

    /**
     * Returns Mark with give id,
     *
     * @param int $id
     * @return Mark
     * @throws ModelNotFoundException
     */
    public function get(int $id): Mark
    {
        return $this->model->findOrfail($id);
    }

    /**
     * Creates and returns Mark.
     *
     * @param array $attributes
     * @return Mark
     */
    public function create(array $attributes): Mark
    {
        return $this->model->create($attributes);
    }

    /**
     * Updates and returns Mark.
     *
     * @param array $attributes
     * @param Mark $mark
     * @return Mark
     */
    public function update(array $attributes, Mark $mark): Mark
    {
        $mark->update($attributes);

        return $mark;
    }

    /**
     * Deletes the given datacenter along with servers of the datacenter and loadbalancers of that server.
     *
     * @param Mark $mark
     * @return bool|null
     * @throws Exception
     */
    public function destroy(Mark $mark)
    {
        return $mark->delete();
    }
}
