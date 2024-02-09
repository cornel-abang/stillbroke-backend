<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Services\AdminService;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\AddAdminRequest;

class AdminController extends Controller
{
    public function __construct(private AdminService $adminService)
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
}
