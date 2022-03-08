<?php

namespace App\Repositories;

use App\Models\Subject;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;

interface SubjectRepositoryInterface
{
    /**
     * Returns Subject Model.
     *
     * @return Subject
     */
    public function getModel(): Subject;

    /**
     * Returns Subject with given id,
     *
     * @param int $id
     * @return Subject
     * @throws ModelNotFoundException
     */
    public function get(int $id): Subject;

    /**
     * Creates and returns Subject.
     *
     * @param array $attributes
     * @return Subject
     */
    public function create(array $attributes): Subject;

    /**
     * Updates and returns Subject.
     *
     * @param array $attributes
     * @param Subject $subject
     * @return Subject
     */
    public function update(array $attributes, Subject $subject): Subject;

    /**
     * Deletes the given subject.
     *
     * @param Subject $subject
     * @return bool|null
     * @throws Exception
     */
    public function destroy(Subject $subject);
}
