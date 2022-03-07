<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class SubjectController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
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
            $subject = Subject::paginate(10);
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
        try {
            $attributes = $this->validateSubject($request);

            $subject = Subject::create($attributes);

            return response()->json(['message' => 'Subject Record Added Successfully', 'data' => $subject, 'status' => 201]);
        } catch (ValidationException $exception) {
            return response()->json(['status' => 422, 'message' => $exception->getMessage(), 'errors' => $exception->errors()], 422);
        } catch (ModelNotFoundException $exception) {
            return response()->json(['status' => 404, 'message' => $exception->getMessage()], 404);
        } catch (Exception $exception) {
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
        try {
            $attributes = $this->validateSubject($request);

            $subject = Subject::findOrFail($subject_id);

            $updatedSubject = $subject->update($attributes);
            return response()->json(['message' => 'Subject Record Updated Successfully', 'data' => $updatedSubject, 'status' => 201]);
        } catch (ValidationException $exception) {
            return response()->json(['status' => 422, 'message' => $exception->getMessage(), 'errors' => $exception->errors()], 422);
        } catch (ModelNotFoundException $exception) {
            return response()->json(['status' => 404, 'message' => $exception->getMessage()], 404);
        } catch (Exception $exception) {
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
        try {
            $subject = Subject::findOrFail($subject_id);

            $deletedSubject = $subject->delete();

            return response()->json(['message' => 'Subject Record deleted Successfully', 'status' => 201]);
        } catch (ValidationException $exception) {
            return response()->json(['status' => 422, 'message' => $exception->getMessage(), 'errors' => $exception->errors()], 422);
        } catch (ModelNotFoundException $exception) {
            return response()->json(['status' => 404, 'message' => $exception->getMessage()], 404);
        } catch (Exception $exception) {
            return response()->json(['status' => 500, 'message' => $exception->getMessage()], 500);
        }
    }

    //
}
