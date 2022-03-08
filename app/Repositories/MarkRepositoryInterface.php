<?php

namespace App\Repositories;

use App\Models\Mark;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;

interface MarkRepositoryInterface
{
    /**
     * Returns Mark Model.
     *
     * @return Mark
     */
    public function getModel(): Mark;

    /**
     * Returns Mark with given id,
     *
     * @param int $id
     * @return Mark
     * @throws ModelNotFoundException
     */
    public function get(int $id): Mark;

    /**
     * Creates and returns Mark.
     *
     * @param array $attributes
     * @return Mark
     */
    public function create(array $attributes): Mark;

    /**
     * Updates and returns Mark.
     *
     * @param array $attributes
     * @param Mark $mark
     * @return Mark
     */
    public function update(array $attributes, Mark $mark): Mark;

    /**
     * Deletes the given mark.
     *
     * @param Mark $mark
     * @return bool|null
     * @throws Exception
     */
    public function destroy(Mark $mark);
}
