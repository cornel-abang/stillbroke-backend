<?php

namespace App\Http\Controllers\Api\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Admin\ProductService;
use App\Http\Requests\AddProductRequest;

class ProductController extends Controller
{
    public function __construct(private ProductService $prodService)
    {
    }

    public function addProduct(AddProductRequest $request)
    {
        $response = $this->prodService->addProduct($request->validated());

        if (! $response) {
            return response()->json([
                'success' => false,
                'message' => 'Unable to add product',
            ], 500);
        }

        return response()->json([
            'success' => true,
            'message' => 'Product added successfully',
        ], 200);
    }
}