<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Services\AuthService;
use App\Models\VerificationCode;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\VerificationRequest;
use App\Http\Requests\PasswordResetRequest;
use App\Http\Requests\ProfileUpdateRequest;
use App\Http\Requests\PasswordUpdateRequest;
use Illuminate\Contracts\Auth\Authenticatable;

class AuthController extends Controller
{
    public function __construct(private AuthService $authService)
    {
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        $response = $this->authService->registerUser($request->validated());

        if (!$response) {
            return response()->json([
                'success' => false,
                'message' => 'User created but unable to login'
            ], 401);
        }

        return response()->json([
            'success' => true,
            'access_token' => $response,
        ], 200);
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $response = $this->authService->loginUser($request->all());

        if (!$response) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid user credentials'
            ], 401);
        }

        return response()->json([
            'success' => true,
            'user' => $response['user'],
            'access_token' => $response['token'],
        ], 200);
    }

    public function verify(VerificationRequest $request)
    {
        $response = $this->authService->checkVerification($request->all());

        if (! $response) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid verification link'
            ], 400);
        }

        return response()->json([
            'success' => true,
            'message' => 'User email successfully verified',
        ], 200);
    }

    public function updateClientProfile(int $user_id, ProfileUpdateRequest $request): JsonResponse
    {
        $response = $this->authService->updateClientInfo($user_id, $request->validated());

        if (! $response) {
            return response()->json([
                'success' => false,
                'message' => 'User profile not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'User profile updated'
        ], 201);
    }

    public function startPasswordReset(PasswordResetRequest $request): JsonResponse
    {
        $response = $this->authService->sendPasswordResteEmail($request->email);

        if (! $response) {
            return response()->json([
                'success' => false,
                'message' => 'No user found with provided email'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Password reset link sent to the provided email'
        ], 201);
    }

    public function completePasswordReset(PasswordUpdateRequest $request): JsonResponse
    {
        $this->authService->updateUserPassword($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Password successfully reset',
        ], 200);
    }

    public function getCurrentUser(): Authenticatable | null
    {
        return auth()->user();
    }

    public function logout(): JsonResponse
    {
        $this->authService->logoutUser();

        return response()->json([
            'success' => true,
            'message' => 'User logged out and token invalidated',
        ], 200);
    }
}
