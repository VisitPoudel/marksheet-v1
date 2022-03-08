<?php

namespace App\Repositories;

use App\Models\ClassModel;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;

interface ClassRepositoryInterface
{
    /**
     * Returns Class Model.
     *
     * @return ClassModel
     */
    public function getModel(): ClassModel;

    /**
     * Returns Class with given id,
     *
     * @param int $id
     * @return ClassModel
     * @throws ModelNotFoundException
     */
    public function get(int $id): ClassModel;

    /**
     * Creates and returns Class.
     *
     * @param array $attributes
     * @return ClassModel
     */
    public function create(array $attributes): ClassModel;

    /**
     * Updates and returns Class.
     *
     * @param array $attributes
     * @param ClassModel $class
     * @return ClassModel
     */
    public function update(array $attributes, ClassModel $class): ClassModel;

    /**
     * Deletes the given class.
     *
     * @param ClassModel $class
     * @return bool|null
     * @throws Exception
     */
    public function destroy(ClassModel $class);
}
