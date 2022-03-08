<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Repositories\StudentRepositoryInterface;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class StudentController extends Controller
{

    public $student_repository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(StudentRepositoryInterface $studentRepository)
    {
        $this->student_repository = $studentRepository;
    }

    /**
     * Validates the given data
     * @param Request $request
     * @return array
     */

    private function validateStudent(Request $request): array
    {
        return $this->validate($request, [
            "first_name" => "required|min:2|max:255",
            "middle_name" => "min:2|max:255",
            "last_name" => "required|min:2|max:255",
            "gender" => "required",
            "class_id" => "required",
        ], [
            "first_name.required" => "First Name is Required",
            "first_name.min" => "First Name should be more than 1 characters",
            "first_name.max" => "First Name should be less than 256 characters",
            "middle_name.min" => "Middle Name should be more than 1 characters",
            "middle_name.max" => "Middle Name should be less than 256 characters",
            "last_name.required" => "Last Name is Required",
            "last_name.min" => "Last Name should be more than 1 characters",
            "last_name.max" => "Last Name should be less than 256 characters",
            "gender.required" => "Gender is Required",
            "class_id.required" => "Class is Required",
        ]);
    }

    /**
     * Fetches the Students List
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        try {
            $students = $this->student_repository->getModel()->paginate(10);
            return response()->json(['message' => 'Students List Fetched Successfully', 'data' => $students, 'status' => 200]);
        } catch (ValidationException $exception) {
            throw $exception;
        } catch (Exception $exception) {
            throw $exception;
        }
    }

    /**
     * Creates the Students List
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        DB::beginTransaction();

        try {
            $attributes = $this->validateStudent($request);

            $student = $this->student_repository->create($attributes);

            DB::commit();

            return response()->json(['message' => 'Student Record Added Successfully', 'data' => $student, 'status' => 201]);
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
     * Updates the Student List
     * @param Request $request, $student_id
     * @return JsonResponse
     */

    public function update(Request $request, $student_id): JsonResponse
    {
        DB::beginTransaction();

        try {
            $attributes = $this->validateStudent($request);

            $student = $this->student_repository->get($student_id);

            $updated_student = $this->student_repository->update($attributes, $student);
            DB::commit();
            return response()->json(['message' => 'Student Record Updated Successfully', 'data' => $updated_student, 'status' => 201]);
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
     * Deletes the Students List
     * @param Request $request
     * @return JsonResponse
     */

    public function delete($student_id): JsonResponse
    {
        DB::beginTransaction();
        try {
            $student = $this->student_repository->get($student_id);
            $this->student_repository->destroy($student);
            DB::commit();
            return response()->json(['message' => 'Student Record deleted Successfully', 'status' => 200]);
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
