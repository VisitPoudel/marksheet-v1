<?php

namespace App\Http\Controllers;

use App\Models\ClassModel;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Repositories\ClassRepositoryInterface;
use Illuminate\Support\Facades\DB;

class ClassController extends Controller
{

    public $class_repository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ClassRepositoryInterface $classRepository)
    {
        $this->class_repository = $classRepository;
    }

    /**
     * Validates the given data
     * @param Request $request
     * @return array
     */

    private function validateClass(Request $request): array
    {
        return $this->validate(
            $request,
            [
                "class" => "required|max:255"
            ],
            [
                "class.required" => "Class is Required",
                "class.max" => "Class should be less than 256 characters",
            ]
        );
    }

    /**
     * Fetches the class list
     * @param Request $request
     * @return JsonResponse
     */

    public function index(): JsonResponse
    {
        try {
            $classes = $this->class_repository->getModel()->paginate(10);
            return response()->json(['message' => 'Classes List Fetched Successfully', 'data' => $classes, 'status' => 200]);
        } catch (ValidationException $exception) {
            return response()->json(['status' => 422, 'message' => $exception->getMessage(), 'errors' => $exception->errors()], 422);
        } catch (ModelNotFoundException $exception) {
            return response()->json(['status' => 404, 'message' => $exception->getMessage()], 404);
        } catch (Exception $exception) {
            return response()->json(['status' => 500, 'message' => $exception->getMessage()], 500);
        }
    }

    /**
     * Creates a class list
     * @param Request $request
     * @return JsonResponse
     */

    public function store(Request $request): JsonResponse
    {
        DB::beginTransaction();
        try {
            $attributes = $this->validateClass($request);

            $class = $this->class_repository->create($attributes);
            DB::commit();
            return response()->json(['message' => 'Class Record Added Successfully', 'data' => $class, 'status' => 201]);
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
     * updates the given class list
     * @param Request $request, $class_id
     * @return JsonResponse
     */

    public function update(Request $request, $class_id): JsonResponse
    {
        DB::beginTransaction();
        try {
            $attributes = $this->validateClass($request);

            $class = $this->class_repository->get($class_id);
            DB::commit();
            $updatedClass = $this->class_repository->update($attributes, $class);
            return response()->json(['message' => 'Class Record updated Successfully', 'data' => $updatedClass, 'status' => 200]);
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
     * deletes the given class list
     * @param Request $request, $class_id
     * @return JsonResponse
     */

    public function delete($class_id): JsonResponse
    {
        DB::beginTransaction();
        try {
            $class = $this->class_repository->get($class_id);
            $this->class_repository->destroy($class);
            DB::commit();
            return response()->json(['message' => 'Class Record deleted Successfully', 'status' => 200]);
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
     * Fetches the average marks of students of given class
     * @param Request $request, $class_id
     * @return JsonResponse
     */

    public function average($class_id): JsonResponse
    {
        try {
            $class = $this->class_repository->get($class_id);

            $average = $class->marks()->avg('marks');
            $average = round($average, 2);

            return response()->json(['message' => 'Class average marks calculated successfully', 'data' => $average, 'status' => 200]);
        } catch (ValidationException $exception) {
            return response()->json(['status' => 422, 'message' => $exception->getMessage(), 'errors' => $exception->errors()], 422);
        } catch (ModelNotFoundException $exception) {
            return response()->json(['status' => 404, 'message' => $exception->getMessage()], 404);
        } catch (Exception $exception) {
            return response()->json(['status' => 500, 'message' => $exception->getMessage()], 500);
        }
    }
}
