<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Repositories\SubjectRepositoryInterface;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class SubjectController extends Controller
{
    public $subject_repository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(SubjectRepositoryInterface $subjectRepository)
    {
        $this->subject_repository = $subjectRepository;
    }

    /**
     * Validates the given data
     * @param Request $request
     * @return array
     */

    private function validateSubject(Request $request): array
    {
        return $this->validate($request, [
            "name" => "required|min:2|max:255",
        ], [
            "name.required" => "Name is Required",
            "name.min" => "Name should be more than 1 characters",
            "name.max" => "Name should be less than 256 characters",
        ]);
    }

    /**
     * Fetches the Subject List
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        try {
            $subject = $this->subject_repository->getModel()->paginate(10);
            return response()->json(['message' => 'Subjects List Fetched Successfully', 'data' => $subject, 'status' => 200]);
        } catch (ValidationException $exception) {
            throw $exception;
        } catch (Exception $exception) {
            throw $exception;
        }
    }

    /**
     * Creates a subject List
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        DB::beginTransaction();

        try {
            $attributes = $this->validateSubject($request);

            $subject = $this->subject_repository->create($attributes);
            DB::commit();
            return response()->json(['message' => 'Subject Record Added Successfully', 'data' => $subject, 'status' => 201]);
        } catch (ValidationException $exception) {
            DB::rollBack();
            return response()->json(['status' => 422, 'message' => $exception->getMessage(), 'errors' => $exception->errors()], 422);
        } catch (ModelNotFoundException $exception) {
            DB::rollBack();
            return response()->json(['status' => 404, 'message' => $exception->getMessage()], 404);
        } catch (Exception $exception) {
            DB::rollBack();
            return response()->json(['status' => 500, 'message' => $exception->getMessage()], 500);
        }
    }

    /**
     * Updates the Subject List
     * @param Request $request, $subject_id
     * @return JsonResponse
     */

    public function update(Request $request, $subject_id): JsonResponse
    {
        DB::beginTransaction();
        try {
            $attributes = $this->validateSubject($request);

            $subject = $this->subject_repository->get($subject_id);
            DB::commit();
            $updatedSubject = $this->subject_repository->update($attributes, $subject);
            return response()->json(['message' => 'Subject Record Updated Successfully', 'data' => $updatedSubject, 'status' => 201]);
        } catch (ValidationException $exception) {
            DB::rollBack();
            return response()->json(['status' => 422, 'message' => $exception->getMessage(), 'errors' => $exception->errors()], 422);
        } catch (ModelNotFoundException $exception) {
            DB::rollBack();
            return response()->json(['status' => 404, 'message' => $exception->getMessage()], 404);
        } catch (Exception $exception) {
            DB::rollBack();
            return response()->json(['status' => 500, 'message' => $exception->getMessage()], 500);
        }
    }

    /**
     * Deletes the Subject
     * @param Request $request
     * @return JsonResponse
     */

    public function delete($subject_id): JsonResponse
    {
        DB::beginTransaction();
        try {
            $subject = $this->subject_repository->get($subject_id);

            $this->subject_repository->destroy($subject);
            DB::commit();
            return response()->json(['message' => 'Subject Record deleted Successfully', 'status' => 201]);
        } catch (ValidationException $exception) {
            DB::rollBack();
            return response()->json(['status' => 422, 'message' => $exception->getMessage(), 'errors' => $exception->errors()], 422);
        } catch (ModelNotFoundException $exception) {
            DB::rollBack();
            return response()->json(['status' => 404, 'message' => $exception->getMessage()], 404);
        } catch (Exception $exception) {
            DB::rollBack();
            return response()->json(['status' => 500, 'message' => $exception->getMessage()], 500);
        }
    }

    //
}
