<?php

namespace App\Http\Controllers;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{

    public function __construct()
    {
        //
    }

    private function validateAuth(Request $request): array
    {
        return $this->validate(
            $request,
            [
                "email" => "required|email",
                "password" => "required"
            ],
            [
                "email.required" => "Class is required",
                "email.email" => "Invalid email",
                "password.required" => "Password is required",
            ]
        );
    }

    /**
     * Provides JTW token for the Admin with given email and password.
     * @param Request $request
     * @return JsonResponse
     */
    public function login(Request $request): JsonResponse
    {
        try {
            // validating data
            $data = $this->validateAuth($request);
            // generating JWT token
            if (!($token = Auth::guard('api')->setTTL(100000)->attempt($data))) {
                throw new AuthenticationException("Invalid email or password");
            }
            return response()->json([
                'status' => 200,
                'message' => 'Admin logged in successfully',
                'data' => [
                    'token' => $token,
                ]
            ]);
        } catch (ValidationException $exception) {
            return response()->json(['status' => 422, 'message' => $exception->getMessage(), 'errors' => $exception->errors()], 422);
        } catch (AuthenticationException $exception) {
            return response()->json(["status" => 401, "message" => $exception->getMessage()], 401);
        }
    }
}
