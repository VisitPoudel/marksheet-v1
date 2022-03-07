<?php

namespace App\Http\Controllers;

use App\Models\Mark;
use App\Models\Student;
use App\Models\Subject;
use Exception;
use Dompdf\Dompdf;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class MarkController extends Controller
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

    private function validateMark(Request $request): array
    {
        return $this->validate($request, [
            "marks" => "required",
            "student_id" => "required",
            "subject_id" => "required",
        ], [
            "marks.required" => "Marks is Required",
            "student_id.required" => "Student is Required",
            "subject_id.required" => "Subject is Required",
        ]);
    }

    /**
     * Fetches the Mark List
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        try {
            $mark = Mark::paginate(10);
            return response()->json(['message' => 'Marks List Fetched Successfully', 'data' => $mark, 'status' => 200]);
        } catch (ValidationException $exception) {
            throw $exception;
        } catch (Exception $exception) {
            throw $exception;
        }
    }

    /**
     * Creates a mark List
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $attributes = $this->validateMark($request);

            $mark = Mark::create($attributes);

            return response()->json(['message' => 'Mark Record Added Successfully', 'data' => $mark, 'status' => 201]);
        } catch (ValidationException $exception) {
            return response()->json(['status' => 422, 'message' => $exception->getMessage(), 'errors' => $exception->errors()], 422);
        } catch (ModelNotFoundException $exception) {
            return response()->json(['status' => 404, 'message' => $exception->getMessage()], 404);
        } catch (Exception $exception) {
            return response()->json(['status' => 500, 'message' => $exception->getMessage()], 500);
        }
    }

    /**
     * Updates the Mark List
     * @param Request $request, $mark_id
     * @return JsonResponse
     */

    public function update(Request $request, $mark_id): JsonResponse
    {
        try {
            $attributes = $this->validateMark($request);

            $mark = Mark::findOrFail($mark_id);

            $updatedMark = $mark->update($attributes);
            return response()->json(['message' => 'Mark Record Updated Successfully', 'data' => $updatedMark, 'status' => 201]);
        } catch (ValidationException $exception) {
            return response()->json(['status' => 422, 'message' => $exception->getMessage(), 'errors' => $exception->errors()], 422);
        } catch (ModelNotFoundException $exception) {
            return response()->json(['status' => 404, 'message' => $exception->getMessage()], 404);
        } catch (Exception $exception) {
            return response()->json(['status' => 500, 'message' => $exception->getMessage()], 500);
        }
    }

    /**
     * Deletes the Mark
     * @param Request $request
     * @return JsonResponse
     */

    public function delete($mark_id): JsonResponse
    {
        try {
            $mark = Mark::findOrFail($mark_id);

            $deletedMark = $mark->delete();

            return response()->json(['message' => 'Mark Record deleted Successfully', 'status' => 201]);
        } catch (ValidationException $exception) {
            return response()->json(['status' => 422, 'message' => $exception->getMessage(), 'errors' => $exception->errors()], 422);
        } catch (ModelNotFoundException $exception) {
            return response()->json(['status' => 404, 'message' => $exception->getMessage()], 404);
        } catch (Exception $exception) {
            return response()->json(['status' => 500, 'message' => $exception->getMessage()], 500);
        }
    }

    public function marksheet($student_id)
    {
        try {
            $student = Student::findOrFail($student_id);
            $marks = Mark::where('student_id', $student_id)->get();
            $percentage = Mark::where('student_id', $student_id)->avg('marks');
            $dompdf = new Dompdf();
            $dompdf->loadHtml(view('marksheet', compact('student', 'marks', 'percentage')));
            $dompdf->setPaper('A4', 'landscape');
            $dompdf->render();
            return $dompdf->stream();
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
