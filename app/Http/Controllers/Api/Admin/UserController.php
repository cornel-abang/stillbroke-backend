<?php

namespace App\Http\Controllers\Api\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Services\Admin\UserService;
use App\Http\Controllers\Controller;
use App\Http\Requests\AddAdminRequest;
use App\Http\Requests\UpdateUserRequest;

class UserController extends Controller
{
    public function __construct(private UserService $adminService)
    {
    }

    public function addAdminUser(AddAdminRequest $request): JsonResponse
    {
        $this->adminService->addUser($request->all());

        return response()->json([
            'success' => true,
            'message' => 'User added successfully',
        ], 200);
    }

    public function getAnyUser(int $id): JsonResponse
    {
        $user = $this->adminService->getUser($id);

        if (! $user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'user' => $user,
        ], 200);
    }

    public function updateUserDetails(int $id, UpdateUserRequest $request): JsonResponse
    {
        $response = $this->adminService->updateUser($id, $request->validated());

        if (! $response) {
            return response()->json([
                'success' => false,
                'message' => 'User not found or trying to update client account',
            ], 400);
        }

        return response()->json([
            'success' => true,
            'user' => $response,
        ], 200);
    }

    public function deleteUser(int $id): JsonResponse
    {
        $response = $this->adminService->deleteUser($id);

        if (! $response) {
            return response()->json([
                'success' => false,
                'message' => 'User not found',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'messsage' => 'User successfully deleted',
        ], 201);
    }
}
